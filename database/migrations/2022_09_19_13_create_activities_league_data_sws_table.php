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
        Schema::create('activities_league_data_sws', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id')->nullable();
            $table->integer('edition_id')->nullable();
            $table->string('nepu')->nullable();
            $table->integer('miejsce')->nullable();
            $table->string('sws')->nullable();
            $table->string('njs_dsk')->nullable();
            $table->string('dsk')->nullable();
            $table->string('region')->nullable();
            $table->string('rdsk')->nullable();
            $table->string('sws_reg')->nullable();
            $table->integer('k1')->nullable();
            $table->integer('k2')->nullable();
            $table->integer('k3')->nullable();
            $table->integer('k4')->nullable();
            $table->integer('k5')->nullable();
            $table->integer('k6')->nullable();
            $table->integer('suma')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities_league_data_sws');
    }
};
