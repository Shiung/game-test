<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class ParameterChangeRecord extends Model
{
    protected $table = 'parameter_change_records';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;

    /**
     * 屬於哪個參數
     */
    public function parameter()
    {
        return $this->belongsTo('App\Models\System\Parameter', 'parameter_id', 'id');
    }

    /**
     * 屬於哪個管理員改的
     */
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'admin_id', 'id');
    }
    
}
