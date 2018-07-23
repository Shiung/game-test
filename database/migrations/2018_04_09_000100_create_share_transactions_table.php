<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateShareTransactionsTable extends Migration
{
    /**
     * 掛單紀錄
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_number',20);
            $table->integer('seller_id')->unsigned();
            $table->integer('buyer_id')->unsigned()->nullable();
            $table->integer('product_id')->unsigned();
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->integer('amount');
            $table->integer('fee')->nullable();
            $table->enum('status', ['0' ,'1', '2','3'])->default(0);
            $table->timestamp('deal_at')->nullable();
            $table->timestamp('expire_datetime')->nullable();
            $table->foreign('seller_id')->references('user_id')->on('members')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('buyer_id')->references('user_id')->on('members')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')
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
        Schema::dropIfExists('share_transactions');
    }
}
