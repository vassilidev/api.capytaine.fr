<?php

namespace Database\Factories;

use App\Enums\Run\Status;
use App\Models\Run;
use App\Models\Scraper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Run>
 */
class RunFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'scraper_id' => Scraper::inRandomOrder()->first()?->id ?? Scraper::factory(),
            'status'     => fake()->randomElement(Status::cases()),
            'response'   => [
                'status'  => fake()->randomElement([200, 404]),
                'headers' => [],
                'body'    => [],
            ],
            'request'    => [
                'method'  => fake()->randomElement(['GET', 'POST']),
                'headers' => [],
                'body'    => [],
            ],
            'started_at' => now(),
            'ended_at'   => now()->add(fake()->numberBetween(1, 60), 'minutes'),
            'deleted_at' => fake()->boolean(40) ? now() : null,
        ];
    }
}
