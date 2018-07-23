<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportCategoriesTable extends Migration
{
    /**
     * 遊戲類別
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type',100);
            $table->integer('timezone');
            $table->integer('timezone_summer');
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
        Schema::dropIfExists('sport_categories');
    }
}
