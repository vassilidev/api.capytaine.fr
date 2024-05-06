<?php

namespace Database\Factories;

use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Source>
 */
class SourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'        => fake()->company,
            'url'         => fake()->url,
            'logo'        => fake()->imageUrl,
            'description' => fake()->realText,
            'rss'         => 'https://lorem-rss.herokuapp.com/feed?unit=second',
        ];
    }
}
