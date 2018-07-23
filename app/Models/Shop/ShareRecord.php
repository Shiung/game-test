<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ShareRecord extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'share_records';
    protected $guarded = ['updated_at','created_at'];
    public $timestamps = false;
    
     /**
     * 屬於哪筆交易
     */
    public function transaction()
    {
        return $this->belongsTo('App\Models\Shop\Transaction', 'transaction_id', 'id');
    } 
}
