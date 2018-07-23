<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marquee extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    protected $table = 'marquees';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    
}
