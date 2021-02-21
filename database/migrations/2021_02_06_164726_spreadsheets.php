<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Each class will have a number of spreadsheets associated with it.
 * "spreadsheets" stores these.
 */
class Spreadsheets extends Migration
{
    public function up()
    {
        Schema::create('spreadsheets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            //'standards' column stores standards associated with spreadsheet.
            $table->json('standards')->nullable();
            //'slgs' stores slgs associated with spreadsheet.
            $table->json('slgs')->nullable();
            $table->integer('classId')->unsigned();
            $table->foreign('classId')->references('id')->on('classes');
            $table->integer('ownerId')->unsigned();
            $table->foreign('ownerId')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('spreadsheets');
    }
}
