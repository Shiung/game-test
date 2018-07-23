<?php
namespace App\Services\Content;

use App;
use App\Repositories\Content\NewsRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;

class NewsService {
    
    protected $newsRepository;
    protected $adminLog;
    protected $feature_name = '公告';
    /**
     * NewsService constructor.
     *
     * @param AdminActivityService $adminLog
     * @param NewsRepository $newsRepository
     */
    public function __construct(
        AdminActivityService $adminLog, 
        NewsRepository $newsRepository
    ) {
        $this->adminLog = $adminLog;
        $this->newsRepository = $newsRepository;
    }

    /**
     *  依照類型取得所有訊息資料
     * @param string $type
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function all($type ='news',$start,$end)
    {
        return $this->newsRepository->all($type,$start,formatEndDate($end));
    }
    
    /**
     *  取得所有訊息資料並分頁(for 前台)
     * @param string $type
     * @param int $page
     * @return collection 
     */
    public function allToPaginate($type ='news',$page = 20)
    {
        return $this->newsRepository->allToPaginate($type,$page);
    }


    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->newsRepository->find($id);
    }

    /**
     * 取得系統彈跳公告
     * 
     * @return collection
     */
    public function findSystemAlert()
    {
        return $this->newsRepository->find(1);
    }

    /**
     * 更新系統彈跳
     * @param array $data
     * @return array
     */
    public function updateSystemAlert($data)
    {
        DB::beginTransaction();
        try{
            $alert = $this->findSystemAlert();
            $this->newsRepository->update($alert->id,$data);  
            //新增log
            $this->adminLog->add([ 'content' =>  '更新' ,'type' => '系統彈跳公告']); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }

    /**
     * 更新
     * @param int  $id, 
     * @param array $data
     * @return array
     */
    public function update($id,$data)
    {
        DB::beginTransaction();
        try{
            $this->newsRepository->update($id,$data);  
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
     * 新增訊息
     * @param array $data
     * @return array
     */
    public function add($data)
    {   
        DB::beginTransaction();
        try{
            $id = $this->newsRepository->add($data);
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
            $this->newsRepository->delete($id);   
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
