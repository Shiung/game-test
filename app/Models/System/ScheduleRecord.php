<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class ScheduleRecord extends Model
{
    protected $table = 'schedule_records';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    
}
