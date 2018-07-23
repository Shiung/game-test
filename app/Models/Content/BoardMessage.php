<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardMessage extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    protected $table = 'board_messages';
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
