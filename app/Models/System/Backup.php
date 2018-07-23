<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Backup extends Model
{
    protected $table = 'backup';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    
}
