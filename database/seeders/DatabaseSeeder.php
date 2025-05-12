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
            'username' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123')
        ]);

        User::Create([
            'username' => 'Owner',
            'email' => 'Owner@example.com',
            'password' => bcrypt('123')
        ]);

        User::Create([
            'username' => 'Client',
            'email' => 'client@example.com',
            'password' => bcrypt('123')
        ]);
    }
}
