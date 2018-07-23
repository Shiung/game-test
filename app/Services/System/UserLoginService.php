<?php
namespace App\Services\System;

use App;
use App\Repositories\System\UserLoginRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;

class UserLoginService {
    
    protected $userLoginRepository;
    /**
     * 初始化
     * @param UserLoginRepository $userLoginRepository
     */
    public function __construct(UserLoginRepository $userLoginRepository){
        $this->userLoginRepository = $userLoginRepository;
    }


    /**
     * 取得所有資料
     * @param date $start
     * @param date $end
     * @return Collection
     */
    public function all($start,$end)
    {
        return $this->userLoginRepository->all($start,formatEndDate($end));
    }

    /**
     * 依照日期會員取得資料
     * @param int $user_id
     * @param date $start,
     * @param date $end
     * @return Collection
     */
    public function allByMember($user_id,$start,$end)
    {
        return $this->userLoginRepository->allByMember($user_id,$start,formatEndDate($end));
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
            $data['ip_address'] = request()->ip();
            $this->userLoginRepository->add($data);
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];

    }


}