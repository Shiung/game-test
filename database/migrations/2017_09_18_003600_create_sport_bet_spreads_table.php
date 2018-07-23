<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportBetSpreadsTable extends Migration
{
    /**
     * 下注讓分補充資訊
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_bet_spreads', function (Blueprint $table) {
            
            $table->integer('sport_bet_record_id')->unsigned();
            $table->integer('gamble')->unsigned();
            $table->double('dead_heat_point');
            $table->double('real_bet_ratio');
            $table->integer('dead_heat_team_id')->unsigned();
            $table->double('line');
            $table->foreign('sport_bet_record_id')->references('id')->on('sport_bet_records')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('dead_heat_team_id')->references('id')->on('sport_teams')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('gamble')->references('id')->on('sport_teams')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('created_at')->nullable()->default(\DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('sport_bet_spreads');
    }
}
