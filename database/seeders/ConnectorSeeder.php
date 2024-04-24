<?php

namespace Database\Seeders;

use App\Models\Connector;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Random\RandomException;

class ConnectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        Connector::factory(random_int(5, 10))->create();

        $users = User::all();

        Connector::each(static function (Connector $connector) use ($users) {
            $users->each(static function (User $user) use ($connector) {
                if (fake()->boolean(30)) {
                    $user->connectors()->attach($connector->id);
                }
            });

            $connector->tags()->attach(
                Tag::inRandomOrder()->limit(random_int(1, 3))->get()
            );

            $connector->tags()->updateExistingPivot(
                $connector->tags->random()->id,
                ['is_primary' => true]
            );
        });
    }
}
