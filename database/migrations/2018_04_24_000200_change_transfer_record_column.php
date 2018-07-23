<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeTransferRecordColumn extends Migration
{
    /**
     * 調整轉帳記錄欄位，加上轉出跟轉入的手續費
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `transfer_account_records` CHANGE `fee` `transfer_fee` INT(11) NOT NULL DEFAULT "0"');
        DB::statement('ALTER TABLE `transfer_account_records` ADD `receive_fee` INT(11) NOT NULL DEFAULT "0" AFTER `transfer_fee`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `transfer_account_records` CHANGE `transfer_fee` `fee` INT(11) NOT NULL DEFAULT "0"');
        DB::statement('ALTER TABLE `transfer_account_records` DROP COLUMN `receive_fee`');
    }
}
