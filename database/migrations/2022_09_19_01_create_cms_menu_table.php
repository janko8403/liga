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
        Schema::create('cms_menu', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->default('0');
            $table->integer('order_id')->default('0');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->integer('deletable')->default('1');
            $table->integer('published')->nullable();
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
        Schema::dropIfExists('cms_menu');
    }
};
