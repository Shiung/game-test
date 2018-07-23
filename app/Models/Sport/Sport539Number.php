<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Model;

class Sport539Number extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'sport_539_numbers';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

	/**
     * 屬於哪個賽程
     */
    public function sport()
    {
        return $this->belongsTo('App\Models\Sport\Sport', 'sport_id', 'id');
    }

    
}
