<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TagSeeder::class,
            ConnectorSeeder::class,
            CalendarSeeder::class,
            EventSeeder::class,

            ScraperSeeder::class,
            RunSeeder::class,
            ExtractionSeeder::class,

            SourceSeeder::class,
        ]);
    }
}
