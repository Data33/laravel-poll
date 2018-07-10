<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 128);
            $table->text('text');
            $table->boolean('closed')->default(false);
            $table->unsignedTinyInteger('type')->default(0);
            $table->timestamp('closes_at')->nullable()->default(null);

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
        Schema::drop('polls');
    }
}
