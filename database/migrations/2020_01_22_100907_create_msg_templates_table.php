<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsgTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('msg_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('msg_type',['Confirmation', 'HourBefore','DayBefore']);
            $table->text('actual_msg');
            $table->integer('msg_time');
            $table->integer('sub_id');
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
        Schema::dropIfExists('msg_templates');
    }
}
