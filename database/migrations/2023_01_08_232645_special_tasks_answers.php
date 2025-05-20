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
        Schema::create('special_tasks_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->string('file_path')->nullable();;
            $table->text('answer')->nullable();
            $table->integer('points')->default(0);
            $table->string('manual')->default(0);
            $table->double('percentage',2,2)->nullable();
            $table->integer('admin_id')->default(0);
            $table->dateTime('answer_date')->nullable();
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
        Schema::dropIfExists('special_tasks_answers');
    }
};
