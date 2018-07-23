<?php

namespace App\Models\Sport;

use Illuminate\Database\Eloquent\Model;

class SportCategory extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'sport_categories';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

    /**
     * 該類別的運動有哪些
     */
    public function sports()
    {
        return $this->hasMany('App\Models\Sport\Sport','sport_category_id','id');
    }
}
