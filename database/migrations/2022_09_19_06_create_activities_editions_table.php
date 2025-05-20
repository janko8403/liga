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
        Schema::create('activities_editions', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('status')->default(0);
            $table->date('active_from')->nullable();
            $table->date('active_to')->nullable();
            $table->date('last_data_update')->nullable();
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
        Schema::dropIfExists('activities_editions');
    }
};
