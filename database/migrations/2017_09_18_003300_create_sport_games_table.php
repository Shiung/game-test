<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportGamesTable extends Migration
{
    /**
     * 賭盤
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_games', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sport_id')->unsigned();
            
            $table->tinyInteger('type');
            $table->enum('processing_status', ['0', '1','2'])->default(0);
            $table->enum('bet_status', ['0', '1','2','3'])->default(0);
            $table->foreign('sport_id')->references('id')->on('sports')
                    ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sport_games');
    }
}
