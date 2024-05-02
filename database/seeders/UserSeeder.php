<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'firstname'     => 'Vassili',
            'lastname'      => 'JOFFROY',
            'username'      => 'vassilidev',
            'date_of_birth' => '2002-05-02',
            'email'         => 'test@example.com',
        ]);

        User::factory(9)->create();
    }
}
