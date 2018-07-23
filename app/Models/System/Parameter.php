<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $table = 'parameters';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;

    /**
     * 更改log
     */
    public function change_records()
    {
        return $this->hasMany('App\Models\System\ParameterChangeRecord','parameter_id','id');
    }
    
}
