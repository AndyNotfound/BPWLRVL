<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::create([
            'Oid' => (string) Str::uuid(),
            'SecretKey' => 'xnd_development_cuLsW78TsykciQcivQf32aSCVnACCj6WY6c6tes8SBr7yp5gzHkpgfgu8gQ3uGg',
            'Password' => '',
        ]);
    }
}
