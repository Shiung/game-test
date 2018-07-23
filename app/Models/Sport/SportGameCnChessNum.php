<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Model;

class SportGameCnChessNum extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'sport_game_cn_chess_nums';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

	/**
     * 屬於哪個賭盤
     */
    public function game()
    {
        return $this->belongsTo('App\Models\Sport\SportGame', 'sport_game_id', 'id');
    }

    public function chess()
    {
        return $this->belongsTo('App\Models\Sport\CnChess', 'number', 'id');
    }
}
