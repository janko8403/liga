<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AdminsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Log::info('test');
        DB::table('admins')->insert([
            'name' => 'Admin',
            'email' => 'w.borowski@moonsteps.pl',
            'permissions' => '3',
            'password' => Hash::make('local^test1test'),
        ]);

        DB::table('admins')->insert([
            'name' => 'Kamil',
            'email' => 'k.kopec@moonsteps.pl',
            'permissions' => '3',
            'password' => Hash::make('local^test1test'),
        ]);

        DB::table('admins')->insert([
            'name' => 'Mateusz',
            'email' => 'm.piwowarczyk@moonsteps.pl',
            'permissions' => '3',
            'password' => Hash::make('local^test1test'),
        ]);

        DB::table('admins')->insert([
            'name' => 'Krzysztof Pietrzak',
            'email' => 'krzypietrzak@pzu.pl',
            'permissions' => '3',
            'password' => Hash::make('eqTZ1xTZkHRMjlL'),
        ]);

        DB::table('admins')->insert([
            'name' => 'Rafał Adamiak',
            'email' => 'raadamiak@pzu.pl',
            'permissions' => '3',
            'password' => Hash::make('8WBd5ppNs2WAQIc'),
        ]);

        DB::table('admins')->insert([
            'name' => 'Izabela Bliska',
            'email' => 'izwojdat@pzu.pl',
            'permissions' => '3',
            'password' => Hash::make('LF6DIsOkQeQWyXR'),
        ]);

        DB::table('admins')->insert([
            'name' => 'Karolina',
            'lastname' => 'Postój',
            'email' => 'tc_kpostoj@pzu.pl',
            'permissions' => '3',
            'password' => Hash::make('nX8kAY!61$5n'),
        ]);

        DB::table('admins')->insert([
            'name' => 'Marcin',
            'lastname' => 'Cichocki',
            'email' => 'marccichocki@pzu.pl',
            'permissions' => '3',
            'password' => Hash::make('1Uo7%!21pY70'),
        ]);

    }
}
