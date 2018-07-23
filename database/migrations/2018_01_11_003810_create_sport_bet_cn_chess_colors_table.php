<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportBetCnChessColorsTable extends Migration
{
    /**
     * 象棋選色下注紀錄
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_bet_cn_chess_colors', function (Blueprint $table) {
            
            $table->integer('sport_bet_record_id')->unsigned();
            $table->tinyInteger('gamble')->unsigned();
            $table->double('black_ratio');
            $table->double('red_ratio');

            $table->foreign('sport_bet_record_id')->references('id')->on('sport_bet_records')
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
        Schema::dropIfExists('sport_bet_cn_chess_colors');
    }
}
