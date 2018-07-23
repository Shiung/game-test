<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'shares';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    
}
