<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class CMSComponentsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cms_components')->insert([
            'name' => 'Tekst z tytułem',
            'description' => 'Opis komponentu tekstowego',
            'component_path' => 'TextSection',
            'category' => 'Podstawowe',
            'parameters' => '{"title":"string","content":"text"}',
            'labels' => '{"title":"Tytuł","content":"Treść"}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Edytor tekstowy',
            'description' => 'Sekcja z edytorem WYSIWYG',
            'component_path' => 'RichTextSection',
            'category' => 'Podstawowe',
            'parameters' => '{"content":"richtext"}',
            'labels' => '{"Content":"Treść"}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Edytor tesktowy',
            'description' => 'Sekcja z edytorem WYSIWYG oraz obramowaniem',
            'component_path' => 'RichTextBordered',
            'category' => 'Podstawowe',
            'parameters' => '{"content":"richtext"}',
            'labels' => '{"Content":"Treść"}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Obraz',
            'description' => 'Element graficzny',
            'component_path' => 'ImageSection',
            'category' => 'Podstawowe',
            'parameters' => '{"image":"image"}',
            'labels' => '{"image":"Obraz"}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Obraz i tekst',
            'description' => 'Dwie kolumny',
            'component_path' => 'ImageText',
            'category' => 'Podstawowe',
            'parameters' => '{"image":"image","content":"richtext"}',
            'labels' => '{"image":"Obraz","content":"Tekst"}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Tekst i obraz',
            'description' => 'Dwie kolumny',
            'component_path' => 'TextImage',
            'category' => 'Podstawowe',
            'parameters' => '{"image":"image","content":"richtext"}',
            'labels' => '{"image":"Obraz","content":"Tekst"}',
        ]);

        #strona główna
        DB::table('cms_components')->insert([
            'name' => 'Slider',
            'description' => 'Główny slider',
            'component_path' => 'MainHeaderSwiper',
            'category' => 'Strona główna',
            'parameters' => '{"title1":"string","subtitle1":"string","content1":"text","url1":"string","title2":"string","subtitle2":"string","content2":"text","url2":"string","title3":"string","subtitle3":"string","content3":"text","url3":"string"}',
            'labels' => '{"title1":"Slajd 1 - Tytuł","subtitle1":"Slajd 1 - podtytuł","content1":"Slajd 1 - Treść","url1":"Slajd 1 - Link CTA","title2":"Slajd 2 - Tytuł","subtitle2":"Slajd 2 - Podtytuł","content2":"Slajd 2 - Treść","url2":"Slajd 2 - Link CTA","title3":"Slajd 3 - Tytuł","subtitle3":"Slajd 3 - Podtytuł","content3":"Slajd 3 - Treść","url3":"Slajd 3 - Link CTA"}',
        ]);

        #liga mistrzów
        DB::table('cms_components')->insert([
            'name' => 'Liga Mistrzów - Nagłówek',
            'description' => 'Element graficzny',
            'component_path' => 'ActivityLeagueHeader',
            'category' => 'Liga Mistrzów',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        #liga mistrzów tabela
        DB::table('cms_components')->insert([
            'name' => 'Liga Mistrzów - tabela wyników',
            'description' => 'Tabela rankingowa',
            'component_path' => 'ActivityLeagueTable',
            'category' => 'Liga Mistrzów',
            'parameters' => '{}',
            'labels' => '{}',
        ]);
        #liga mistrzow zasady
        DB::table('cms_components')->insert([
            'name' => 'Liga Mistrzów - Zasady aktywnosci',
            'description' => 'Zasady',
            'component_path' => 'ActivityLeagueRules',
            'category' => 'Liga Mistrzów',
            'parameters' => '{"title":"string","content":"richtext","regulamin":"file"}',
            'labels' => '{"title":"Tytuł", "regulamin":"Regulamin","content":"Treść zasad"}',
        ]);

        #liga mistrzów cash
        DB::table('cms_components')->insert([
            'name' => 'Liga Mistrzów CASH - Nagłówek',
            'description' => 'Nagłówek',
            'component_path' => 'ActivityCashLeagueHeader',
            'category' => 'Liga Mistrzów CASH',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        #liga mistrzów tabela
        DB::table('cms_components')->insert([
            'name' => 'Liga Mistrzów CASH - Tabela wyników',
            'description' => 'Tabela rankingowa',
            'component_path' => 'ActivityCashLeagueTable',
            'category' => 'Liga Mistrzów CASH',
            'parameters' => '{}',
            'labels' => '{}',
        ]);
        #liga mistrzow zasady
        DB::table('cms_components')->insert([
            'name' => 'Liga Mistrzów CASH- Zasady aktywnosci',
            'description' => 'Zasady',
            'component_path' => 'ActivityCashLeagueRules',
            'category' => 'Liga Mistrzów CASH',
            'parameters' => '{"title":"string","content":"richtext","regulamin":"file"}',
            'labels' => '{"title":"Tytuł", "regulamin":"Regulamin","content":"Treść zasad"}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Zadania Specjalne - Nagłówek',
            'description' => 'Zasady',
            'component_path' => 'SpecialTaskHeader',
            'category' => 'Zadania Specjalne',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Zadania Specjalne - Edycje',
            'description' => 'Edycje zadań specjalnych',
            'component_path' => 'SpecialTaskEditions',
            'category' => 'Zadania Specjalne',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Zadania Specjalne - Nagrody',
            'description' => 'Nagrody',
            'component_path' => 'SpecialTaskPrizes',
            'category' => 'Zadania Specjalne',
            'parameters' => '{
                "title":"string",
                "first-content":"richtext",
                "image1":"image",
                "image2":"image",
                "second-content":"richtext",
                "image3":"image",
                "image4":"image",
                "image5":"image",
                "img-title3":"string",
                "img-title4":"string",
                "img-title5":"string"
            }',
            'labels' => '{
                "title":"Tekst nagłówka",
                "first-content":"Pierwszy paragraf",
                "image1":"Pierwszy obraz",
                "image2":"Drugi obraz",
                "second-content":"Drugi paragraf",
                "image3":"Trzeci obraz",
                "image4":"Czwarty obraz",
                "image5":"Piąty obraz",
                "img-title3":"Podpis pod trzecim obrazem",
                "img-title4":"Podpis pod czwartym obrazem",
                "img-title5":"Podpis pod piątym obrazem"
            }',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Zadania Specjalne - Ranking edycji',
            'description' => 'Ranking wszystkich zadań w edycji',
            'component_path' => 'SpecialTaskEditionRanking',
            'category' => 'Zadania Specjalne',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Zadania Specjalne - Ranking zadań',
            'description' => 'Ranking wszystkich zadań w edycji',
            'component_path' => 'SpecialTaskEditionRanking',
            'category' => 'Zadania Specjalne',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Pojedynki - Nagłówek',
            'description' => 'Nagłówek aktywności pojedynki',
            'component_path' => 'DuelsHeader',
            'category' => 'Pojedynki',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Pojedynki - Opis aktywności',
            'description' => 'Opis aktywności',
            'component_path' => 'DuelsDescription',
            'category' => 'Pojedynki',
            'parameters' => '{"title":"string","content":"richtext","regulamin":"file"}',
            'labels' => '{"title":"Tytuł", "regulamin":"Regulamin","content":"Treść zasad"}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Pojedynki',
            'description' => 'Lista pojedynków',
            'component_path' => 'Duels',
            'category' => 'Pojedynki',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Liga Mistrzów - Wyniki',
            'description' => '',
            'columns' => 6,
            'component_path' => 'ActivityLeagueBoxResults',
            'category' => 'Strona główna',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Liga Mistrzów CASH - Wyniki',
            'description' => '',
            'columns' => 6,
            'component_path' => 'ActivityCashBoxResults',
            'category' => 'Strona główna',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Konkursy i Akcje Sprzedażowe',
            'description' => '',
            'columns' => 6,
            'component_path' => 'ActivityContestBoxResults',
            'category' => 'Strona główna',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Zadania Specjalne',
            'description' => '',
            'columns' => 6,
            'component_path' => 'ActivityContestBoxResults',
            'category' => 'Strona główna',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Pojedynki',
            'description' => '',
            'component_path' => 'Duels',
            'category' => 'Strona główna',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Mapa',
            'description' => '',
            'component_path' => 'Map',
            'category' => 'Pojedynki',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Nagłówek',
            'description' => '',
            'component_path' => 'ContestsHeader',
            'category' => 'Konkursy i Akcje Sprzedażowe',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Konkursy i Akcje Sprzedażowe',
            'description' => '',
            'component_path' => 'Contests',
            'category' => 'Konkursy i Akcje Sprzedażowe',
            'parameters' => '{}',
            'labels' => '{}',
        ]);

        DB::table('cms_components')->insert([
            'name' => 'Breadcrumbs',
            'description' => 'Nawigacja, aktualna strona',
            'component_path' => 'BreadCrumbs',
            'category' => 'Konkursy i Akcje Sprzedażowe',
            'parameters' => '{}',
            'labels' => '{}',
        ]);
    }
}
