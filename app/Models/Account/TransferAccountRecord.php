<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Model;

class TransferAccountRecord extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'transfer_account_records';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    

    /**
     * 誰轉
     */
    public function transfer_member()
    {
        return $this->belongsTo('App\Models\Member', 'transfer_member_id', 'user_id');
    } 

    /**
     * 哪個戶頭轉
     */
    public function transfer_account()
    {
        return $this->belongsTo('App\Models\Account\Account', 'transfer_account_id', 'id');
    } 

    /**
     * 誰取得
     */
    public function receive_member()
    {
        return $this->belongsTo('App\Models\Member', 'receive_member_id', 'user_id');
    } 

    /**
     * 哪個戶頭取捯
     */
    public function receive_account()
    {
        return $this->belongsTo('App\Models\Account\Account', 'transfer_account_id', 'id');
    } 
}
