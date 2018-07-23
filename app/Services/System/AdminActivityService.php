<?php
namespace App\Services\System;

use App;
use App\Repositories\System\AdminActivityRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;

class AdminActivityService {
    
    protected $adminActivityRepository;
    protected $admin;
    /**
     * 初始化
     * @param AdminActivityRepository $adminActivityRepository
     */
    public function __construct(AdminActivityRepository $adminActivityRepository){
        $this->adminActivityRepository = $adminActivityRepository;
        $this->admin = Auth::guard('admin')->user();
    }


    /**
     * 取得所有資料
     * @param $start,$end
     * @return Collection
     */
    public function all($start,$end)
    {
        return $this->adminActivityRepository->all($start,formatEndDate($end));
    }

    /**
     * 新增
     * @param $data
     * @return array
     */
    public function add($data)
    {
        DB::beginTransaction();
        try{
            $data['ip_address'] = request()->ip();
            if($this->admin){
                $data['admin_id'] = $this->admin->id;
                $this->adminActivityRepository->add($data);
            } else {
                if (array_key_exists("admin_id",$data)){
                    $this->adminActivityRepository->add($data);
                }
            }
            
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];

    }


}