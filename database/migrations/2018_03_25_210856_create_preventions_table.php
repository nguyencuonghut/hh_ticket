<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preventions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->integer('budget');
            $table->integer('preventor_id')->unsigned();
            $table->foreign('preventor_id')->references('id')->on('users');
            $table->integer('pre_preventor_id')->unsigned();
            $table->foreign('pre_preventor_id')->references('id')->on('users');
            $table->integer('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users');
            $table->string('where')->nullable();
            $table->dateTime('when')->nullable();
            $table->text('how')->nullable();
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->integer('ticket_id')->unsigned();
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->boolean('is_on_time')->default(false);
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
        Schema::dropIfExists('preventions');
    }
}
