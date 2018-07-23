<?php
namespace App\Services;

use App;
use App\Services\UserService;
use App\Services\Member\SmsService;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;

class ForgetPwdService {
    
    protected $userService;
    protected $smsService;
    protected $user;
    /**
     * ForgetPwdService constructor.
     *
     * @param UserService $userService
     * @param SmsService $smsService
     */
    public function __construct(
        SmsService $smsService,
        UserService $userService
    ) {
        $this->userService = $userService;
        $this->smsService = $smsService;
    }

    /**
     * 檢查會員是否存在
     * @param string $username
     * @param string $phone
     * @return bool
     */
    public function checkUser($username,$phone)
    {
        //確認此帳號是否存在
        $user = $this->userService->getUserByUsername($username);
        if(!$user){
            return false;
        }
        //檢查電話是否一樣
        if($user->member->phone != $phone){
            return false;
        }
        $this->user = $user;
        return true;
    }

    /**
     * 重設密碼並寄出
     * 
     * @return array
     */
    public function resetPassword()
    {
        //產生亂碼
        $password = randomkeys(6);
        $msg = env('COMPANY_NAME').' 重設密碼簡訊，新密碼: '.$password;
        DB::beginTransaction();
        try{
            
            //更新密碼
            $this->user->update([
                'password' => bcrypt($password)
            ]);
            //寄出密碼
            $result =  $this->smsService->send($this->user->member->phone,$msg);
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        
        if($result['status']){
            DB::commit();
            return ['status' => true];
        } else {
            DB::rollBack();
            return ['status' => false, 'error'=> $result['error_code']];
        }
        

    }

    
  
}
