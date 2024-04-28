<?php

namespace Database\Factories;

use App\Models\Connector;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Connector>
 */
class ConnectorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $colors = [
            "background"   => "#282a36",
            "current_line" => "#44475a",
            "selection"    => "#bd93f9",
            "comment"      => "#6272a4",
            "cyan"         => "#8be9fd",
            "green"        => "#50fa7b",
            "orange"       => "#ffb86c",
            "pink"         => "#ff79c6",
            "purple"       => "#bd93f9",
            "red"          => "#ff5555",
            "yellow"       => "#f1fa8c"
        ];

        return [
            'name'        => fake()->jobTitle(),
            'color'       => fake()->randomElement($colors),
            'description' => fake()->paragraph(),
        ];
    }
}
