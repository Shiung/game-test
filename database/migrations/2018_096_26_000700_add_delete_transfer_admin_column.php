<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddDeleteTransferAdminColumn extends Migration
{
    /**
     * 過戶跟刪除表新增管理員欄位
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE  `subs_delete_records` ADD  `admin_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL AFTER  `id` ');
        DB::statement('ALTER TABLE  `transfer_ownership_records` ADD  `admin_id` INT( 11 ) UNSIGNED NULL DEFAULT NULL AFTER  `id` ');
   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `subs_delete_records` DROP COLUMN `admin_id`');
        DB::statement('ALTER TABLE `transfer_ownership_records` DROP COLUMN `admin_id`');
    }
}
