<?php

namespace Database\Seeders;

use App\Models\Packages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackagesSeeder extends Seeder
{
    public function run(): void
    {
        Packages::query()->delete();

        $packages = [
            [
                'Name' => 'Bali Beach Escape',
                'Title' => 'Relax on Bali\'s Most Stunning Beaches',
                'Description' => 'Unwind on white sandy beaches, enjoy local seafood, and explore Uluwatu temple with sunset views.',
                'Location' => 'Bali, Indonesia',
                'isCustomItineraries' => false,
                'isFavorites' => true,
                'isSeasonal' => true,
                'isMustSee' => true,
            ],
            [
                'Name' => 'Yogyakarta Culture Trip',
                'Title' => 'Explore the Heart of Javanese Tradition',
                'Description' => 'Visit Borobudur and Prambanan temples, experience batik-making, and enjoy traditional cuisine.',
                'Location' => 'Yogyakarta, Indonesia',
                'isCustomItineraries' => false,
                'isFavorites' => true,
                'isSeasonal' => false,
                'isMustSee' => true,
            ],
            [
                'Name' => 'Komodo Island Adventure',
                'Title' => 'Sail the Flores Sea and Meet Dragons',
                'Description' => 'Snorkel in pristine reefs, hike Komodo National Park, and encounter the legendary Komodo dragon.',
                'Location' => 'Labuan Bajo, Indonesia',
                'isCustomItineraries' => true,
                'isFavorites' => true,
                'isSeasonal' => true,
                'isMustSee' => true,
            ],
            [
                'Name' => 'Raja Ampat Expedition',
                'Title' => 'The Ultimate Diving Paradise',
                'Description' => 'Discover the world\'s richest coral reefs, kayak through limestone karsts, and meet native islanders.',
                'Location' => 'West Papua, Indonesia',
                'isCustomItineraries' => true,
                'isFavorites' => false,
                'isSeasonal' => true,
                'isMustSee' => true,
            ],
            [
                'Name' => 'Bromo Sunrise Experience',
                'Title' => 'Witness the Magical Sunrise Over a Volcano',
                'Description' => 'Early morning jeep ride to Mount Bromo\'s viewpoint, local breakfast, and a crater walk.',
                'Location' => 'East Java, Indonesia',
                'isCustomItineraries' => false,
                'isFavorites' => true,
                'isSeasonal' => false,
                'isMustSee' => true,
            ],
            [
                'Name' => 'Tana Toraja Heritage Trail',
                'Title' => 'Discover the Rituals of the Highlands',
                'Description' => 'Immerse in ancient burial sites, unique cliff graves, and wooden tongkonan houses.',
                'Location' => 'Sulawesi, Indonesia',
                'isCustomItineraries' => true,
                'isFavorites' => false,
                'isSeasonal' => false,
                'isMustSee' => true,
            ],
            [
                'Name' => 'Belitung Island Getaway',
                'Title' => 'Relax on Secluded Island Beaches',
                'Description' => 'Swim in clear waters, explore granite rock formations, and visit the Andrea Hirata Museum.',
                'Location' => 'Belitung, Indonesia',
                'isCustomItineraries' => false,
                'isFavorites' => true,
                'isSeasonal' => true,
                'isMustSee' => false,
            ],
            [
                'Name' => 'Lake Toba Retreat',
                'Title' => 'Stay on the World\'s Largest Volcanic Lake',
                'Description' => 'Visit Batak villages, relax in lakeside resorts, and enjoy panoramic ferry rides.',
                'Location' => 'North Sumatra, Indonesia',
                'isCustomItineraries' => false,
                'isFavorites' => true,
                'isSeasonal' => false,
                'isMustSee' => true,
            ],
            [
                'Name' => 'Bandung City Escape',
                'Title' => 'Shop, Dine, and Explore the Paris of Java',
                'Description' => 'Stroll through art deco architecture, visit tea plantations, and indulge in factory outlets.',
                'Location' => 'Bandung, Indonesia',
                'isCustomItineraries' => false,
                'isFavorites' => true,
                'isSeasonal' => false,
                'isMustSee' => false,
            ],
            [
                'Name' => 'Mentawai Surf Trip',
                'Title' => 'Ride World-Class Waves in Paradise',
                'Description' => 'Join a surf charter to pristine Mentawai breaks, suitable for advanced surfers.',
                'Location' => 'West Sumatra, Indonesia',
                'isCustomItineraries' => true,
                'isFavorites' => false,
                'isSeasonal' => true,
                'isMustSee' => false,
            ],
            [
                'Name' => 'Jakarta Urban Discovery',
                'Title' => 'Dive into Indonesia\'s Bustling Capital',
                'Description' => 'Visit museums, dine on street food, and explore old town Kota Tua.',
                'Location' => 'Jakarta, Indonesia',
                'isCustomItineraries' => false,
                'isFavorites' => true,
                'isSeasonal' => false,
                'isMustSee' => false,
            ],
            [
                'Name' => 'Dieng Plateau Cool Escape',
                'Title' => 'Hike Through Ancient Craters and Temples',
                'Description' => 'Explore colorful lakes, steaming vents, and Hindu shrines in the highlands.',
                'Location' => 'Central Java, Indonesia',
                'isCustomItineraries' => false,
                'isFavorites' => false,
                'isSeasonal' => true,
                'isMustSee' => true,
            ],
            [
                'Name' => 'Lombok Adventure Loop',
                'Title' => 'Trek, Swim, and Camp in Nature',
                'Description' => 'Hike waterfalls, enjoy deserted beaches, and visit Sasak villages.',
                'Location' => 'Lombok, Indonesia',
                'isCustomItineraries' => true,
                'isFavorites' => true,
                'isSeasonal' => false,
                'isMustSee' => true,
            ],
            [
                'Name' => 'Wakatobi Dive Safari',
                'Title' => 'Plunge Into Pristine Coral Gardens',
                'Description' => 'World-renowned biodiversity, luxury eco-resorts, and marine photography spots.',
                'Location' => 'Southeast Sulawesi, Indonesia',
                'isCustomItineraries' => true,
                'isFavorites' => false,
                'isSeasonal' => true,
                'isMustSee' => false,
            ],
            [
                'Name' => 'Aceh Spiritual Journey',
                'Title' => 'Peaceful Escape with a Strong Heritage',
                'Description' => 'Visit the Grand Mosque, Tsunami Museum, and local Islamic schools.',
                'Location' => 'Aceh, Indonesia',
                'isCustomItineraries' => false,
                'isFavorites' => false,
                'isSeasonal' => false,
                'isMustSee' => false,
            ],
            [
                'Name' => 'Semarang Colonial Trails',
                'Title' => 'A Taste of Old Dutch East Indies',
                'Description' => 'Explore Lawang Sewu, Chinatown, and the historic old town port.',
                'Location' => 'Semarang, Indonesia',
                'isCustomItineraries' => false,
                'isFavorites' => true,
                'isSeasonal' => false,
                'isMustSee' => false,
            ],
            [
                'Name' => 'Samosir Island Stay',
                'Title' => 'Live Among the Batak People',
                'Description' => 'Island resort with daily canoe trips, cooking classes, and tribal shows.',
                'Location' => 'Lake Toba, Indonesia',
                'isCustomItineraries' => false,
                'isFavorites' => false,
                'isSeasonal' => true,
                'isMustSee' => true,
            ],
            [
                'Name' => 'Papua Highlands Adventure',
                'Title' => 'Trek Through Remote Tribal Lands',
                'Description' => 'Guided hikes to Baliem Valley and cultural immersion with Dani tribes.',
                'Location' => 'Papua, Indonesia',
                'isCustomItineraries' => true,
                'isFavorites' => false,
                'isSeasonal' => true,
                'isMustSee' => true,
            ],
            [
                'Name' => 'Kalimantan River Safari',
                'Title' => 'Cruise with the Orangutans',
                'Description' => 'Boat rides on Sekonyer River, visits to Tanjung Puting, and eco-lodging.',
                'Location' => 'Central Kalimantan, Indonesia',
                'isCustomItineraries' => true,
                'isFavorites' => true,
                'isSeasonal' => false,
                'isMustSee' => true,
            ],
            [
                'Name' => 'Manado Coral Coast',
                'Title' => 'Snorkel in Bunaken and Sip a Coconut on the Shore',
                'Description' => 'Relaxing days, island hopping, and some of the best dive spots in Asia.',
                'Location' => 'North Sulawesi, Indonesia',
                'isCustomItineraries' => false,
                'isFavorites' => true,
                'isSeasonal' => true,
                'isMustSee' => false,
            ],
        ];

        foreach ($packages as $index => $data) {
            $i = $index + 1;
            Packages::create([
                'Oid' => Str::uuid(),
                'CreateBy' => 1,
                'CreatedAt' => now(),
                'Name' => $data['Name'],
                'Title' => $data['Title'],
                'Description' => $data['Description'],
                'Location' => $data['Location'],
                'HeadImage' => 'head_image_'.$i.'.jpg',
                'SubImage1' => 'sub_image1_'.$i.'.jpg',
                'SubImage2' => 'sub_image2_'.$i.'.jpg',
                'ValidDateStart' => now()->addDays($i),
                'ValidDateEnd' => now()->addDays($i + 7),
                'Price' => rand(1, 3) * 1000000,
                'MaxCapacity' => rand(10, 40),
                'isCustomItineraries' => $data['isCustomItineraries'],
                'isFavorites' => $data['isFavorites'],
                'isSeasonal' => $data['isSeasonal'],
                'isMustSee' => $data['isMustSee'],
            ]);
        }
    }
}
