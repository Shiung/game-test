<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParameterChangeRecordsTable extends Migration
{
    /**
     * 參數變動紀錄
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameter_change_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->unsigned();
            $table->integer('parameter_id')->unsigned();
            $table->string('old_value',100);
            $table->string('new_value',100);
            $table->foreign('admin_id')->references('id')->on('admins')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parameter_id')->references('id')->on('parameters')
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
        Schema::dropIfExists('parameter_change_records');
    }
}
