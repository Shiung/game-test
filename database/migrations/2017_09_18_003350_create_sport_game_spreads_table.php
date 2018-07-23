<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportGameSpreadsTable extends Migration
{
    /**
     * 讓分賭盤擴充資訊
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_game_spreads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sport_game_id')->unsigned();
            $table->double('home_line')->nullable();
            $table->double('away_line')->nullable();
            $table->double('adjust_line')->default(0);
            $table->double('real_bet_ratio')->nullable();
            $table->double('dead_heat_point')->default(0)->nullable();
            $table->integer('dead_heat_team_id')->unsigned()->nullable();
            $table->integer('spread_one_side_bet')->nullable();

            $table->foreign('sport_game_id')->references('id')->on('sport_games')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('dead_heat_team_id')->references('id')->on('sport_teams')
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
        Schema::dropIfExists('sport_game_spreads');
    }
}
