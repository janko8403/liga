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
        Schema::create('special_task_ranking_data', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id')->default(0);
            $table->string('nepu')->nullable();;
            $table->string('njs')->nullable();
            $table->string('uczestnik')->nullable();
            $table->string('stanowisko')->nullable();
            $table->string('data')->nullable();
            $table->string('wartosc')->nullable();
            $table->string('punkty')->nullable();
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
        Schema::dropIfExists('special_task_ranking_data');
    }
};
