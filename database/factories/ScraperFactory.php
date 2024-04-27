<?php

namespace Database\Factories;

use App\Enums\Scraper\Method;
use App\Enums\Scraper\Type;
use App\Models\Connector;
use App\Models\Scraper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Scraper>
 */
class ScraperFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'         => fake()->domainName,
            'description'  => fake()->realText,
            'method'       => fake()->randomElement(Method::cases()),
            'type'         => fake()->randomElement(Type::cases()),
            'url'          => fake()->url,
            'headers'      => [],
            'connector_id' => Connector::inRandomOrder()->first()?->id ?? Connector::factory(),
        ];
    }
}
