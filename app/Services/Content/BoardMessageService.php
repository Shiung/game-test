<?php
namespace App\Services\Content;

use App;
use App\Repositories\Content\BoardMessageRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;

class BoardMessageService {
    
    protected $messageRepository;
    protected $adminLog;
    protected $feature_name = '留言板';
    /**
     * BoardMessageService constructor.
     *
     * @param AdminActivityService $adminLog
     * @param BoardMessageRepository $messageRepository
     */
    public function __construct(
        AdminActivityService $adminLog, 
        BoardMessageRepository $messageRepository
    ) {
        $this->adminLog = $adminLog;
        $this->messageRepository = $messageRepository;
    }

    /**
     *  依照類型取得所有訊息資料
     * @param date $start
     * @param date $end
     * @return collection 
     */
    public function all($start,$end)
    {
        return $this->messageRepository->all($start,formatEndDate($end));
    }
    
    /**
     *  取得所有訊息資料並分頁(for 前台)
     * @param date $start
     * @param date $end
     * @param int $page
     * @return collection 
     */
    public function allToPaginate($start,$end,$page = 20)
    {
        return $this->messageRepository->allToPaginate($start,formatEndDate($end),$page);
    }


    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->messageRepository->find($id);
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
            $this->messageRepository->update($id,$data);  
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
            $id = $this->messageRepository->add($data);
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
     * @param string $role
     * @return array
     */
    public function delete($id,$role = 'member')
    {
        DB::beginTransaction();
        try{
            $this->messageRepository->delete($id); 

            if($role == 'admin'){
                //新增log
                $this->adminLog->add([ 'content' =>  '刪除：#'.$id ,'type' => $this->feature_name]); 
            }  
            
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }
    
    
  
}
