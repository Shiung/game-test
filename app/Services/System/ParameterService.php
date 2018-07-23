<?php
namespace App\Services\System;

use App;
use App\Repositories\System\ParameterRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;

class ParameterService {
    
    protected $parameterRepository;
    protected $adminLog;
    protected $feature_name = '參數設定';
    /**
     * 初始化
     * @param ParameterRepository $parameterRepository
     * @param AdminActivityService $adminLog
     */
    public function __construct(
        ParameterRepository $parameterRepository,
        AdminActivityService $adminLog
    ){
        $this->parameterRepository = $parameterRepository;
        $this->adminLog = $adminLog;
    }

    /**
     * 取得參數
     * @param string $name
     * @param string $type
     * @return string/Parameter
     */
    public function find($name,$type = 'name')
    {
        if($type == 'name'){
            //直接回傳值
            return $this->parameterRepository->findValueByName($name);
        } else {
            //回傳物件
            return $this->parameterRepository->find($name);
        }
        
    }

    /**
     * 更新參數
     * @param array  $data
     * @return array
     */
    public function update($data)
    {
        DB::beginTransaction();
        try{
            foreach ($data as $key => $value) {
                $origin_param = $this->find($key,'parameter');
                if($origin_param->value != $value){
                    //新增log
                    $this->adminLog->add([ 'content' =>  '更新：'.$key. ' 「'.$origin_param->value.'」-->「'.$value.'」' ,'type' => $this->feature_name]); 
                    $this->parameterRepository->update($key, $value);
                    $this->parameterRepository->addChangeRecord([
                        'parameter_id' => $origin_param->id,
                        'admin_id' => Auth::guard('admin')->user()->id,
                        'old_value' => $origin_param->value,
                        'new_value' => $value
                    ]);
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