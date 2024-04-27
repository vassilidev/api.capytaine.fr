<?php

namespace Database\Seeders;

use App\Models\Scraper;
use Illuminate\Database\Seeder;

class ScraperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Scraper::factory(10)->create();
    }
}
