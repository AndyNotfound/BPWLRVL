<?php

namespace Database\Seeders;

use App\Models\Itineraries;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ItinerarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Itineraries::query()->delete();

        for ($i = 1; $i <= 20; $i++) {
            Itineraries::create([
                'Oid' => (string) Str::uuid(),
                'CreateBy' => 1,
                'CreatedAt' => Carbon::now(),
                'Role' => 1,
                'Code' => 'ITINERARY001' . $i,
                'Name' => 'Sample Itinerary' . $i,
                'Price' => rand(100, 999) * 1000,
            ]);
        }
    }
}
