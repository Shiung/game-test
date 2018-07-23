<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberLevelRecord extends Model
{
    protected $primaryKey = 'user_id';
    protected $table = 'member_level_records';
    protected $guarded = ['updated_at'];
    public $timestamps = false;
    
    /**
     * 屬於哪個使用者帳號
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    


    
}
