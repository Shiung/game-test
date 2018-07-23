<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCnChessChipsTable extends Migration
{
    /**
     * 象棋籌碼
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cn_chess_chips', function (Blueprint $table) {
            $table->tinyInteger('id')->unsigned();
            $table->string('name',10);
            $table->text('content');
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cn_chess_chips');
    }
}
