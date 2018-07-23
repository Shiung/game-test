<?php
namespace App\Services\Content;

use App;
use App\Repositories\Content\MarqueeRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;

class MarqueeService {
    
    protected $marqueeRepository;
    protected $adminLog;
    protected $feature_name = '跑馬燈';
    /**
     * MarqueeService constructor.
     *
     * @param AdminActivityService $log
     * @param MarqueeRepository $marqueeRepository
     */
    public function __construct(
        AdminActivityService $adminLog,
        MarqueeRepository $marqueeRepository
    ) {
        $this->adminLog = $adminLog;
        $this->marqueeRepository = $marqueeRepository;
    }

    /**
     *  取得所有資料
     * @return collection 
     */
    public function all()
    {
        return $this->marqueeRepository->all();
    }
    

    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->marqueeRepository->find($id);
    }

    /**
     * 更新
     * @param int $id, 
     * @param array $data
     * @return array
     */
    public function update($id,$data)
    {
        DB::beginTransaction();
        try{
            $this->marqueeRepository->update($id,$data);   
            //新增log
            $this->adminLog->add([ 'content' =>  '更新：'.$id ,'type' => $this->feature_name]); 
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
            $id = $this->marqueeRepository->add($data);   
            //新增log
            $this->adminLog->add([ 'content' =>  '新增：'.$id ,'type' => $this->feature_name]); 
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
            $this->marqueeRepository->delete($id);  
            //新增log
            $this->adminLog->add([ 'content' =>  '刪除：'.$id ,'type' => $this->feature_name]); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }
    
    
  
}
