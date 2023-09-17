<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userId')->index();
            $table->string('name');
            $table->string('caseId');
            $table->string('mobile');
            $table->string('email');

            $table->enum('gender',['-','M','F'])->default('-');
            $table->integer('age')->nullable();
            $table->string('occupation')->nullable();
            $table->string('refferedBy')->nullable();
            $table->enum('infoSharing',['Yes','No'])->default('No');
            $table->tinyInteger('newsLetter')->default(0);
            $table->text('address')->nullable();
            $table->string('ethnicity')->nullable();
            $table->string('idNumber')->nullable();
            $table->text('remark1')->nullable();
            $table->text('remark2')->nullable();

            $table->tinyInteger('status');
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
        Schema::dropIfExists('customers');
    }
}
