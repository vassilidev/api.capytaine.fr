<?php

namespace Database\Seeders;

use App\Models\Source;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::unprepared(
            file_get_contents(database_path('seeders/sources.sql'))
        );

        $tagsCount = Tag::count();

        Source::each(static function (Source $source) use ($tagsCount) {
            $source->tags()->attach(
                Tag::inRandomOrder()->limit(random_int(1, $tagsCount))->pluck('id')
            );
        });
    }
}
