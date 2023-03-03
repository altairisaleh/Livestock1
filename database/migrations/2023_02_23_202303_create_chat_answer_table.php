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
        Schema::create('chat_answer', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('answer')->nullable();
            $table->string('record')->nullable();
            $table->integer('doctor_id')->unsigned();
            $table->integer('ask_id')->unsigned();
            $table->timestamps();

            $table->foreign('ask_id')->references('id')->on('chat_ask')->onDelete('cascade');

            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_answer');
    }
};
