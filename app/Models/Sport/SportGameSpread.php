<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Model;

class SportGameSpread extends Model
{
     //
    protected $primaryKey = 'id';
    protected $table = 'sport_game_spreads';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

	/**
     * 屬於哪個賭盤
     */
    public function game()
    {
        return $this->belongsTo('App\Models\Sport\SportGame', 'sport_game_id', 'id');
    }

    /**
     * 以哪個隊伍為主讓分
     */
    public function dead_heat_team()
    {
        return $this->belongsTo('App\Models\Sport\SportTeam', 'dead_heat_team_id', 'id');
    }
}
