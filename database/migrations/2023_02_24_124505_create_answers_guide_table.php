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
        Schema::create('answers_guide', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('guide_id')->unsigned();
            $table->integer('ask_id')->unsigned();
            $table->longText('content')->nullable();
            $table->string('record')->nullable();
            $table->timestamps();


            $table->foreign('guide_id')->references('id')->on('guides')->onDelete('cascade');

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
        Schema::dropIfExists('answers_guide');
    }
};
