<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Spreadsheets store the scores of students on various tests.
 * "spreadsheetValues" stores these values.
 */
class SpreadsheetValues extends Migration
{
    public function up()
    {
        Schema::create('spreadsheetValues', function (Blueprint $table) {
            $table->id();
            $table->string('value')->nullable();
            $table->integer('testId')->unsigned();
            $table->foreign('testId')->references('id')->on('tests');
            $table->integer('studentId')->unsigned();
            $table->foreign('studentId')->references('id')->on('classMembers');
            $table->integer('spreadsheetId')->unsigned();
            $table->foreign('spreadsheetId')->references('id')->on('spreadsheets');
        });
    }

    public function down()
    {
        Schema::dropIfExists('spreadsheetValues');
    }
}
