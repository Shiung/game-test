<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'transactions';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

    /**
     * 產品
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Shop\Product', 'product_id', 'id')->withTrashed();;
    } 

    /**
     * 轉出
     */
    public function transfer_member()
    {
        return $this->belongsTo('App\Models\Member', 'transfer_member_id', 'user_id');
    }

    /**
     * 轉入
     */
    public function receive_member()
    {
        return $this->belongsTo('App\Models\Member', 'receive_member_id', 'user_id');
    }


}
