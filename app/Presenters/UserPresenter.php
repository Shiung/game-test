<?php
namespace App\Presenters;

class UserPresenter
{
    /**
     * 解析取得電話類資料
     *
     * @param  string $value
     * @param string $type
     * @return string
     */
    public function getPhoneTypeData($value,$type)
    {
        if($value != '' && $value != ' ' && $value) {
            $arr = explode('-',$value);
            if(count($arr)>1) {
                if($type == 'first') {
                    return $arr[0];
                } else {
                    return $arr[1];
                }
            }
            
        } 
        
        return '';
        
    }

}