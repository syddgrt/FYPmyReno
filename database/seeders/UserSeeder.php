<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 3 clients
        User::factory()->count(3)->create(['role' => 'CLIENT']);

        // Create 6 designers
        User::factory()->count(6)->create(['role' => 'DESIGNER']);

        // Create 1 admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'ADMIN',
        ]);
    }
}
