<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferOwnershipRecordsTable extends Migration
{
    /**
     * 會員過戶紀錄
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_ownership_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->string('old_username');
            $table->string('old_name');
            $table->string('username');
            $table->string('password');
            $table->string('name');
            $table->enum('status', ['0', '1','2'])->default(0);

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
        Schema::dropIfExists('transfer_ownership_records');
    }
}
