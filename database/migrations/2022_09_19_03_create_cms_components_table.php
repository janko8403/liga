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
        Schema::create('cms_components', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('component_path');
            $table->json('parameters')->nullable();
            $table->string('category')->nullable();
            $table->integer('columns')->default(12);
            $table->json('labels')->nullable();
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
        Schema::dropIfExists('cms_components');
    }
};
