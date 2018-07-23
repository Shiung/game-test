<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportBetCnChessNumsTable extends Migration
{
    /**
     * 象棋選號下注紀錄
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_bet_cn_chess_nums', function (Blueprint $table) {
            
            $table->integer('sport_bet_record_id')->unsigned();
            $table->tinyInteger('gamble')->unsigned();
            $table->double('one_ratio');
            $table->double('two_ratio');
            $table->double('virtual_cash_ratio');
            $table->double('share_ratio');
            
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
        Schema::dropIfExists('sport_bet_cn_chess_nums');
    }
}
