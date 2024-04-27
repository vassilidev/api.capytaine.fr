<?php

namespace App\Filament\Resources\ScraperResource\Pages;

use App\Filament\Resources\ScraperResource;
use App\Models\Scraper;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewScraper extends ViewRecord
{
    protected static string $resource = ScraperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Run')
                ->button()
                ->icon('heroicon-o-play')
                ->requiresConfirmation()
                ->color('info')
                ->action(fn(Scraper $scraper) => $scraper->run()),
        ];
    }
}
