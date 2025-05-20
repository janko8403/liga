<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DuelsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('duels_settings')->insert([
            'id' => '1',
            'name' => 'Pojedynki',
            'type' => 1,
            'status' => '1',
            'slug' => 'pojedynki',
        ]);

        DB::table('files')->insert([
            'id' => '6',
            'type' => 'duels-header',
            'activity_id' => '1',
            'file_name' => 'ActivityDuels.png',
            'file_path' => '/img/ActivityDuels.png',
        ]);

    }
}
