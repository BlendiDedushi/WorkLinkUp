<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeed extends Seeder
{
    public function run(): void
    {
        $cities = [
            'Deçan',
            'Dragash',
            'Ferizaj',
            'Gjakova',
            'Gjilan',
            'Istog',
            'Junik',
            'Kamenicë',
            'Klinë',
            'Lipjan',
            'Mitrovica',
            'Obiliq',
            'Peja',
            'Podujevë',
            'Prishtina',
            'Prizren',
            'Rahovec',
            'Shtime',
            'Vushtrri'
        ];

        foreach ($cities as $citie) {
            City::create(['name' => $citie]);
        }
    }
}
