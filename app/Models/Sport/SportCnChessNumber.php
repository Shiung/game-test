<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Model;

class SportCnChessNumber extends Model
{
    //
    //
    protected $primaryKey = 'id';
    protected $table = 'sport_cn_chess_numbers';
    protected $guarded = ['created_at'];
    public $timestamps = false;

    /**
     * 屬於哪個賽程
     */
    public function sport()
    {
        return $this->belongsTo('App\Models\Sport\Sport', 'sport_id', 'id');
    }

    public function chess()
    {
        return $this->belongsTo('App\Models\Sport\CnChess', 'number', 'id');
    }
}
