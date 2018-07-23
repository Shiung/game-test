<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Model;

class SportGame extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'sport_games';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

	/**
     * 屬於哪個賽程
     */
    public function sport()
    {
        return $this->belongsTo('App\Models\Sport\Sport', 'sport_id', 'id');
    }

    /**
     * 有哪些賭局內容
     */
    public function detail()
    {
    	if($this->attributes['type'] == 1) {
        	return $this->hasOne('App\Models\Sport\SportGameOverUnder','sport_game_id','id');

       	}elseif($this->attributes['type'] == 2){
       		return $this->hasOne('App\Models\Sport\SportGameSpread','sport_game_id','id');

       	}elseif($this->attributes['type'] == 3){
       		return $this->hasOne('App\Models\Sport\SportGame539','sport_game_id','id');

       	}elseif ($this->attributes['type'] == 4) {
            return $this->hasOne('App\Models\Sport\SportGameCnChessNum','sport_game_id','id');

        }elseif ($this->attributes['type'] == 5) {
            return $this->hasOne('App\Models\Sport\SportGameCnChessColor','sport_game_id','id');
            
        }
    }

    /**
     * 有哪些下注紀錄
     */
    public function bets()
    {
    	return $this->hasMany('App\Models\Sport\SportBetRecord','sport_game_id','id');
    }
}

