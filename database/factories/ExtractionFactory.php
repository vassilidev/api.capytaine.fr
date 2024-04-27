<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Extraction;
use App\Models\Run;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

/**
 * @extends Factory<Extraction>
 */
class ExtractionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     * @throws \JsonException
     */
    public function definition(): array
    {
        return [
            'run_id' => Run::inRandomOrder()->first()?->id ?? Run::factory(),
            'data'   => json_encode(Event::factory()->count(random_int(1, 10))->make()->toArray(), JSON_THROW_ON_ERROR),
        ];
    }
}
