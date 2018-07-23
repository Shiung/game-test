<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Charge extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'id';
    protected $table = 'charges';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

    /**
     * 哪位管理員確認
     */
    public function confirm_admin()
    {
        return $this->belongsTo('App\Models\Admin', 'confirm_admin_id', 'id');
    } 

    /**
     * 屬於哪個會員帳號
     */
    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_id', 'user_id');
    }


}
