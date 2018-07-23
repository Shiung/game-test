<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * 商城交易
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transfer_member_id')->unsigned()->nullable();
            $table->integer('receive_member_id')->unsigned()->nullable();
            
            $table->integer('product_id')->unsigned();
            $table->integer('price')->default(0);
            $table->integer('quantity'); 
            $table->integer('fee')->default(0);
            $table->integer('total');
            $table->enum('type', ['give', 'transfer','buy']);
            $table->string('description')->nullable();

            $table->foreign('transfer_member_id')->references('user_id')->on('members')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('receive_member_id')->references('user_id')->on('members')
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
        Schema::dropIfExists('transactions');
    }
}
