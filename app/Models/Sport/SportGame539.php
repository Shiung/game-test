<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Model;

class SportGame539 extends Model
{
     //
    protected $primaryKey = 'id';
    protected $table = 'sport_game_539';
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
