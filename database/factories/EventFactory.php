<?php

namespace Database\Factories;

use App\Models\Connector;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Calendar;
use Illuminate\Support\Carbon;
use Random\RandomException;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array
    {
        $isOneDay = fake()->boolean(100);

        $startAt = fake()->dateTimeBetween('-1 month', '+2 months');

        $type = fake()->randomElement([Calendar::class, Connector::class]);

        return [
            'name'           => fake()->realText(30),
            'start_at'       => Carbon::parse($startAt)->startOfDay(),
            'end_at'         => Carbon::parse($startAt)->endOfDay(),
            'is_all_day'     => $isOneDay,
            'eventable_type' => $type,
            'eventable_id'   => (new $type)->inRandomOrder()->first()->id,
        ];
    }
}
