<?php

namespace Database\Seeders;

use App\Models\Extraction;
use App\Models\Run;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExtractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Run::each(static function (Run $run): void {
            if ($run->isCompleted()) {
                Extraction::factory()
                    ->for($run)
                    ->create();
            }
        });
    }
}
