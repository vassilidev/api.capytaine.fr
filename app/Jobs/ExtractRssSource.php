<?php

namespace App\Jobs;

use App\Actions\Source\ExtractRSS;
use App\Models\Source;
use FeedException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExtractRssSource implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Source $source,
        protected bool   $includePast = false,
    )
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            app(ExtractRSS::class)
                ->execute(
                    source: $this->source,
                    includePast: $this->includePast,
                );
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [
                'source' => $this->source,
            ]);
        }
    }
}
