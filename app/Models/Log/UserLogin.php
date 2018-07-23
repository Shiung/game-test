<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'user_login_logs';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    
    /**
     * 屬於哪個帳號
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * 屬於哪個會員
     */
    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'user_id', 'user_id');
    }
    
}
