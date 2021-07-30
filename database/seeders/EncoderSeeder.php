<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class EncoderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'roles' => config('roles.roles')[2],
            'email' => 'encoder@test.com',
            'password' => 'water123',
        ]);

    }
}
