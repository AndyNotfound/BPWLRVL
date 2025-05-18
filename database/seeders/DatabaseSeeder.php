<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'owner']);
        Role::firstOrCreate(['name' => 'client']);

        User::Create([
            'email' => 'admin@example.com',
            'phone_number' => '1234567890',
            'username' => 'Admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'is_active' => true,
            'password' => bcrypt('123'),
            'role' => 1
        ]);

        User::Create([
            'email' => 'owner@example.com',
            'phone_number' => '0987654321',
            'username' => 'Owner',
            'first_name' => 'Owner',
            'last_name' => 'User',
            'is_active' => true,
            'password' => bcrypt('123'),
            'role' => 2,
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
