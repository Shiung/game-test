<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportGameCnChessColorsTable extends Migration
{
    /**
     * 象棋選色賭盤
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_game_cn_chess_colors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sport_game_id')->unsigned();
            $table->double('red_ratio');
            $table->double('black_ratio');
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
        Schema::dropIfExists('sport_game_cn_chess_colors');
    }
}
