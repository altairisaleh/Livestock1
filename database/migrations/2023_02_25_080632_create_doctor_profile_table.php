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
        Schema::create('doctor_profile', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('doctor_id')->unsigned();
          $table->string('image' )->nullable();
          $table->string('name');
          $table->string('phone');
          $table->string('password');
          $table->timestamps();

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
        Schema::dropIfExists('doctor_profile');
    }
};
