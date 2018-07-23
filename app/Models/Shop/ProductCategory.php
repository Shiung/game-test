<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_categories';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

    /**
     * 該類別產品
     */
    public function products()
    {
        return $this->hasMany('App\Models\Shop\Product','product_category_id','id');
    }


}
