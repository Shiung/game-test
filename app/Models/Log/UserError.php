<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;

class UserError extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'user_error_logs';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    
    /**
     * 屬於哪個帳號
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }


    
}
