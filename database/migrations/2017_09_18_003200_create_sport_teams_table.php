<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportTeamsTable extends Migration
{
    /**
     * 隊伍
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('sport_number',50)->nullable();
            $table->integer('sport_id')->unsigned();
            $table->integer('score')->default(0);
            $table->enum('home', ['0', '1'])->default(0);
            
            $table->foreign('sport_id')->references('id')->on('sports')
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
        Schema::dropIfExists('sport_teams');
    }
}
