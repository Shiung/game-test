<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ShareTransaction extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'share_transactions';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    protected $appends = ['time_left'];
    

    /**
     * 產品
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Shop\Product', 'product_id', 'id')->withTrashed();;
    } 

    /**
     * 賣家
     */
    public function seller()
    {
        return $this->belongsTo('App\Models\Member', 'seller_id', 'user_id');
    }

    /**
     * 賣家帳號
     */
    public function seller_user()
    {
        return $this->belongsTo('App\Models\User', 'seller_id', 'id');
    }

    /**
     * 買家
     */
    public function buyer()
    {
        return $this->belongsTo('App\Models\Member', 'buyer_id', 'user_id');
    }

    /**
     * 買家帳號
     */
    public function buyer_user()
    {
        return $this->belongsTo('App\Models\User', 'buyer_id', 'id');
    }

    /**
     * 剩下多少時間過期
     */
    public function getTimeLeftAttribute()
    {
        //現在時間
        $now_datetime = strtotime(date('Y-m-d H:i:s'));
        //過期時間
        $expire_datetime = strtotime($this->attributes['expire_datetime']);

        $subtraction = $expire_datetime - $now_datetime;
        $hours=floor($subtraction/3600);
        $minutes=floor($subtraction/60);

        if($hours > 0) {
            return $hours.'時';
        } else {
            return '0時';
        }

    }


}
