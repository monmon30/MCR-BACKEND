<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PhysicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'roles' => config('roles.roles')[1],
            'email' => 'doc@test.com',
            'password' => 'water123',
        ]);

    }
}
