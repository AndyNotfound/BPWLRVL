<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Packages;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PackagesSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            Packages::create([
                'Oid' => Str::uuid(),
                'CreateBy' => 1,
                'CreatedAt' => Carbon::now(),
                'Name' => 'Package ' . $i,
                'Title' => 'Title ' . $i,
                'Description' => 'This is a description for package ' . $i,
                'Location' => 'Location ' . $i,
                'HeadImage' => 'head_image_' . $i . '.jpg',
                'SubImage1' => 'sub_image1_' . $i . '.jpg',
                'SubImage2' => 'sub_image2_' . $i . '.jpg',
                'ValidDateStart' => now()->addDays($i),
                'ValidDateEnd' => now()->addDays($i + 10),
                'Price' => rand(100, 999) * 1000,
                'MaxCapacity' => rand(10, 100),
            ]);
        }
    }
}
