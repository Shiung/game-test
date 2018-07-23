<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;

class AdminActivity extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'admin_activity_logs';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    
    /**
     * 屬於哪個管理員帳號
     */
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'admin_id', 'id');
    }


    
}
