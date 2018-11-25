<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_records', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', ['minus', 'plus', '-']);
            $table->integer('amount')->default(0);
            $table->integer('minus');
            $table->integer('plus');
            $table->date('date');
            $table->integer('dayRecordable_id');
            $table->string('dayRecordable_type');
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
        Schema::dropIfExists('day_records');
    }
}
