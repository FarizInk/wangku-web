<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('group_transactions', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('group_id');
        //     $table->enum('status', ['minus', 'plus']);
        //     $table->integer('amount');
        //     $table->text('description')->nullable();
        //     $table->date('date');
        //     $table->time('time');
        //     $table->integer('created_by');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_transactions');
    }
}
