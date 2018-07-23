<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberNewsReadRecordsTable extends Migration
{
    /**
     * 最新消息已讀紀錄
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_news_read_records', function (Blueprint $table) {
            $table->integer('member_id')->unsigned();
            $table->integer('news_id')->unsigned();

            $table->foreign('member_id')->references('user_id')->on('members')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('news_id')->references('id')->on('news')
                    ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));

            $table->primary(['member_id', 'news_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('member_news_read_records');
    }
}
