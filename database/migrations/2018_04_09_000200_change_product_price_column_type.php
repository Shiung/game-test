<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeProductPriceColumnType extends Migration
{
    /**
     * 商品價格改成可以小數點後兩位
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `products` CHANGE `price` `price` DECIMAL( 10, 2 ) NOT NULL DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `products` CHANGE `price` `price`  INT(11) NOT NULL DEFAULT "0"');
    }
}
