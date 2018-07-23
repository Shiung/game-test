<?php
namespace App\Services;

use App;
use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Services\System\UserErrorService;
use App\Services\System\UserLoginService;
use Exception;
use Auth;

class AuthService {
    
    protected $userRepository;
    protected $errorLog;
    protected $loginLog;
    /**
     * UserService constructor.
     * @param UesrRepository $userRepository
     * @param UserErrorService $errorLog
     * @param UserLoginService $loginLog
     */
    public function __construct(
        UserRepository $userRepository,
        UserErrorService $errorLog,
        UserLoginService $loginLog
    ) {
        $this->errorLog = $errorLog;
        $this->loginLog = $loginLog;
        $this->userRepository = $userRepository;
    }
   
    /**
     * 登入錯誤的處理
     * @param string $username
     * @return array
     */
    public function loginFailedProcess($username)
    {
        DB::beginTransaction();
        try{
            $login_error = [
                'type' => '登入',
                'content' => '登入錯誤'
            ];
            $user = User::where('username',$username)->first();
            if($user){
                if($user->type == 'member'){
                    //一般會員才會鎖
                    $count = $user->pwd_wrong_count;
                    $count = $count +1;
                    if($count >= 3){
                        $data = [
                            'pwd_wrong_count' => $count,
                            'login_permission' => 0
                        ];
                    } else {
                        $data = [
                            'pwd_wrong_count' => $count,
                        ];
                    }
                    $user->update($data);
                }
                
                $login_error['user_id'] = $user->id;

            }
            
            //新增登入錯誤log
            $this->errorLog->add($login_error);

        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }


    /**
     * 登入成功的處理
     * @param User $user
     * @return array
     */
    public function loginSuccessProcess(User $user)
    {
        DB::beginTransaction();
        try{
            $newSessionId = session()->getId();
            $user->update(['last_session_id' => $newSessionId, 'pwd_wrong_count' => 0]);
            $this->loginLog->add([
                'user_id' => $user->id
            ]);

        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }




    

    
    
  
}
