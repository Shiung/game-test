<?php
namespace App\Services\System;

use App;
use App\Repositories\System\UserErrorRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;

class UserErrorService {
    
    protected $userErrorRepository;
    protected $user;
    /**
     * 初始化
     * @param UserErrorRepository $userErrorRepository
     */
    public function __construct(UserErrorRepository $userErrorRepository){
        $this->userErrorRepository = $userErrorRepository;
        $this->user = Auth::guard('web')->user();
    }


    /**
     * 取得所有資料
     * @param date $start,
     * @param date $end
     * @return Collection
     */
    public function all($start,$end)
    {
        return $this->userErrorRepository->all($start,formatEndDate($end));
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
            if($this->user){
                $data['user_id'] = $this->user->id;      
            } 
            $data['ip_address'] = request()->ip();
            $this->userErrorRepository->add($data);
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];

    }


}