<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Model;

class SportBetRecord extends Model
{
     //
    protected $primaryKey = 'id';
    protected $table = 'sport_bet_records';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    protected $appends = ['bet_time'];
    

	/**
     * 屬於哪個賭盤
     */
    public function game()
    {
        return $this->belongsTo('App\Models\Sport\SportGame', 'sport_game_id', 'id');
    }

    /**
     * 屬於哪個member
     */
    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_id', 'user_id');
    }

    /**
     * 屬於哪個account
     */
    public function account()
    {
        return $this->belongsTo('App\Models\Account\Account', 'account_id', 'id');
    }

    /**
     * 有哪些下注內容
     */
    public function detail()
    {
    	if($this->attributes['type'] == 1) {
        	return $this->hasOne('App\Models\Sport\SportBetOverunder','sport_bet_record_id','id');

       	}elseif($this->attributes['type'] == 2){
       		return $this->hasOne('App\Models\Sport\SportBetSpread','sport_bet_record_id','id');

       	}elseif($this->attributes['type'] == 3){
       		return $this->hasMany('App\Models\Sport\SportBet539','sport_bet_record_id','id');

       	}elseif($this->attributes['type'] == 4){
            return $this->hasMany('App\Models\Sport\SportBetCnChessNum','sport_bet_record_id','id');
            
        }elseif($this->attributes['type'] == 5){
            return $this->hasMany('App\Models\Sport\SportBetCnChessColor','sport_bet_record_id','id');
            
        }
    }

    /**
     * 格式化下注時間
    */
    public function getBetTimeAttribute() 
    {
        if(isset($this->attributes['created_at']))
            return date('m-d H:i', strtotime($this->attributes['created_at']));
    }

}
