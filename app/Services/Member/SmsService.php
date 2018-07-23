<?php
namespace App\Services\Member;

use App;
use Illuminate\Support\Facades\DB;
use Exception;

class SmsService {
    

    /**
     * SmsService constructor.
     *
     * @param 
     */
    public function __construct(

    ) {

    }

    /**
     * 純寄簡訊
     * @param string $phone
     * @param string $msg 
     * @return array
     */
    public function send($phone,$msg)
    {
        try{
            $send_data = [
                'number' => $phone,
                'msg' => $msg
            ];
            $result = curlApi(env('API_URL')."/sms/send_text",$send_data); 
            $result = json_decode($result, true);
            if($result['result'] == 1){
                return ['status' => true];
            } else {
               return ['status' => false, 'error'=> $result]; 
            }
        } catch (Exception $e){
         
            return ['status' => false, 'error'=> $e->getMessage()];
        }
    }

    /**
     * 產生認證簡訊  寄出認證簡訊，取得view id
     * @param string $token 
     * @param string $phone
     * @return array 
     */
    public function createVerify($token,$phone = null)
    {
        try{
            $send_data = [
                'number' => $phone,
                'token' => $token
            ];
            $result = curlApi(env('API_URL')."/sms/create",$send_data); 
            $result = json_decode($result, true);
            if($result['result'] == 1){
                return ['status' => true , 'id' => $result['id']];
            } else {
               return ['status' => false, 'id' => $result['id'], 'error'=> $result['error_code'] ,'error_msg'=> $result['error_msg']]; 
            }
        } catch (Exception $e){
         
            return ['status' => false, 'error'=> $e->getMessage(),'error_msg'=> '','id' => ''];
        }
    }

    /**
     * 簡訊認證
     * @param string $token 
     * @param string $id
     * @param string $code
     * @return array 
     */
    public function verify($token,$id,$code)
    {
        try{
            $send_data = [
                'id' => $id,
                'token' => $token,
                'code' => $code
            ];
            $result = curlApi(env('API_URL')."/sms/auth",$send_data); 
            $result = json_decode($result, true);
            if($result['result'] == 1){
                return ['status' => true ,'id' => $id];
            } else {
               return ['status' => false, 'id' => $result['id'], 'error'=> $result['error_code'],'error_msg'=> $result['error_msg']]; 
            }
        } catch (Exception $e){
         
            return ['status' => false, 'error'=> $e->getMessage(),'error_msg'=> ''];
        }
    }

  
}
