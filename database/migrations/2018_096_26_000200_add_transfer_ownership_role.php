<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddTransferOwnershipRole extends Migration
{
    /**
     * 會員過戶新增相關身份
     *
     * @return void
     */
    public function up()
    {
        DB::statement("INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES (101, 'transfer-ownership-record-preview', '會員過戶申請列表', NULL, NULL, NULL)");
        DB::statement("INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES (102, 'transfer-ownership-record-write', '會員過戶申請列表管理', NULL, NULL, NULL)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DELETE FROM `roles` WHERE name = "transfer-ownership-record-preview" ');
        DB::statement('DELETE FROM `roles` WHERE name = "transfer-ownership-record-write" ');

    }
}
