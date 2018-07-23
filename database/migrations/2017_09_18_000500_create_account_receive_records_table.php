<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountReceiveRecordsTable extends Migration
{
    /**
     * 簽到中心
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_receive_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->integer('amount')->default(0);
            $table->enum('status', ['0', '1','2'])->default(0);
            $table->string('description')->nullable();
            $table->integer('day_count')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('member_id')->references('user_id')->on('members')
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
        Schema::dropIfExists('account_receive_records');
    }
}
