<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageQuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_ques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('appointmentId');
            $table->bigInteger('templateId');
            $table->text('message');
            $table->dateTime('sentOn')->nullable();
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
        Schema::dropIfExists('message_ques');
    }
}
