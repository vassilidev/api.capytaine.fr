<?php

namespace App\Console\Commands;

use App\Models\Source;
use FeedException;
use Illuminate\Console\Command;

class ExtractRssNewsFromSources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:extract-rss-news-from-sources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract every rss news from each sources';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        Source::each(static function (Source $source) {
            $source->extract(sync: false);
        });

        return self::SUCCESS;
    }
}
