<?php

namespace App\Actions;

use App\Models\Connector;
use App\Models\Extraction;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;

class PublishExtractionResults
{
    public function execute(Extraction $extraction, bool $notification = false): int
    {
        /** @var Connector $connector */
        $connector = $extraction->run->scraper->connector;

        $validResults = $extraction->results()->valid()->pluck('data');
        $nbValidResults = $validResults->count();

        foreach ($validResults as $event) {
            $event['start_at'] = Carbon::parse($event['start_at']);
            $event['end_at'] = Carbon::parse($event['end_at']);

            $connector->events()->create($event);
        }

        $extraction->results()->delete();

        $extraction->delete();

        $extraction->run->delete();

        if ($notification) {
            Notification::make()
                ->success()
                ->title("{$nbValidResults} results have been published.")
                ->send();
        }

        return $nbValidResults;
    }
}