<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberLevelRecordsTable extends Migration
{
    /**
     * 會員擁有等級紀錄
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_level_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->integer('day_count')->nullable();
            $table->integer('member_level_id')->unsigned();
            $table->enum('expired_status', ['0', '1'])->default(0);

            $table->foreign('member_id')->references('user_id')->on('members')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('member_level_id')->references('id')->on('products')
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
        Schema::dropIfExists('member_level_records');
    }
}
