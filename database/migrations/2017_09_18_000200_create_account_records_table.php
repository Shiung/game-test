<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountRecordsTable extends Migration
{
    /**
     * 帳戶餘額紀錄
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->tinyInteger('type');
            $table->integer('amount');
            $table->integer('total');
            $table->string('description')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')
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
        Schema::dropIfExists('account_records');
    }
}
