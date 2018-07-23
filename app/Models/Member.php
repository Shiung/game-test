<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $primaryKey = 'user_id';
    protected $table = 'members';
    protected $guarded = ['updated_at'];
    public $timestamps = false;
    
    /**
     * 屬於哪個使用者帳號
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * 推薦人
     */
    public function recommender()
    {
        return $this->belongsTo('App\Models\Member', 'recommender_id', 'user_id');
    }

    /**
     * 樹下線
     */
    public function tree_subs()
    {
        return $this->hasMany('App\Models\Tree','parent_id','user_id');
    }

    /**
     * 樹下線
     */
    public function tree_sub_members()
    {
        //return $this->hasMany('App\Models\Tree','parent_id','user_id');
        return $this->belongsToMany('App\Models\Member', 'trees', 'parent_id', 'member_id')->withPivot('position');
   
    }

    /*
     * 帳戶
     */
    public function accounts()
    {
        return $this->hasMany('App\Models\Account\Account','member_id','user_id');
    }

    /**
     * 背包商品
     */
    public function product_bags()
    {
        return $this->belongsToMany('App\Models\Shop\Product', 'product_bags', 'member_id', 'product_id')->withPivot('quantity AS bag_quantity');;
    }

     /*
     * 我的商品（用來算數量）
     */
    public function my_products()
    {
        return $this->hasMany('App\Models\Shop\ProductBag','member_id','user_id');
    }


    
}
