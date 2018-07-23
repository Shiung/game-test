<?php
namespace App\Services\System;

use App;
use App\Models\Sport\CnChessChip;
use App\Services\System\AdminActivityService;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;
use Log;

class CnChessChipService {
    
    protected $adminLog;
    protected $feature_name = '象棋籌碼設定';
    /**
     * 初始化
     *
     */
    public function __construct(
        AdminActivityService $adminLog
    ){
        $this->adminLog = $adminLog;
    }

    /**
     * 取得單一資料
     * @param int $id
     * @return Coleciton
     */
    public function find($id)
    {      
        return CnChessChip::find($id);
    }

    /**
     * 取得所有籌碼參數
     * @return Coleciton
     */
    public function all()
    {      
        return CnChessChip::all();
    }

    /**
     * 更新參數
     * @param array $data
     * @return array
     */
    public function update($data)
    {
        DB::beginTransaction();
        try{
            foreach ($data as $key => $chips) {
                $update_data = [];
                //新增log
                $this->adminLog->add([ 'content' =>  '更新象棋參數','type' => $this->feature_name]); 
                foreach ($chips as $chip_key => $chip) {
                    $update_data[$chip_key]['name'] = $chip['name']; 
                    $update_data[$chip_key]['amount'] = $chip['amount']; 
                }

                CnChessChip::find($key)->update([
                    'content' => json_encode($update_data)
                ]);

            }

        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }


}