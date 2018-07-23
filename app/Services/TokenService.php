<?php
namespace App\Services;

use App;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;
use Session;

class TokenService {
    
    /**
     * TokenService constructor.
     *
     * 
     */
    public function __construct(

    ) {

    }

    /**
     * 設置token
     * @param User $user
     * @param string $current_token
     */
    public function setToken(User $user,$current_token = 'no')
    {
        if($current_token == 'no' || $current_token == '' || $current_token == ' '){
            $result = $this->getAuthToken($user->username,$user->password);
        } else {
            //舊token換新token
            $result = $this->refreshToken($current_token);
            $c_result = json_decode($result, true);
            if($c_result['result'] != 1){
                $result = $this->getAuthToken($user->username,$user->password);
            }
        }
        //json decode
        $json_result = json_decode($result, true);
        if($user->type == 'admin'){
            Session::put('a_token',$json_result['token']);
        } else {
            Session::put('m_token',$json_result['token']);
        }
        Session::save();
    }
   
    /**
     * 用帳號密碼取得token 
     * @param string $username
     * @param string $password
     * @return string
     */
    public function getAuthToken($username,$password)
    {
        return curlApi(env('API_URL')."/api/login",array( "username"=>$username,"password" => $password)); 
    }

    /**
     * 舊token換新token
     * @param string $token
     * @return string
     */
    public function refreshToken($token)
    {
        return curlApi(env('API_URL')."/api/refresh",array( "token"=> $token)); 

    }

    /**
     * 註銷token
     * @param string $token
     * @return string
     */
    public function invalidateToken($token)
    {
        return curlApi(env('API_URL')."/api/invalidate",array( "token"=> $token)); 

    }
  
}
