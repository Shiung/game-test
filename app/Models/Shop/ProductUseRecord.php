<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductUseRecord extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_use_records';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

    /**
     * 產品
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Shop\Product', 'product_id', 'id')->withTrashed();
    } 

    /**
     * 屬於哪個會員帳號
     */
    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_id', 'user_id');
    }


}
