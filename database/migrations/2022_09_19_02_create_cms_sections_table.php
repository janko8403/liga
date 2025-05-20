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
        Schema::create('cms_sections', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id')->default('0');
            $table->integer('order_id');
            $table->integer('component_id');
            $table->boolean('published')->nullable();
            $table->integer('columns')->default('12');
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
        Schema::dropIfExists('cms_sections');
    }
};
