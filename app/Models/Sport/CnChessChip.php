<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Model;

class CnChessChip extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'cn_chess_chips';
    protected $guarded = ['created_at'];
    public $timestamps = false;

}
