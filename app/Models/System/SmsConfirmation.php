<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class SmsConfirmation extends Model
{
    //
    protected $table = 'sms_confirmations';
    protected $primaryKey = 'id';
    protected $guarded = [
    	'created_at',
    ];

    //1對1 找到members id
    /*
    public function member()
    {
        return $this->belongsTo('App\Models\member');
    }
    */
}
