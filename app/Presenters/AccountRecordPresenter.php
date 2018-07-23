<?php
namespace App\Presenters;

class AccountRecordPresenter
{



    /**
     * AccountRecordPresenter constructor.
     *
     * @param 
     */
    public function __construct(

    ) {

    }


    /**
     * 顯示帳戶明細
     * @return string
     */
    public function showDescription($data)
    {
        $record =  $data->transfer_relation->transfer_record;
    
        if($record->type == 2){
            $arr = explode("(",$record->description);

            return $arr[0].'( '.$record->transfer_member->user->username.' -> '.$record->receive_member->user->username.' )';
        } else {
            return $record->description;
        }
    }


   
}