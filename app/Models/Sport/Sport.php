<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'sports';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

	/**
     * 屬於哪個類別
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Sport\SportCategory', 'sport_category_id', 'id');
    }

    /**
     * 有哪些隊伍
     */
    public function teams()
    {
        if($this->attributes['sport_category_id'] == '1') {
            return $this->hasMany('App\Models\Sport\SportTeam','sport_id','id');

        } elseif($this->attributes['sport_category_id'] == '2'){
            return $this->hasMany('App\Models\Sport\SportTeam','sport_id','id');

        } elseif($this->attributes['sport_category_id'] == '3'){
            return $this->hasMany('App\Models\Sport\Sport539Number','sport_id','id');
        }elseif($this->attributes['sport_category_id'] == '4'){
            return $this->hasMany('App\Models\Sport\SportCnChessNumber','sport_id','id');
        }elseif( $this->attributes['sport_category_id'] == '5'){

            return $this->hasMany('App\Models\Sport\SportTeam','sport_id','id');
        }

    }

    /**
     * 有哪些賭盤
     */
    public function games()
    {
        return $this->hasMany('App\Models\Sport\SportGame','sport_id','id');
    }


}
