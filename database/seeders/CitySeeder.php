<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            'Warszawa',
            'Kraków',
            'Łódź',
            'Wrocław',
            'Poznań',
            'Gdańsk',
            'Gdynia',
            'Szczecin',
            'Bydgoszcz',
            'Lublin'
        ];

        foreach($cities as $city) {
            DB::table('cities')->insert([
                'city' => $city,
                'city_class' => 'box-city_' . $this->removeCharacters($city),
                'active' => '1',
            ]);
        }
    }

    public function removeCharacters($city) {

        $strict = strtolower($city);

        $patterns[0] = '/ą/';
        $patterns[1] = '/ć/';
        $patterns[2] = '/ę/';
        $patterns[3] = '/ł/';
        $patterns[4] = '/ń/';
        $patterns[5] = '/ś/';
        $patterns[6] = '/ź/';
        $patterns[7] = '/ż/';
        $patterns[8] = '/Ł/';
        $patterns[9] = '/ó/';
        $replacements[0] = 'a';
        $replacements[1] = 'c';
        $replacements[2] = 'e';
        $replacements[3] = 'l';
        $replacements[4] = 'n';
        $replacements[5] = 's';
        $replacements[6] = 'z';
        $replacements[7] = 'z';
        $replacements[8] = 'l';
        $replacements[9] = 'o';

        return preg_replace($patterns, $replacements, $strict);
    }
}
