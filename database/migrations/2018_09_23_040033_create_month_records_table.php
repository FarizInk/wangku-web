<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('month_records', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', ['minus', 'plus', '-']);
            $table->integer('amount');
            $table->integer('minus');
            $table->integer('plus');
            $table->date('date');
            $table->integer('monthRecordable_id');
            $table->string('monthRecordable_type');
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
        Schema::dropIfExists('month_records');
    }
}
