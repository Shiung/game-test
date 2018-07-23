<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Model;

class AccountRecordTransferRecord extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'account_record_transfer_records';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;

    /**
     * 轉出
     */
    public function transfer_member()
    {
        return $this->belongsTo('App\Models\Member', 'transfer_member_id', 'user_id');
    }

    /**
     * 轉入
     */
    public function receive_member()
    {
        return $this->belongsTo('App\Models\Member', 'receive_member_id', 'user_id');
    }

    /**
     * 對應的轉賬記錄
     */
    public function transfer_record()
    {
        return $this->belongsTo('App\Models\Account\TransferAccountRecord', 't_record_id', 'id');
    }

}
