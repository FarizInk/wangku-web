<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMetadatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_metadatas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->text('photo')->nullable();
            $table->enum('region', ['west', 'middle', 'east']);
            $table->time('time_record');
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
        Schema::dropIfExists('user_metadatas');
    }
}
