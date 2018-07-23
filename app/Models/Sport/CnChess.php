<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Model;

class CnChess extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'cn_chesses';
    protected $guarded = [];
    public $timestamps = false;
}
