<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * 會員資料
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->string('member_number',30)->unique()->nullable();
            $table->string('name');
            $table->string('phone',20)->unique()->nullable();
            $table->string('bank_code',10)->nullable();
            $table->string('bank_account',20)->nullable();
            $table->integer('recommender_id')->unsigned()->nullable();
            $table->enum('confirm_status', ['0', '1'])->default(0);
            $table->timestamp('confirmed_at')->nullable();
            $table->enum('reset_pwd_status', ['0', '1'])->default(0);
            $table->timestamp('reset_pwd_at')->nullable();
            $table->enum('place_status', ['0', '1'])->default(0);
            $table->timestamp('placed_at')->nullable();
            
            $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('recommender_id')->references('user_id')->on('members')
                    ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->primary('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
