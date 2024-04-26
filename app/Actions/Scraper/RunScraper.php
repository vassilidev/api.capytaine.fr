<?php

namespace App\Actions\Scraper;

use App\Enums\Run\Status;
use App\Enums\Scraper\Type;
use App\Models\Scraper;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class RunScraper
{
    /**
     * @throws ConnectionException
     */
    public function execute(Scraper $scraper): void
    {
        // Run the scraper
        $httpClient = Http::withHeaders($scraper->headers ?? []);

        match ($scraper->type) {
            Type::WEBHOOK => $this->executeWebhook($httpClient, $scraper),
            default => throw new RuntimeException('Unsupported scraper type'),
        };
    }

    /**
     * @throws ConnectionException
     */
    protected function executeWebhook(PendingRequest $httpClient, Scraper $scraper): void
    {
        $response = $httpClient->{$scraper->method->value}($scraper->url);

        $scraper->runs()->create([
            'status'   => Status::RUNNING,
            'request'  => [
                'url'     => $scraper->url,
                'headers' => $httpClient->getHeaders(),
                'method'  => $scraper->method->value,
            ],
            'response' => [
                'status' => $response->status(),
                'body'   => $response->body(),
            ],
        ]);
    }
}