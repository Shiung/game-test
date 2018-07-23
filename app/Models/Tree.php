<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    protected $primaryKey = 'member_id';
    protected $table = 'trees';
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
     * 接點人屬於哪個會員帳號
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Member', 'parent_id', 'user_id');
    }

    
}
