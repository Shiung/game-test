<?php
namespace App\Services\System;

use App;
use App\Models\Role;
use App\Repositories\AdminRepository;
use App\Repositories\UserRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;

class AdminService {
    
    protected $adminRepository;
    protected $userRepository;
    protected $adminLog;
    protected $feature_name = '管理員列表';
    /**
     * AdminService constructor.
     *
     * @param AdminActivityService $adminLog
     * @param AdminRepository $adminRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        AdminActivityService $adminLog, 
        AdminRepository $adminRepository,
        UserRepository $userRepository
    ) {
        $this->adminLog = $adminLog;
        $this->adminRepository = $adminRepository;
        $this->userRepository = $userRepository;
    }

    /**
     *  取得所有訊息資料
     * @return collection 
     */
    public function all()
    {
        return $this->adminRepository->all();
    }
    

    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->adminRepository->find($id);
    }



    /**
     * 更新
     * @param int $id, 
     * @param array $data, 
     * @param array $info
     * @return array
     */
    public function update($id,$data,$type = 'info')
    {
        DB::beginTransaction();
        try{
            $this->adminRepository->update($id,$data); 
             
            if($type == 'info') {
                //如果是最高管理員
                if($data['type'] == 0){
                    $this->updateMasterAdminPermission($id,'add');
                } else {
                    $this->updateMasterAdminPermission($id,'remove');
                }
            }
            
            //新增log
            $this->adminLog->add([ 'content' =>  '更新：#'.$id ,'type' => $this->feature_name]); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }

    /**
     * 新增
     * @param array $data
     * @return array
     */
    public function add($data)
    {   
        DB::beginTransaction();
        try{
            $user_id = $this->userRepository->add([
                'username' => $data['username'],
                'type' => 'admin',
                'password' => $data['password'],
            ]);
            $this->adminRepository->add([
                'id' => $user_id,
                'name' => $data['name'],
                'username' => $data['username'],
                'password' => $data['password'],
                'type' => $data['type']
            ]);

            //如果是最高管理員
            if($data['type'] == 0){
                $this->updateMasterAdminPermission($user_id,'add');
            }
            //新增log
            $this->adminLog->add([ 'content' =>  '新增：#'.$user_id ,'type' => $this->feature_name]); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
        
    }
    
    /**
     * 刪除
     * @param int $id
     * @return array
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try{
            $this->adminRepository->delete($id);   
            $this->userRepository->delete($id);   
            //新增log
            $this->adminLog->add([ 'content' =>  '刪除：#'.$id ,'type' => $this->feature_name]); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }

    /**
     * 新增/取消最高管理員權限
     * @param int $user_id,
     * @param string $type
     * @return array
     */
    public function updateMasterAdminPermission($user_id,$type)
    {
        DB::beginTransaction();
        try{
            $user = $this->find($user_id);
            $role = Role::find(2);
            if($type == 'add'){
                if(!$user->hasRole('master-admin')){
                    $user->attachRole($role);
                }

            } else {
                $user->detachRole($role);
            }
        
            //新增log
           // $this->adminLog->add([ 'content' =>  '調整最高管理員權限：#'.$user_id ,'type' => $this->feature_name]);  
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }

    /**
     * 更新權限
     * @param int $user_id
     * @param array $roles
     * @return array
     */
    public function updatePermission($user_id,$roles)
    {
        DB::beginTransaction();
        try{
            $user = $this->find($user_id);

            //先刪除該管理員所有權限
            $user_roles = $user->roles;
            foreach ($user_roles as $user_role ) {
                $user->detachRole($user_role);
            }

            //新增新設定的權限
            if(count($roles)>0) {
                foreach ($roles as $role_id) {
                    $role = Role::find($role_id);
                    $user->attachRole($role);
                }
            }
        
            //新增log
            $this->adminLog->add([ 'content' =>  '更動權限：#'.$user_id ,'type' => $this->feature_name]); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }
    
    /**
     * 取得開放權限
     * 
     * @return collection
     */
    public function getRoles()
    {   
        return  [

            '遊戲' => [
                Role::where('name','sport-preview')->first(),
                Role::where('name','sport-write')->first(),
            ],

            '商城' => [

                Role::where('name','product-preview')->first(),
                Role::where('name','product-write')->first(),

                Role::where('name','share-transaction-preview')->first(),
                Role::where('name','transaction-preview')->first(),
                Role::where('name','product-use-record-preview')->first(),
                Role::where('name','give-product-preview')->first(),
                Role::where('name','give-product-write')->first(),
            ],
            '會員' => [
                Role::where('name','member-preview')->first(),
                Role::where('name','member-write')->first(),
                Role::where('name','member-account-preview')->first(),
                Role::where('name','member-betrecord-preview')->first(),
                Role::where('name','organization-betrecord-preview')->first(),


                Role::where('name','transfer-ownership-record-preview')->first(),
                Role::where('name','transfer-ownership-record-write')->first(),

                Role::where('name','subs-delete-record-preview')->first(),
                Role::where('name','subs-delete-record-write')->first(),
            ],
            '統計報表' => [
                Role::where('name','statistic-preview')->first(),
            ],

            '系統' => [
                Role::where('name','banner-preview')->first(),
                Role::where('name','banner-write')->first(),
                Role::where('name','news-preview')->first(),
                Role::where('name','news-write')->first(),
                Role::where('name','marquee-preview')->first(),
                Role::where('name','marquee-write')->first(),
                Role::where('name','page-preview')->first(),
                Role::where('name','page-write')->first(),
                Role::where('name','board-message-preview')->first(),
                Role::where('name','board-message-write')->first(),
                
                Role::where('name','company-transfer-preview')->first(),
                Role::where('name','company-transfer-write')->first(),

                
                Role::where('name','parameter-preview')->first(),
                Role::where('name','parameter-write')->first(),

                Role::where('name','admin-activity-preview')->first(),
                Role::where('name','login-record-preview')->first(),
                Role::where('name','schedule-record-preview')->first(),
            ],
            '其他'=> [
                Role::where('name','charge-preview')->first(),
                Role::where('name','charge-write')->first(),
                Role::where('name','withdrawal-preview')->first(),
                Role::where('name','withdrawal-write')->first(),
                Role::where('name','share-preview')->first(),
                Role::where('name','share-write')->first(),
            ]
  
        ];
        
    }
  
}
