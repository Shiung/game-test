<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Model;

class SportGameCnChessColor extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'sport_game_cn_chess_colors';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;

	/**
     * 屬於哪個賭盤
     */
    public function game()
    {
        return $this->belongsTo('App\Models\Sport\SportGame', 'sport_game_id', 'id');
    }
}
