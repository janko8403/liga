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
        Schema::create('activities_sales_contests_data', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id')->nullable();
            $table->integer('edition_id')->nullable();
            $table->string('nepu')->nullable();
            $table->integer('njs')->nullable();
            $table->string('uczestnik')->nullable();
            $table->string('stanowisko')->nullable();
            $table->string('data')->nullable();
            $table->integer('wartosc')->nullable();
            $table->text('dodatkowe')->nullable();
            $table->integer('nagroda')->nullable();
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
        Schema::dropIfExists('activities_sales_contests_data');
    }
};
