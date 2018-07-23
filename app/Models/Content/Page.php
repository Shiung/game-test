<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    protected $primaryKey = 'id';
    protected $table = 'pages';
    protected $guarded = ['created_at','updated_at'];
    public $timestamps = false;

}
