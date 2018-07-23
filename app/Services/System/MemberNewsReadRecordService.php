<?php
namespace App\Services\System;

use App;
use App\Repositories\System\MemberNewsReadRecordRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;

class MemberNewsReadRecordService {
    
    protected $recordRepository;
    /**
     * 初始化
     * @param MemberNewsReadRecordRepository $recordRepository
     */
    public function __construct(MemberNewsReadRecordRepository $recordRepository){
        $this->recordRepository = $recordRepository;
    }


    /**
     * 檢查是否已讀
     * @param int $member_id,
     * @param int $news_id
     * @return bool
     */
    public function checkIfNewsRead($member_id,$news_id)
    {
        $record =  $this->recordRepository->getByMemberAndNews($member_id,$news_id);
        if(count($record) == 0 ){
            //新增已讀
            $this->add([
                'member_id' => $member_id,
                'news_id' => $news_id
            ]);
            return false;
        }
        return true;
    }

    /**
     * 新增
     * @param array  $data
     * @return bool
     */
    public function add($data)
    {
        return $this->recordRepository->add($data);
    }

    /**
     * 刪除
     * @param int $news_id
     * @return bool
     */
    public function delete($news_id)
    {
        return $this->recordRepository->delete($news_id);
    }



}