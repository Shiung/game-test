<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Model;

class AccountReceiveRecord extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'account_receive_records';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

    /**
     * 屬於那個會員
     */
    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_id', 'user_id');
    } 

    /**
     * 哪個戶頭
     */
    public function account()
    {
        return $this->belongsTo('App\Models\Account\Account', 'account_id', 'id');
    } 

    /**
     * 格式化過期時間
     */
    public function getExpireTimeAttribute() 
    {
        if(!$this->attributes['day_count']){
            return '無限期';
        } else {
            return date('Y-m-d H:i', strtotime('+'.$this->attributes['day_count'].'days',strtotime($this->attributes['created_at'])));
        }
        
    }
}
