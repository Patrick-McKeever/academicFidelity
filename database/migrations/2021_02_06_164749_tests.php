<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Classes may associate "tests" with them.
 */
class Tests extends Migration
{
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            //The 'date' and 'dateTime' methods create columns which reference time of table update, so we use str.
            $table->string('date');
            $table->integer('spreadsheetId')->unsigned();
            $table->foreign('spreadsheetId')->references('id')->on('spreadsheets');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
