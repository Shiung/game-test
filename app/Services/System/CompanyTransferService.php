<?php
namespace App\Services\System;

use App;
use App\Repositories\Account\TransferRepository;
use App\Services\System\AdminActivityService;
use App\Services\Account\TransferRecordService;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;

class CompanyTransferService extends TransferRecordService{
    
    protected $transferRepository;

    /**
     * CompanyTransfersService constructor.
     *
     * @param AdminActivityService $adminLog
     * @param TransferRepository $transferRepository
     */
    public function __construct(
        AdminActivityService $adminLog, 
        TransferRepository $transferRepository
    ) {
         parent::__construct($adminLog,$transferRepository);
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
            $data['token'] = Session::get('a_token');
            $result = curlApi(env('API_URL').'/account/transfer_cash_company',$data); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']];
        }
    }

   
    

}
