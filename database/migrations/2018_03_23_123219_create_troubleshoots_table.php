<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTroubleshootsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('troubleshoots', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('troubleshooter_id')->unsigned();
            $table->foreign('troubleshooter_id')->references('id')->on('users');
            $table->integer('pre_troubleshooter_id')->unsigned();
            $table->foreign('pre_troubleshooter_id')->references('id')->on('users');
            $table->integer('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users');
            $table->integer('ticket_id')->unsigned();
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->dateTime('deadline');
            $table->integer('status_id')->unsigned;
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->integer('is_on_time');//true-Open, false-Closed
            $table->dateTime('finished_at');//Time when action is finished
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
        Schema::dropIfExists('troubleshoots');
    }
}
