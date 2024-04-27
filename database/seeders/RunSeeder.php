<?php

namespace Database\Seeders;

use App\Models\Run;
use App\Models\Scraper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Random\RandomException;

class RunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        Scraper::each(static function (Scraper $scraper): void {
            Run::factory(random_int(1, 10))
                ->for($scraper)
                ->create();
        });
    }
}
