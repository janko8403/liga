<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminsSeeder::class,
            AdminPermissionsSeeder::class,
            UserPermissionsSeeder::class,
            ActivitySeeder::class,
            MenuSeeder::class,
            CMSComponentsSeeder::class,
            CitySeeder::class,
            //ExampleUsersSeeder::class,
            DuelsSeeder::class,
        ]);
    }
}
