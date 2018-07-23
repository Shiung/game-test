<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportsTable extends Migration
{
    /**
     * 遊戲、賽事
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('sport_number',50)->nullable();
            $table->integer('sport_category_id')->unsigned();
            $table->datetime('taiwan_datetime')->nullable();
            $table->datetime('start_datetime');
            $table->string('status',50);
            
            $table->foreign('sport_category_id')->references('id')->on('sport_categories')
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
        Schema::dropIfExists('sports');
    }
}
