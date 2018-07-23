<?php
namespace App\Services\Member;

use App;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Services\API\MobileService;

class MobileSmsService {
    

    protected $mobileService;
    
    public function __construct(MobileService $mobileService)
    {   
        $this->mobileService =  $mobileService; 
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
            //hinet
            if(env("SMS_SERVER",'hinet')=='hinet')
                $result = $this->mobileService->hinet_send_text($phone, $msg);

            //三竹
            if(env("SMS_SERVER",'hinet')=='san_chu')
                $result = $this->mobileService->sms_send($phone, $msg);
        } catch (Exception $e){
         
            return ['status' => false, 'error'=> $e->getMessage()];
        }
        if($result['result'] == 1){
            return ['status' => true];
        } else {
           return ['status' => false, 'error'=> $result]; 
        }
    }

    /**
     * 產生認證簡訊  寄出認證簡訊，取得view id
     * @param string $user
     * @param string $phone
     * @return array 
     */
    public function createVerify($user,$phone = null)
    {
        try{
            if($phone)
                $result = $this->mobileService->create($user->id,$phone);
            else
                $result = $this->mobileService->create($user->id);
        } catch (Exception $e){
         
            return ['status' => false, 'error'=> $e->getMessage(),'error_msg'=> '','id' => ''];
        }
        if($result['result'] == 1){
            return ['status' => true , 'id' => $result['id']];
        } else {
           return ['status' => false, 'id' => $result['id'], 'error'=> $result['error_code'] ,'error_msg'=> $result['error_msg']]; 
        }
    }

    /**
     * 簡訊認證
     * @param string $id
     * @param string $code
     * @return array 
     */
    public function verify($id,$code)
    {
        try{
            $result = $this->mobileService->auth($id, $code);
        } catch (Exception $e){
         
            return ['status' => false, 'error'=> $e->getMessage(),'error_msg'=> $e->getMessage()];
        }
        if($result['result'] == 1){
            return ['status' => true ,'id' => $id];
        } else {
           return ['status' => false, 'id' => $result['id'], 'error'=> $result['error_code'],'error_msg'=> $result['error_msg']]; 
        }
    }

  
}
