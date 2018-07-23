<?php
namespace App\Repositories\System;

use Doctrine\Common\Collections\Collection;
use App\Models\System\MemberNewsReadRecord;

class MemberNewsReadRecordRepository
{
    protected $record;
    /**
     * MemberNewsReadRecordepository constructor.
     *
     * @param MemberNewsReadRecord $record
     */
    public function __construct(MemberNewsReadRecord $record)
    {
        $this->record = $record;
    }

    /**
     * 依照會員及最新消息回傳結果
     * @param $member_id,$news_id
     * @return Collection
     */
    public function getByMemberAndNews($member_id,$news_id)
    {
        return $this->record
                ->where('member_id',$member_id)
                ->where('news_id',$news_id)
                ->get();
    }

    /**
     * 新增資料
     * @param $data
     * @return BOOL
     */
    public function add($data)
    {  
        return $this->record->create($data);
    }

    /**
     * 刪除資料
     * @param id
     * @return Collection
     */
    public function delete($news_id)
    {  
        return $this->record->where('news_id',$news_id)->delete();
    }

}