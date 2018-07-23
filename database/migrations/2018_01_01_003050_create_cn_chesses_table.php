<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCnChessesTable extends Migration
{
    /**
     * 象棋牌
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cn_chesses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',10);
            $table->enum('color', ['0', '1']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cn_chesses');
    }
}
