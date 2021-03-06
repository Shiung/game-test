<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddMemberAgreeColumn extends Migration
{
    /**
     * 會員新增是否顯示的欄位
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `members` ADD `agree_status` ENUM("0","1") NOT NULL DEFAULT "0" AFTER `recommender_id`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `members` DROP COLUMN `agree_status`');
    }
}
