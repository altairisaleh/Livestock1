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
        Schema::create('chat_ask', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Benificary_id')->unsigned();
            $table->longText('mesage')->nullable();
            $table->string('record')->nullable();
            $table->timestamps();
            $table->foreign('Benificary_id')->references('id')->on('benificaries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_ask');
    }
};
