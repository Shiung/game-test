<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Model;

class AccountRecord extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'account_records';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    
    /**
     * 哪個戶頭
     */
    public function account()
    {
        return $this->belongsTo('App\Models\Account\Account', 'account_id', 'id');
    }   

    /**
     * 對應的轉賬關聯
     */
    public function transfer_relation()
    {
        return $this->hasOne('App\Models\Account\AccountRecordTransferRecord', 'a_record_id', 'id');
    } 
}
