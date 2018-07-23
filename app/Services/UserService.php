<?php
namespace App\Services;

use App;
use App\Repositories\UserRepository;
use App\Models\User;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;

class UserService {
    
    protected $userRepository;
    protected $adminLog;
    /**
     * UserService constructor.
     *
     * @param AdminActivityService $adminLog
     * @param UesrRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository,
        AdminActivityService $adminLog
    ) {
        $this->adminLog = $adminLog;
        $this->userRepository = $userRepository;
    }
    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * 依照username查詢資料
     * @param string $username
     * @param string $type
     * @return collection
     */
    public function getUserByUsername($username,$type = 'general')
    {
        if($type == 'general'){
            return $this->userRepository->getUserByUsername($username);  
        } else {
            return $this->userRepository->getUserByFuzzyUsername($username);
        }
        
    }

    /**
     * 更新
     * @param string $type,
     * @param int $id,
     * @param array $data
     * @param string $field
     * @return collection
     */
    public function update($type = 'member',$id,$data,$field ='')
    {
        DB::beginTransaction();
        try{
            $this->userRepository->update($id,$data);
            
            if($type == 'admin'){
                //如果是管理員更新的，要新增操作log
                $this->adminLog->add([ 'content' =>  '更新會員資料 '.$field ,'id' => $id]);   
            }
            
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }

    /**
     * 更新密碼
     * @param string $type
     * @param User $user
     * @param string $password
     * @return collection
     */
    public function updatePassword($type = 'member',User $user,$password)
    {
        DB::beginTransaction();
        try{
            $date = date('Y-m-d H:i:s');
            if($type == 'member'){
                //會員身份要更新重設密碼狀態
                if($user->reset_pwd_status == 0){
                    $m_data['reset_pwd_status'] = 1;
                    $m_data['reset_pwd_at'] = $date;
                    $user->member->update($m_data);
                }
            } else {
                //管理員身份要新增操作log
                $this->adminLog->add([ 'content' =>  '重設會員密碼' ,'id' => $user->id]); 
            }
            $data['password'] = bcrypt($password);
            $user->update($data);
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }

    
  
}
