<?php
namespace App\Presenters\Game;

use App\Services\Member\BetRecordService;

class BetPresenter
{

    protected $betRecordService;

    /**
     * BetPresenter constructor.
     *
     * @param 
     */
    public function __construct(
        BetRecordService $betRecordService
    ) {
        $this->betRecordService = $betRecordService;
    }


    /**
     * 顯示下注內容
     *
     * @param int $bet_type
     * @param int $bet_record_id
     * @return string
     */
    public function showBetSummary($bet_type,$bet_record_id)
    {
        return $this->betRecordService->showSummary($bet_type,$bet_record_id);
       
    }


   
}