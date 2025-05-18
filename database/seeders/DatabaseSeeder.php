<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::Create([
            'email' => 'admin@example.com',
            'phone_number' => '1234567890',
            'username' => 'Admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'is_active' => true,
            'password' => bcrypt('123'),
            'role' => 2
        ]);

        User::Create([
            'email' => 'Owner@example.com',
            'phone_number' => '0987654321',
            'username' => 'Owner',
            'first_name' => 'Owner',
            'last_name' => 'User',
            'is_active' => true,
            'password' => bcrypt('123'),
            'role' => 1
        ]);

        User::Create([
            'email' => 'client@example.com',
            'phone_number' => '1234567891',
            'username' => 'Client',
            'first_name' => 'Client',
            'last_name' => 'User',
            'is_active' => true,
            'password' => bcrypt('123'),
            'role' => 3
        ]);
    }
}
