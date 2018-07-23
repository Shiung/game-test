<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductMemberLevelsTable extends Migration
{
    /**
     * 會員等級商品額外的補充資訊
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_member_levels', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->enum('register', ['0', '1'])->default(0);
            $table->double('interest');
            $table->integer('member_feedback');
            $table->integer('recommender_feedback');
            $table->integer('feedback_period')->nullable();
            $table->tinyInteger('period')->nullable();
            $table->string('tree_name',3)->nullable();
            $table->foreign('product_id')->references('id')->on('products')
                    ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->primary('product_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_member_levels');
    }
}
