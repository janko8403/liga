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
        Schema::create('duels_editions', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id');
            $table->string('name')->nullable();
            $table->string('category')->nullable();
            $table->string('slug')->nullable()->unique;
            $table->string('status')->default(0);
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
        Schema::dropIfExists('duels_editions');
    }
};
