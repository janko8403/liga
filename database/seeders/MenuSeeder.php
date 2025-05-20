<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\UserPermission as Permission;


class MenuSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        #menu
        DB::table('cms_menu')->insert([
            'id' => 1,
            'name' => 'Menu główne',
            'parent_id' => 0,
            'order_id' => 0,
            'deletable' => 1,
            'slug' => 'menu-glowne',
            'published' => 1
        ]);

        DB::table('cms_menu')->insert([
            'id' => 11,
            'name' => 'Pozostałe strony',
            'parent_id' => 0,
            'deletable' => 1,
            'order_id' => 0,
            'slug' => 'pozostale-strony',
            'published' => 1
        ]);

        #menu level 1 elements
        DB::table('cms_menu')->insert([
            'id' => 13,
            'name' => 'Strona główna',
            'parent_id' => 11,
            'deletable' => 0,
            'order_id' => 1,
            'slug' => 'strona-glowna',
            'published' => 1
        ]);
        DB::table('cms_menu')->insert([
            'id' => 12,
            'name' => 'Stopka strony',
            'parent_id' => 11,
            'deletable' => 0,
            'order_id' => 2,
            'slug' => '',
            'published' => 1
        ]);

        DB::table('cms_menu')->insert([
            'id' => 2,
            'name' => 'O programie',
            'parent_id' => 1,
            'order_id' => 1,
            'deletable' => 1,
            'slug' => 'o-programie',
            'published' => 1
        ]);

        DB::table('cms_menu')->insert([
            'id' => 3,
            'name' => 'Aktywności',
            'parent_id' => 1,
            'order_id' => 2,
            'deletable' => 0,
            'slug' => 'aktywnosci',
            'published' => 1
        ]);

        DB::table('cms_menu')->insert([
            'id' => 4,
            'name' => 'Zespół',
            'parent_id' => 1,
            'slug' => 'zespol',
            'deletable' => 1,
            'order_id' => 3,
            'published' => 1
        ]);

        #level 2
        DB::table('cms_menu')->insert([
            'id' => 6,
            'name' => 'Liga Mistrzów',
            'slug' => 'liga-mistrzow',
            'deletable' => 1,
            'parent_id' => 3,
            'order_id' => 1,
            'published' => 1
        ]);

        DB::table('cms_menu')->insert([
            'id' => 7,
            'name' => 'Liga Mistrzów CASH',
            'slug' => 'liga-mistrzow-cash',
            'deletable' => 1,
            'parent_id' => 3,
            'order_id' => 2,
            'published' => 1
        ]);

        DB::table('cms_menu')->insert([
            'id' => 8,
            'name' => 'Konkursy i Akcje Sprzedażowe',
            'slug' => 'konkursy-i-akcje-sprzedazowe',
            'deletable' => 1,
            'parent_id' => 3,
            'order_id' => 3,
            'published' => 1
        ]);

        DB::table('cms_menu')->insert([
            'id' => 9,
            'name' => 'Zadania specjalne',
            'slug' => 'zadania-specjalne',
            'deletable' => 1,
            'parent_id' => 3,
            'order_id' => 4,
            'published' => 1
        ]);

        DB::table('cms_menu')->insert([
            'id' => 10,
            'name' => 'Pojedynki',
            'slug' => 'pojedynki',
            'deletable' => 1,
            'parent_id' => 3,
            'order_id' => 5,
            'published' => 1
        ]);



        Permission::create( [
            'id'=>1,
            'activity_id'=>'2',
            'user_permission_id'=>'1',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:48:41',
            'updated_at'=>'2022-12-27 08:48:41'
        ] );



        Permission::create( [
            'id'=>2,
            'activity_id'=>'2',
            'user_permission_id'=>'2',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:48:41',
            'updated_at'=>'2022-12-27 08:48:41'
        ] );



        Permission::create( [
            'id'=>3,
            'activity_id'=>'2',
            'user_permission_id'=>'3',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:48:41',
            'updated_at'=>'2022-12-27 08:48:41'
        ] );



        Permission::create( [
            'id'=>4,
            'activity_id'=>'2',
            'user_permission_id'=>'4',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:48:41',
            'updated_at'=>'2022-12-27 08:48:41'
        ] );



        Permission::create( [
            'id'=>5,
            'activity_id'=>'3',
            'user_permission_id'=>'1',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:48:49',
            'updated_at'=>'2022-12-27 08:48:49'
        ] );



        Permission::create( [
            'id'=>6,
            'activity_id'=>'3',
            'user_permission_id'=>'3',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:48:49',
            'updated_at'=>'2022-12-27 08:48:49'
        ] );



        Permission::create( [
            'id'=>7,
            'activity_id'=>'3',
            'user_permission_id'=>'2',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:48:49',
            'updated_at'=>'2022-12-27 08:48:49'
        ] );



        Permission::create( [
            'id'=>8,
            'activity_id'=>'3',
            'user_permission_id'=>'4',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:48:49',
            'updated_at'=>'2022-12-27 08:48:49'
        ] );



        Permission::create( [
            'id'=>9,
            'activity_id'=>'6',
            'user_permission_id'=>'2',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:48:57',
            'updated_at'=>'2022-12-27 08:48:57'
        ] );



        Permission::create( [
            'id'=>10,
            'activity_id'=>'6',
            'user_permission_id'=>'1',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:48:57',
            'updated_at'=>'2022-12-27 08:48:57'
        ] );



        Permission::create( [
            'id'=>11,
            'activity_id'=>'6',
            'user_permission_id'=>'3',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:48:57',
            'updated_at'=>'2022-12-27 08:48:57'
        ] );



        Permission::create( [
            'id'=>12,
            'activity_id'=>'6',
            'user_permission_id'=>'4',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:48:57',
            'updated_at'=>'2022-12-27 08:48:57'
        ] );



        Permission::create( [
            'id'=>13,
            'activity_id'=>'7',
            'user_permission_id'=>'1',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:05',
            'updated_at'=>'2022-12-27 08:49:05'
        ] );



        Permission::create( [
            'id'=>14,
            'activity_id'=>'7',
            'user_permission_id'=>'2',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:05',
            'updated_at'=>'2022-12-27 08:49:05'
        ] );



        Permission::create( [
            'id'=>15,
            'activity_id'=>'7',
            'user_permission_id'=>'3',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:05',
            'updated_at'=>'2022-12-27 08:49:05'
        ] );



        Permission::create( [
            'id'=>16,
            'activity_id'=>'7',
            'user_permission_id'=>'4',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:05',
            'updated_at'=>'2022-12-27 08:49:05'
        ] );



        Permission::create( [
            'id'=>17,
            'activity_id'=>'8',
            'user_permission_id'=>'1',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:11',
            'updated_at'=>'2022-12-27 08:49:11'
        ] );



        Permission::create( [
            'id'=>18,
            'activity_id'=>'8',
            'user_permission_id'=>'2',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:11',
            'updated_at'=>'2022-12-27 08:49:11'
        ] );



        Permission::create( [
            'id'=>19,
            'activity_id'=>'8',
            'user_permission_id'=>'3',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:11',
            'updated_at'=>'2022-12-27 08:49:11'
        ] );



        Permission::create( [
            'id'=>20,
            'activity_id'=>'8',
            'user_permission_id'=>'4',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:11',
            'updated_at'=>'2022-12-27 08:49:11'
        ] );



        Permission::create( [
            'id'=>21,
            'activity_id'=>'9',
            'user_permission_id'=>'1',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:16',
            'updated_at'=>'2022-12-27 08:49:16'
        ] );



        Permission::create( [
            'id'=>22,
            'activity_id'=>'9',
            'user_permission_id'=>'2',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:16',
            'updated_at'=>'2022-12-27 08:49:16'
        ] );



        Permission::create( [
            'id'=>23,
            'activity_id'=>'9',
            'user_permission_id'=>'3',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:16',
            'updated_at'=>'2022-12-27 08:49:16'
        ] );



        Permission::create( [
            'id'=>24,
            'activity_id'=>'9',
            'user_permission_id'=>'4',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:16',
            'updated_at'=>'2022-12-27 08:49:16'
        ] );



        Permission::create( [
            'id'=>25,
            'activity_id'=>'10',
            'user_permission_id'=>'1',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:21',
            'updated_at'=>'2022-12-27 08:49:21'
        ] );



        Permission::create( [
            'id'=>26,
            'activity_id'=>'10',
            'user_permission_id'=>'2',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:21',
            'updated_at'=>'2022-12-27 08:49:21'
        ] );



        Permission::create( [
            'id'=>27,
            'activity_id'=>'10',
            'user_permission_id'=>'3',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:21',
            'updated_at'=>'2022-12-27 08:49:21'
        ] );



        Permission::create( [
            'id'=>28,
            'activity_id'=>'10',
            'user_permission_id'=>'4',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:21',
            'updated_at'=>'2022-12-27 08:49:21'
        ] );



        Permission::create( [
            'id'=>29,
            'activity_id'=>'4',
            'user_permission_id'=>'1',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:26',
            'updated_at'=>'2022-12-27 08:49:26'
        ] );



        Permission::create( [
            'id'=>30,
            'activity_id'=>'4',
            'user_permission_id'=>'2',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:26',
            'updated_at'=>'2022-12-27 08:49:26'
        ] );



        Permission::create( [
            'id'=>31,
            'activity_id'=>'4',
            'user_permission_id'=>'3',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:26',
            'updated_at'=>'2022-12-27 08:49:26'
        ] );



        Permission::create( [
            'id'=>32,
            'activity_id'=>'4',
            'user_permission_id'=>'4',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:26',
            'updated_at'=>'2022-12-27 08:49:26'
        ] );



        Permission::create( [
            'id'=>33,
            'activity_id'=>'13',
            'user_permission_id'=>'1',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:33',
            'updated_at'=>'2022-12-27 08:49:33'
        ] );



        Permission::create( [
            'id'=>34,
            'activity_id'=>'13',
            'user_permission_id'=>'2',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:33',
            'updated_at'=>'2022-12-27 08:49:33'
        ] );



        Permission::create( [
            'id'=>35,
            'activity_id'=>'13',
            'user_permission_id'=>'3',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:33',
            'updated_at'=>'2022-12-27 08:49:33'
        ] );



        Permission::create( [
            'id'=>36,
            'activity_id'=>'13',
            'user_permission_id'=>'4',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:33',
            'updated_at'=>'2022-12-27 08:49:33'
        ] );



        Permission::create( [
            'id'=>37,
            'activity_id'=>'12',
            'user_permission_id'=>'1',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:39',
            'updated_at'=>'2022-12-27 08:49:39'
        ] );



        Permission::create( [
            'id'=>38,
            'activity_id'=>'12',
            'user_permission_id'=>'2',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:39',
            'updated_at'=>'2022-12-27 08:49:39'
        ] );



        Permission::create( [
            'id'=>39,
            'activity_id'=>'12',
            'user_permission_id'=>'3',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:39',
            'updated_at'=>'2022-12-27 08:49:39'
        ] );



        Permission::create( [
            'id'=>40,
            'activity_id'=>'12',
            'user_permission_id'=>'4',
            'permission_type'=>'cmsMenu',
            'created_at'=>'2022-12-27 08:49:39',
            'updated_at'=>'2022-12-27 08:49:39'
        ] );

    }
}
