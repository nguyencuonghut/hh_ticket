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
            $table->integer('director_id')->unsigned();
            $table->foreign('director_id')->references('id')->on('users');
            $table->integer('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users');
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('id')->on('departments');
            //~Description for ticket

            //Confirmation of director
            $table->integer('director_confirmation_result_id')->unsigned();
            $table->foreign('director_confirmation_result_id')->references('id')->on('approve_results');
            $table->text('director_confirmation_comment')->nullable();
            //~Confirmation of director

            //Identify the responsibility of ticket
            $table->integer('responsibility_id')->unsigned();
            $table->foreign('responsibility_id')->references('id')->on('responsibilities');
            //~Identify the responsibility of ticket

            //Evaluate the ticket
            $table->integer('root_cause_type_id')->unsigned();
            $table->foreign('root_cause_type_id')->references('id')->on('root_cause_types');
            $table->integer('evaluation_id')->unsigned();
            $table->foreign('evaluation_id')->references('id')->on('evaluations');
            $table->longText('root_cause');
            $table->integer('root_cause_approver_id')->unsigned();
            $table->foreign('root_cause_approver_id')->references('id')->on('users');
            $table->integer('evaluation_result_id')->unsigned();
            $table->foreign('evaluation_result_id')->references('id')->on('approve_results');
            //~Evaluate the ticket

            //Asset effectiveness
            $table->integer('effectiveness_id')->unsigned();
            $table->foreign('effectiveness_id')->references('id')->on('effectivenesses');
            $table->integer('effectiveness_assessor_id')->unsigned();
            $table->foreign('effectiveness_assessor_id')->references('id')->on('users');
            //~Asset effectiveness
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
