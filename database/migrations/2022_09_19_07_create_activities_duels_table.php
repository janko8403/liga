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
        Schema::create('duels', function (Blueprint $table) {
            $table->id();
            $table->integer('edition_id');
            $table->string('first_nepu')->nullable();
            $table->string('second_nepu')->nullable();
            $table->string('type')->nullable();
            $table->decimal('award',10,2)->nullable();
            $table->date('active_from')->nullable();
            $table->date('active_to')->nullable();
            $table->integer('status')->default('0');
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
        Schema::dropIfExists('duels');
    }
};
