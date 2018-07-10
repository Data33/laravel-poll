<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pollvotes', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('poll_id');
            $table->unsignedBigInteger('polloption_id');
            $table->unsignedBigInteger('voter_id');

            $table->foreign('poll_id')->references('id')->on('polls');
            $table->foreign('polloption_id')->references('id')->on('polloptions');

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
        Schema::drop('pollvotes');
    }
}
