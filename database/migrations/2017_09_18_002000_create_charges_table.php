<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargesTable extends Migration
{
    /**
     * 線上儲值
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->integer('confirm_admin_id')->unsigned()->nullable();
            $table->integer('amount')->default(0);
            $table->enum('confirm_status', ['0', '1', '2'])->default(0);
            $table->timestamp('confirm_at')->nullable();
            $table->foreign('member_id')->references('user_id')->on('members')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('confirm_admin_id')->references('id')->on('admins')
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
        Schema::dropIfExists('charges');
    }
}
