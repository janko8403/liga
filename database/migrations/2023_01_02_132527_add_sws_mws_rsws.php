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
        Schema::table('activities_league_data_rsws', function (Blueprint $table) {
            $table->renameColumn('sws_reg', 'mws_reg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities_league_data_rsws', function (Blueprint $table) {
            $table->renameColumn('mws_reg', 'sws_reg');
        });
    }
};
