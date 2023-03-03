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
        Schema::create('commentss', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('Benificary_id')->unsigned();
            $table->integer('post_id')->unsigned();
            $table->longText('content')->nullable();
            $table->string('record')->nullable();
            $table->timestamps();


            $table->foreign('Benificary_id')->references('id')->on('benificaries')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('doctor_posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commentss');
    }
};
