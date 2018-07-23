<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddSubsDeleteRole extends Migration
{
    /**
     * 會員刪除新增相關權限
     *
     * @return void
     */
    public function up()
    {
        DB::statement("INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES (103, 'subs-delete-record-preview', '會員刪除申請列表', NULL, NULL, NULL)");
        DB::statement("INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES  (104, 'subs-delete-record-write', '會員刪除申請列表管理', NULL, NULL, NULL)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DELETE FROM `parameters` WHERE name = "subs-delete-record-preview" ');
        DB::statement('DELETE FROM `parameters` WHERE name = "subs-delete-record-write" ');

    }
}
