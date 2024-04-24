<?php

namespace Database\Seeders;

use App\Models\Calendar;
use App\Models\Connector;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $connectorsCount = Connector::count();

        User::query()->each(static function (User $user) use ($connectorsCount) {
            $calendars = Calendar::factory(random_int(1, 4))->create([
                'user_id' => $user->id,
            ]);

            $calendars->each(static function (Calendar $calendar) use ($connectorsCount) {
                if (fake()->boolean(60)) {
                    $calendar->connectors()->attach(
                        $calendar->user->connectors()->inRandomOrder()->limit(random_int(1, $connectorsCount))->get()
                    );
                }
            });
        });
    }
}
