<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsConfirmationsTable extends Migration
{
    /**
     * 簡訊驗證
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_confirmations', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->integer('member_id')->unsigned();
            $table->string('code',10);
            
            $table->foreign('member_id')->references('user_id')->on('members')
                    ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_confirmations');
    }
}
