<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportCnChessNumbersTable extends Migration
{
    /**
     * 象棋開獎棋
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_cn_chess_numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('number');
            $table->integer('sport_id')->unsigned();
            
            $table->foreign('sport_id')->references('id')->on('sports')
                    ->onUpdate('cascade')->onDelete('cascade');


            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sport_cn_chess_numbers');
    }
}
