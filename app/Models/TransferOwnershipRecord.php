<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferOwnershipRecord extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'transfer_ownership_records';
    protected $guarded = ['created_at','updated_at'];
    public $timestamps = false;
    
    /**
     * 屬於哪個使用者帳號
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'member_id', 'id');
    }

    /**
     * 屬於哪個管理員帳號
     */
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'admin_id', 'id');
    }

    


    
}
