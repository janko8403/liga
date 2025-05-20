<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AdminPermissionsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_permissions')->insert([
            'id' => '1',
            'name' => 'ADMIN_BACKEND_selected_activities',
            'description' => 'Dostęp do aktywności wybranych przez administratora z uprawnieniami SUPERADMIN_BACKEND',
        ]);
        DB::table('admin_permissions')->insert([
            'id' => '2',
            'name' => 'ADMIN_BACKEND_main',
            'description' => 'Dostęp do wszystkich aktywności',
        ]);
        DB::table('admin_permissions')->insert([
            'id' => '3',
            'name' => 'SUPERADMIN_BACKEND',
            'description' => 'Dostęp do wszystkich aktywności i przydzielania uprawnień innym administratorom',
        ]);

        DB::table('admin_detailed_permissions')->insert([
           'id' => '1',
           'name' => 'Liga Mistrzów'
        ]);
        DB::table('admin_detailed_permissions')->insert([
            'id' => '2',
            'name' => 'Liga Mistrzów CASH'
        ]);

        DB::table('admin_detailed_permissions')->insert([
            'id' => '3',
            'name' => 'Pojedynki'
        ]);
        DB::table('admin_detailed_permissions')->insert([
            'id' => '4',
            'name' => 'Użytkownicy'
        ]);
        DB::table('admin_detailed_permissions')->insert([
            'id' => '5',
            'name' => 'CMS'
        ]);
    }
}
