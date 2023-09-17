<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile');
            $table->enum('userType', ['Admin', 'User']);
            $table->tinyInteger('takesAppointment');
            $table->string('calendarID');
            $table->text('calendarUrl');
            $table->string('uTimeZone')->nullable();
            $table->text('headerImage')->nullable();
            $table->text('footerImage')->nullable();
            $table->text('stampImage')->nullable();
            $table->string('currencyCode')->default('USD');
            $table->tinyInteger('createdBy')->default(0);
            $table->integer('default_Country_Code');
            $table->tinyInteger('status')->default(1); //1- Active, 0- Inactive
            $table->string('meetingID')->nullable();
            $table->string('modPasscode')->nullable();
            $table->string('participantsCode')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
