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
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('doctor_id')->unsigned();
            $table->integer('ask_id')->unsigned();
            $table->longText('content')->nullable();
            $table->string('record')->nullable();
            $table->timestamps();


            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');

            $table->foreign('ask_id')->references('id')->on('asks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
};
