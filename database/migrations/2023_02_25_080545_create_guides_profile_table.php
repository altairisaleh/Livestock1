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
        Schema::create('guides_profile', function (Blueprint $table) {
           $table->increments('id');
           $table->integer('guide_id')->unsigned();
           $table->string('image' )->nullable();
           $table->string('name');
           $table->string('phone');
           $table->string('password');
           $table->timestamps();

           $table->foreign('guide_id')->references('id')->on('guides')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guides_profile');
    }
};
