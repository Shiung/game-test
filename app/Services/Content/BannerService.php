<?php
namespace App\Services\Content;

use App;
use App\Repositories\Content\BannerRepository;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;

class BannerService {
    
    protected $bannerRepository;
    protected $adminLog;
    protected $feature_name = 'BANNER';
    /**
     * BannerService constructor.
     *
     * @param AdminActivityService $log
     * @param BannerRepository $bannerRepository
     */
    public function __construct(
        AdminActivityService $adminLog,
        BannerRepository $bannerRepository
    ) {
        $this->adminLog = $adminLog;
        $this->bannerRepository = $bannerRepository;
    }

    /**
     *  取得所有資料
     * @return collection 
     */
    public function all()
    {
        return $this->bannerRepository->all();
    }
    

    /**
     * 依照id查詢資料
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->bannerRepository->find($id);
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update($id,$data)
    {
        DB::beginTransaction();
        try{
            $this->bannerRepository->update($id,$data);   
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
            $id = $this->bannerRepository->add($data);   
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
            $this->bannerRepository->delete($id);  
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
