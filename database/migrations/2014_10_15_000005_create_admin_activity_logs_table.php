<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminActivityLogsTable extends Migration
{
    /**
     * 管理員操作記錄表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_activity_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->unsigned();
            $table->string('ip_address',30);
            $table->string('type',225);
            $table->string('content',500);
            $table->foreign('admin_id')->references('id')->on('admins')
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
        Schema::dropIfExists('admin_activity_logs');
    }
}
