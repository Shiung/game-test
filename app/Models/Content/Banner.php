<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    protected $table = 'banners';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    
}
