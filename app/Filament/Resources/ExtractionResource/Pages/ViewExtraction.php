<?php

namespace App\Filament\Resources\ExtractionResource\Pages;

use App\Filament\Resources\ExtractionResource;
use App\Models\Extraction;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewExtraction extends ViewRecord
{
    protected static string $resource = ExtractionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Reset Results')
                ->icon('heroicon-o-arrow-path')
                ->action(fn(Extraction $record) => $record->resetResults(withNotification: true))
                ->button()
                ->color('danger')
                ->requiresConfirmation(),
            Actions\Action::make('Publish')
                ->action(fn(Extraction $record) => $record->publish(withNotification: true))
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->button()
                ->requiresConfirmation(),
        ];
    }
}
