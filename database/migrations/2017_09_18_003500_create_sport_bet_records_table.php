<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportBetRecordsTable extends Migration
{
    /**
     * 下注紀錄
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_bet_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bet_number',30)->nullable();
            $table->integer('member_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->integer('sport_game_id')->unsigned();
            $table->integer('amount');
            $table->integer('real_bet_amount')->nullable();
            $table->integer('result_amount')->nullable();
            $table->enum('type', ['1', '2','3','4','5']);
            
            $table->foreign('sport_game_id')->references('id')->on('sport_games')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('member_id')->references('user_id')->on('members')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')
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
        Schema::dropIfExists('sport_bet_records');
    }
}
