<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            //Description for ticket
            $table->longText('title');
            $table->dateTime('deadline');//Thời hạn đưa ra nguyên nhân gốc rễ và hành động phòng ngừa
            $table->integer('source_id')->unsigned();
            $table->foreign('source_id')->references('id')->on('sources');
            $table->string('what');
            $table->string('why');
            $table->dateTime('when');
            $table->string('who');
            $table->string('where');
            $table->string('how_1');
            $table->integer('how_2')->unsigned();
            $table->string('image_path')->nullable();
            $table->integer('manager_id')->unsigned();
            $table->foreign('manager_id')->references('id')->on('users');
            $table->integer('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users');
            //~Description for ticket
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
        Schema::dropIfExists('tickets');
    }
}
