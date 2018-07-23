<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductMemberLevel extends Model
{
    protected $primaryKey = 'product_id';
    protected $table = 'product_member_levels';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

    /**
     * 產品
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Shop\Product', 'product_id', 'id')->withTrashed();;
    } 



}
