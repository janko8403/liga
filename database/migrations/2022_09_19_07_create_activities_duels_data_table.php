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
        Schema::create('duels_data', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id')->nullable();
            $table->integer('edition_id')->nullable();
            $table->string('nepu_dsk')->nullable();
            $table->string('njs_dsk')->nullable();
            $table->string('dsk')->nullable();
            $table->string('nepu_msk')->nullable();
            $table->string('njs_msk')->nullable();
            $table->string('msk')->nullable();
            $table->string('data')->nullable();
            $table->string('wynik_msk')->nullable();
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
        Schema::dropIfExists('duels_data');
    }
};
