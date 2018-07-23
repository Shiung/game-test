<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Model;

class SportBetSpread extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'sport_bet_spreads';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

	/**
     * 屬於哪個下注紀錄
     */
    public function bet()
    {
        return $this->belongsTo('App\Models\Sport\SportBetRecord', 'sport_bet_records_id', 'id');
    }

    /**
     * 屬於哪個一隊
     */
    public function team()
    {
        return $this->belongsTo('App\Models\Sport\SportTeam', 'gamble', 'id');
    }
}
