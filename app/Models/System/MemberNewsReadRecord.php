<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class MemberNewsReadRecord extends Model
{
    protected $table = 'member_news_read_records';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

    /**
     * 屬於哪個會員帳號
     */
    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_id', 'user_id');
    }



}
