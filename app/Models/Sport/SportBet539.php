<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Model;

class SportBet539 extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'sport_bet_539';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

	/**
     * 屬於哪個下注紀錄
     */
    public function bet()
    {
        return $this->belongsTo('App\Models\Sport\SportBetRecord', 'sport_bet_records_id', 'id');
    }
}
