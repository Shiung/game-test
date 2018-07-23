<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportBetOverundersTable extends Migration
{
    /**
     * 下注大小補充資訊
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_bet_overunders', function (Blueprint $table) {
            
            $table->integer('sport_bet_record_id')->unsigned();
            $table->enum('gamble', ['0', '1']);
            $table->double('line');
            $table->double('real_bet_ratio');
            $table->double('dead_heat_point');
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
        Schema::dropIfExists('sport_bet_overunders');
    }
}
