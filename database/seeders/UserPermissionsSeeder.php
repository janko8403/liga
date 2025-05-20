<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserPermissionsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_permissions')->insert([
            'id' => '1',
            'name' => 'MSK',
            'description' => '',
        ]);
        DB::table('user_permissions')->insert([
            'id' => '2',
            'name' => 'DSK',
            'description' => '',
        ]);
        DB::table('user_permissions')->insert([
            'id' => '3',
            'name' => 'DWS',
            'description' => '',
        ]);
        DB::table('user_permissions')->insert([
            'id' => '4',
            'name' => 'MWP',
            'description' => '',
        ]);
        DB::table('user_permissions')->insert([
            'id' => '5',
            'name' => 'MWS',
            'description' => '',
        ]);
        DB::table('user_permissions')->insert([
            'id' => '6',
            'name' => 'RDSK',
            'description' => '',
        ]);
        DB::table('user_permissions')->insert([
            'id' => '7',
            'name' => 'RKWP',
            'description' => '',
        ]);
        DB::table('user_permissions')->insert([
            'id' => '8',
            'name' => 'RMWS',
            'description' => '',
        ]);
    }
}
