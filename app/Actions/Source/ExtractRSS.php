<?php

namespace App\Actions\Source;

use App\Models\Source;
use Feed;
use FeedException;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ExtractRSS
{
    /**
     * @throws FeedException
     */
    public function execute(Source $source, bool $includePast = false, bool $withNotification = false): Source
    {
        $rss = Feed::loadRss($source->rss);

        $i = 0;

        foreach ($rss->item as $item) {
            $pubDate = Carbon::parse($item->pubDate);

            if (!$includePast && $pubDate->isBefore(now()->subDay())) {
                continue;
            }

            try {
                $result = $source->news()->firstOrCreate([
                    'url' => $item->link,
                ], [
                    'title'       => $item->title,
                    'description' => $item->description,
                    'image'       => $item->enclosure['url'] ?? null,
                    'active_at'   => $pubDate,
                ]);

                if ($result->wasRecentlyCreated) {
                    $i++;
                }
            } catch (\Exception $exception) {
                Log::error($exception->getMessage(), [
                    $source,
                ]);
            }
        }

        $source->update(['last_extracted_at' => now()]);

        if ($withNotification) {
            Notification::make()
                ->success()
                ->title($i . ' news extracted from ' . $source->name . ' RSS feed')
                ->send();
        }

        return $source;
    }
}