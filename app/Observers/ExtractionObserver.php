<?php

namespace App\Observers;

use App\Models\Extraction;

class ExtractionObserver
{
    /**
     * Handle the Extraction "created" event.
     */
    public function created(Extraction $extraction): void
    {
        $extraction->resetResults();
    }
}
