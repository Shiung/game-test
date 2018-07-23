<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareRecordsTable extends Migration
{
    /**
     * 娛樂幣增減紀錄
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned()->nullable();
            $table->decimal('amount', 13, 0)->default(0);
            $table->decimal('total', 13, 0)->default(0);
            $table->enum('type', ['company_add', 'member_buy','company_give']);
            $table->foreign('transaction_id')->references('id')->on('transactions')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_records');
    }
}
