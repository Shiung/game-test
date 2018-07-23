<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreesTable extends Migration
{
    /**
     * 會員間的結構樹關係
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trees', function (Blueprint $table) {
            $table->integer('member_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->tinyInteger('position');

            $table->foreign('parent_id')->references('user_id')->on('members')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('member_id')->references('user_id')->on('members')
                    ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));

            $table->primary('member_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trees');
    }
}
