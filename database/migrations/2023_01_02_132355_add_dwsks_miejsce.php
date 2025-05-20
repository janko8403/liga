<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities_league_data_dws_ks', function (Blueprint $table) {
            $table->integer('miejsce')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities_league_data_dws_ks', function (Blueprint $table) {
            $table->drop('miejsce');
        });
    }
};
