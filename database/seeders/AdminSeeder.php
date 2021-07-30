<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'roles' => config('roles.roles')[0],
            'email' => 'admin@test.com',
            'password' => 'water123',
        ]);

    }
}
