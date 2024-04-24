<?php

namespace Database\Seeders;

use App\Models\Calendar;
use App\Models\Connector;
use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Random\RandomException;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        Calendar::each(static function (Model $model) {
            Event::factory(random_int(0, 10))->create([
                'eventable_id'   => $model->id,
                'eventable_type' => Calendar::class,
            ]);
        });

        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        $period = Carbon::parse($start)->toPeriod($end);

        Connector::each(static function (Model $model) use ($period) {
            foreach ($period as $day) {
                if (fake()->boolean(33)) {
                    continue;
                }

                Event::factory()->create([
                    'eventable_id'   => $model->id,
                    'eventable_type' => Connector::class,
                    'start_at'       => $day->startOfDay(),
                    'end_at'         => $day->endOfDay(),
                ]);
            }
        });
    }
}
