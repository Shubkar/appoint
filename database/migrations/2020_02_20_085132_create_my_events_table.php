<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userId');
            $table->string('eventId');
            $table->string('calendarName');
            $table->string('calendarAccount');
            $table->string('customerName');
            $table->string('caseId');
            $table->string('mobileNumber');
            $table->dateTime('dtStart');
            $table->dateTime('dtEnd');
            $table->tinyInteger('allDay');
            $table->text('symptoms')->nullable();
            $table->text('dignosis')->nullable();
            $table->float('feeAmount',11,2)->nullable();
            $table->float('balancePayment',11,2)->nullable();
            $table->string('paymentMode')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('invoiceNumber')->nullable();
            $table->enum('eventStatus',['Not Attended', 'Attended', 'Deleted'])->default('Not Attended');
            $table->tinyInteger('isOnline')->default(0);
             $table->string('meetingID');
              $table->string('modPasscode');
            $table->string('participantsCode');
            $table->string('courier');
            $table->string('awbNumber');
            $table->text('medicine')->nullable();
            $table->tinyInteger('confirmReceived')->default(0);
            $table->tinyInteger('courierSent')->default(0);
            $table->enum('folloupBooked',['Yes','No'])->default('No');
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
        Schema::dropIfExists('my_events');
    }
}
