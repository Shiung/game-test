<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountRecordTransferRecordsTable extends Migration
{
    /**
     * 轉帳、餘額關聯
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_record_transfer_records', function (Blueprint $table) {
           
            $table->integer('a_record_id')->unsigned();
            $table->integer('t_record_id')->unsigned();
            
            $table->foreign('a_record_id')->references('id')->on('account_records')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('t_record_id')->references('id')->on('transfer_account_records')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['a_record_id', 't_record_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_record_transfer_records');
    }
}
