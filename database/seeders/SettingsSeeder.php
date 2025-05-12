<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::create([
            "Oid" => (string) Str::uuid(),
            'SecretKey' => "xnd_development_62YxANBgUFrEwDR4SQsmKjw9gafR15PWEvcfT3FcfdI2WUJ8tNPumlzEruDOl",
            'Password' => ""
        ]);
    }
}
