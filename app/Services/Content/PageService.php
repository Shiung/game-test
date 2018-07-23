<?php
namespace App\Services\Content;

use App;
use App\Repositories\Content\PageRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;

class PageService {
    
    protected $pageRepository;
    protected $adminLog;
    protected $feature_name = '頁面內容';
    /**
     * PageService constructor.
     *
     * @param AdminActivityService $adminLog
     * @param PageRepository $pageRepository
     */
    public function __construct(
        AdminActivityService $adminLog, 
        PageRepository $pageRepository
    ) {
        $this->adminLog = $adminLog;
        $this->pageRepository = $pageRepository;
    }

    /**
     *  依照類型取得所有訊息資料
     * @return collection 
     */
    public function all($status = '%')
    {
        return $this->pageRepository->all($status);
    }

    /**
     *  取得所有訊息資料並分頁(for 前台)
     * @param int $page
     * @return collection 
     */
    public function allToPaginate($page = 20)
    {
        return $this->pageRepository->allToPaginate($page);
    }
    
    /**
     *  依照code取得資料
     * @param string $code
     * @param int $status
     * @return collection 
     */
    public function getPageByCode($code,$status = 1)
    {
        return $this->pageRepository->getPageByCode($code,$status);
    }


    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->pageRepository->find($id);
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
            $this->pageRepository->update($id,$data);  
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
            //檢查code是否重複
            if($this->getPageByCode($data['code'],'%')){
                return ['status' => false, 'error'=> 'URL請勿重複'];
            }
            $id = $this->pageRepository->add($data);
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
            $this->pageRepository->delete($id);   
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
