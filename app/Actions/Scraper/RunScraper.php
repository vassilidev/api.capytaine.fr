<?php

namespace App\Actions\Scraper;

use App\Enums\Run\Status;
use App\Enums\Scraper\Type;
use App\Models\Run;
use App\Models\Scraper;
use Filament\Notifications\Notification;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\RouteCollectionInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use RuntimeException;

class RunScraper
{
    private RouteCollectionInterface $routesCollection;
    private Run $run;

    public function __construct()
    {
        $this->routesCollection = Route::getRoutes();

        $this->run = (new Run)->forceFill([
            'id'         => (string)Str::uuid(),
            'started_at' => now(),
        ]);
    }

    public function execute(Scraper $scraper): bool
    {
        $headers = (array)($scraper->headers ?? []);

        $httpClient = Http::withHeaders($headers + [
                'X-Scraper-Id' => $scraper->id,
                'X-Referer'    => config('app.url'),
                'X-Run-Id'     => $this->run->id,
            ]);

        $this->run->fill([
            'scraper_id' => $scraper->id,
        ]);

        return match ($scraper->type) {
            Type::WEBHOOK => $this->executeWebhook($httpClient, $scraper),
            Type::MANUAL => $this->executeManual($httpClient, $scraper),
            default => throw new RuntimeException('Unsupported scraper type'),
        };
    }

    protected function executeWebhook(PendingRequest $httpClient, Scraper $scraper): bool
    {
        $callbackRoute = $this->routesCollection->getByName('api.v1.scrapers.runs.results');

        $httpClient
            ->withHeader('X-Callback-Uri', $callbackRoute->uri())
            ->withHeader('X-Callback-Url', route('api.v1.scrapers.runs.results', [
                'scraper' => $scraper->id,
                'run'     => $this->run->id,
            ]))
            ->withHeader('X-Callback-Method', $callbackRoute->methods()[0])
            ->withHeader('X-Callback-Require-Auth', true)
            ->timeout(10);

        $this->run->fill([
            'status'  => Status::RUNNING,
            'request' => [
                'url'    => $scraper->url,
                'method' => $scraper->method->value,
                ...$httpClient->getOptions(),
            ],
        ])->save();

        $this->run->refresh();

        try {
            $response = $httpClient->{$scraper->method->value}($scraper->url);
        } catch (ConnectionException $exception) {
            Notification::make()
                ->danger()
                ->title('Error while running scraper')
                ->send();

            Log::error($exception->getMessage());

            $this->run->update([
                'status'   => Status::FAILED,
                'response' => [
                    'error' => $exception->getMessage(),
                ],
                'ended_at' => now(),
            ]);

            return false;
        }

        $this->run->update([
            'status'   => Status::RUNNING,
            'response' => $response->json(),
        ]);

        Notification::make()
            ->success()
            ->title('Scraper is running...')
            ->send();

        return true;
    }

    protected function executeManual(PendingRequest $httpClient, Scraper $scraper): bool
    {
        $httpClient->timeout(10);

        $this->run->fill([
            'status'  => Status::RUNNING,
            'request' => [
                'url'    => $scraper->url,
                'method' => $scraper->method->value,
                ...$httpClient->getOptions(),
            ],
        ])->save();

        try {
            $response = $httpClient->{$scraper->method->value}($scraper->url);

            $this->run->end();

            $events = $response->json('events', []);

            $this->run->extraction()->create([
                'data' => $events,
            ]);

            Notification::make()
                ->success()
                ->title(count($events) . ' events were extracted')
                ->send();
        } catch (ConnectionException $exception) {
            Notification::make()
                ->danger()
                ->title('Error while running scraper')
                ->send();

            Log::error($exception->getMessage());

            $this->run->update([
                'status'   => Status::FAILED,
                'response' => [
                    'error' => $exception->getMessage(),
                ],
                'ended_at' => now(),
            ]);

            return false;
        }
        
        return true;
    }
}