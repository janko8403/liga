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
        Schema::create('activities_special_tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id')->nullable();
            $table->integer('edition_id')->nullable();
            $table->string('type')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->default(' ')->nullable();
            $table->string('quiz_time')->nullable();
            $table->string('quiz_ranking_points')->nullable();
            $table->string('quiz_percentage_points')->nullable();
            $table->integer('quiz_locked')->default('0');
            $table->string('slug')->nullable();
            $table->integer('status')->default(0);
            $table->date('active_from')->nullable();
            $table->date('active_to')->nullable();
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
        Schema::dropIfExists('activities_special_tasks');
    }
};
