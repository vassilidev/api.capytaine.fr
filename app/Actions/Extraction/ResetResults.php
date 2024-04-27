<?php

namespace App\Actions\Extraction;

use App\Models\Extraction;
use Filament\Notifications\Notification;

class ResetResults
{
    public function execute(Extraction $extraction, bool $withNotification = false): int
    {
        $extraction->results()->forceDelete();

        if (is_string($extraction->data)) {
            $extraction->data = json_decode($extraction->data);
        }

        foreach ($extraction->data ?? [] as $result) {
            $extraction->results()->create([
                'data' => $result,
            ]);
        }

        $nbResults = count($extraction->data);

        if ($withNotification) {
            Notification::make()
                ->success()
                ->title($nbResults . ' results published.')
                ->send();
        }

        return $nbResults;
    }
}