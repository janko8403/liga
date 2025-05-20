<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent;

class ActivitySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activities')->insert([
            'id' => '1',
            'name' => 'Liga Mistrzów',
            'type' => 1,
            'status' => '1',
            'active_from' => '2022-09-14',
            'active_to' => '2024-09-14',
            'slug' => 'liga-mistrzow',
        ]);

        DB::table('activities')->insert([
            'id' => '2',
            'name' => 'Liga Mistrzów CASH',
            'type' => 2,
            'status' => '1',
            'active_from' => '2022-09-14',
            'active_to' => '2024-09-14',
            'slug' => 'liga-mistrzow-cash',
        ]);

        DB::table('activities')->insert([
            'id' => '3',
            'name' => 'Zadania Specjalne',
            'type' => 3,
            'status' => '1',
            'active_from' => '2022-09-14',
            'active_to' => '2024-09-14',
            'slug' => 'zadania-specjalne',
        ]);

        DB::table('activities')->insert([
            'id' => '4',
            'name' => 'Konkursy i Akcje Sprzedażowe',
            'type' => 4,
            'status' => '0',
            'active_from' => '2022-09-14',
            'active_to' => '2024-09-14',
            'slug' => 'konkursy',
        ]);

        DB::table('files')->insert([
            'id' => '2',
            'type' => 'header',
            'activity_id' => '1',
            'file_name' => 'ActivityLeague.png',
            'file_path' => '/img/ActivityLeague.png',
        ]);

        DB::table('files')->insert([
            'id' => '3',
            'type' => 'header',
            'activity_id' => '2',
            'file_name' => 'ActivityLeagueCash.png',
            'file_path' => '/img/ActivityLeagueCash.png',
        ]);

        DB::table('files')->insert([
            'id' => '4',
            'type' => 'header',
            'activity_id' => '3',
            'file_name' => 'ActivityTasks.png',
            'file_path' => '/img/ActivityTasks.png',
        ]);

        DB::table('files')->insert([
            'id' => '5',
            'type' => 'header',
            'activity_id' => '4',
            'file_name' => 'ActivityCampaigns.png',
            'file_path' => '/img/ActivityCampaigns.png',
        ]);

        DB::table('settings')->insert([
            'id' => '1',
            'name' => 'Systemowy adres email',
            'content' => 'test@test.com',
        ]);

    }
}
