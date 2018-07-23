<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'accounts';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    
    /**
     * 屬於哪個會員帳號
     */
    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_id', 'user_id');
    }

    /**
     * 餘額明細
     */
    public function records()
    {
        return $this->hasMany('App\Models\Account\AccountRecord','account_id','id');
    }

    
}
