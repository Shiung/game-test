<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $primaryKey = 'id';
    protected $table = 'users';
    protected $guarded = ['created_at','updated_at'];
    public $timestamps = false;


    //protected $guarded=['user_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 使用者對應資訊
     *
     */
    public function member()
    {
        if($this->attributes['type'] != 'admin') {
            //一般會員
            return $this->hasOne('App\Models\Member');
        } else {
            //管理員
            return null;
        }   
    }
    
 

}
