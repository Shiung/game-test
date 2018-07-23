<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportGameCnChessNumsTable extends Migration
{
    /**
     * 象棋選號賭盤
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_game_cn_chess_nums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sport_game_id')->unsigned();
            $table->double('one_ratio');
            $table->double('two_ratio');
            $table->double('virtual_cash_ratio');
            $table->double('share_ratio');

            $table->foreign('sport_game_id')->references('id')->on('sport_games')
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
        Schema::dropIfExists('sport_game_cn_chess_nums');
    }
}
