<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferAccountRecordsTable extends Migration
{
    /**
     * 轉帳記錄
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_account_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transfer_member_id')->unsigned()->nullable();
            $table->integer('transfer_account_id')->unsigned()->nullable();
            $table->integer('transfer_amount');

            $table->integer('receive_member_id')->unsigned()->nullable();
            $table->integer('receive_account_id')->unsigned()->nullable();
            $table->integer('receive_amount');

            $table->integer('fee')->default(0);
            $table->tinyInteger('type');
            $table->string('description')->nullable();

            
            $table->foreign('transfer_account_id')->references('id')->on('accounts')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('transfer_member_id')->references('user_id')->on('members')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('receive_account_id')->references('id')->on('accounts')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('receive_member_id')->references('user_id')->on('members')
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
        Schema::dropIfExists('transfer_account_records');
    }
}
