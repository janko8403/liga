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
        Schema::create('activities_cash_league_data_msk', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id')->nullable();
            $table->integer('edition_id')->nullable();
            $table->string('nepu')->nullable();
            $table->string('njs')->nullable();
            $table->string('uczestnik')->nullable();
            $table->string('stanowisko')->nullable();
            $table->double('k1',12,2)->nullable();
            $table->double('k2',12,2)->nullable();
            $table->double('pkt',12,2)->nullable();
            $table->integer('miejsce')->nullable();
            $table->string('umowa')->nullable();
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
        Schema::dropIfExists('activities_cash_league_data_msk');
    }
};
