<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ExampleUsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Tagent',
            'lastname' => 'Focus',
            'email' => 'w.borowski@finesoft.pl',
            'region' => 'Pomorskie',
            'njs' => '12345678',
            'nepu' => 'N12345678',
            'position' => 'Agent',
            'network' => 'ACASD',
            'phone' => '+48 123456789',
        ]);
        DB::table('users')->insert([
            'name' => 'Agent Bogdan',
            'lastname' => 'Bogdan',
            'email' => 'w.borowski@moonsteps.pl',
            'region' => 'Pomorskie',
            'njs' => '12345678',
            'nepu' => 'N12345678',
            'position' => 'Agent',
            'phone' => '+48 123456789',
            'network' => 'ACASD',
        ]);
    }
}
