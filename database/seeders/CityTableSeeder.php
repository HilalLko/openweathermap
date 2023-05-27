<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            [
                'city' => 'Tokyo',
                'city_ascii'  => 'Tokyo',
                'latitude'  => '35.6897',
                'longitude'  => '139.6922',
                'country'  => 'Japan'
            ],
            [
                'city' => 'Nagoya',
                'city_ascii'  => 'Nagoya',
                'latitude'  => '35.1833',
                'longitude'  => '136.9',
                'country'  => 'Japan'
            ],
            [
                'city' => 'Delhi',
                'city_ascii'  => 'Delhi',
                'latitude'  => '28.61',
                'longitude'  => '77.23',
                'country'  => 'India'
            ],
            [
                'city' => 'Mumbai',
                'city_ascii'  => 'Mumbai',
                'latitude'  => '19.0761',
                'longitude'  => '72.8775',
                'country'  => 'India'
            ],
            [
                'city' => 'Kolkata',
                'city_ascii'  => 'Kolkata',
                'latitude'  => '22.5675',
                'longitude'  => '88.37',
                'country'  => 'Japan'
            ],
            [
                'city' => 'Lucknow',
                'city_ascii'  => 'Lucknow',
                'latitude'  => '26.85',
                'longitude'  => '80.95',
                'country'  => 'India'
            ],
            [
                'city' => 'Amritsar',
                'city_ascii'  => 'Amritsar',
                'latitude'  => '31.64',
                'longitude'  => '74.86',
                'country'  => 'India'
            ],

        ];
        City::insert($cities);
    }
}
