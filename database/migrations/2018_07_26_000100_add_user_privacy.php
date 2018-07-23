<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddUserPrivacy extends Migration
{
    /**
     * 會員刪除新增相關權限
     *
     * @return void
     */
    public function up()
    {
        DB::statement("INSERT INTO `pages` (`id`, `title`, `content`, `code`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, '使用者規範', '我是使用者規範', 'user_guide', '1', '2017-10-31 19:34:08', '2017-12-20 19:59:46', NULL);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DELETE FROM `pages` WHERE code = "user_guide" ');

    }
}
