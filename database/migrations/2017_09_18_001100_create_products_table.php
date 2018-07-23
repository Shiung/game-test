<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * 商品
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('product_category_id')->unsigned();
            $table->integer('price')->default(0);
            $table->enum('status', ['0', '1'])->default(0);
            $table->integer('quantity')->default(100);
            $table->enum('subtract', ['0', '1'])->default(0);
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->foreign('product_category_id')->references('id')->on('product_categories')
                    ->onUpdate('cascade')->onDelete('cascade');


            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
