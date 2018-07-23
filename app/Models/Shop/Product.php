<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'id';
    protected $table = 'products';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

    /**
     * 類別
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Shop\ProductCategory', 'product_category_id', 'id');
    } 

    

    /**
     * 詳細資訊
     */
    public function info()
    {
        switch ($this->attributes['product_category_id']) {
            case 4:
                return $this->hasOne('App\Models\Shop\ProductMemberLevel');
                break;
            case 5:
                return $this->hasOne('App\Models\Shop\ProductMemberLevel');
                break;
            default:
                return null;
                break;
        }
        
    } 


}
