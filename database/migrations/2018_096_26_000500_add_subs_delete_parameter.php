<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddSubsDeleteParameter extends Migration
{
    /**
     * 會員刪除新增相關參數
     *
     * @return void
     */
    public function up()
    {
        DB::statement("INSERT INTO `parameters` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
                    (101, 'sub_delete_cash_min', '0', '2017-09-25 18:38:10', '2017-09-25 18:38:10'),
                    (102, 'sub_delete_share_min', '0', '2017-09-25 18:38:10', '2017-10-12 08:29:43'),
                    (103, 'sub_delete_manage_min', '0', '2017-10-04 18:06:35', '2017-10-04 18:06:35'),
                    (104, 'sub_delete_last_login_days', '0', '2017-10-04 18:06:35', '2017-10-12 07:58:07');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DELETE FROM `parameters` WHERE name = "sub_delete_cash_min" ');
        DB::statement('DELETE FROM `parameters` WHERE name = "sub_delete_share_min" ');
        DB::statement('DELETE FROM `parameters` WHERE name = "sub_delete_manage_min" ');
        DB::statement('DELETE FROM `parameters` WHERE name = "sub_delete_last_login_days" ');

    }
}
