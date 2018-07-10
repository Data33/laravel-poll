<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePolloptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polloptions', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('text', 128);
            $table->unsignedBigInteger('poll_id');

            $table->foreign('poll_id')->references('id')->on('polls');

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
        Schema::drop('polloptions');
    }
}
