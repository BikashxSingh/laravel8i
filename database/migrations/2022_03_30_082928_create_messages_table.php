<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from')->referennces('id')->on('users');
            $table->foreignId('to')->referennces('id')->on('users');
            $table->text('message');
            $table->timestamps();
            // $table->increments('id');
            // $table->unsignedBigInteger('user_id')->unsigned();
            $table->tinyInteger('is_read')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
