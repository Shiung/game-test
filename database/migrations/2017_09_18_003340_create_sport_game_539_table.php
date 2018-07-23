<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportGame539Table extends Migration
{
    /**
     * 539賭盤擴充資訊
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_game_539', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sport_game_id')->unsigned();
            $table->double('one_ratio');
            $table->double('two_ratio');
            $table->double('three_ratio');

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
        Schema::dropIfExists('sport_game_539');
    }
}
