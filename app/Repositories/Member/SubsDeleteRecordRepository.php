<?php
namespace App\Repositories\Member;

use Doctrine\Common\Collections\Collection;
use App\Models\SubsDeleteRecord;

class SubsDeleteRecordRepository
{

    protected $record;
    /**
     * SubsDeleteRecordRepository constructor.
     *
     * @param SubsDeleteRecord $record
     */
    public function __construct(SubsDeleteRecord $record)
    {
        $this->record = $record;
    }

    /**
     * 取得所有資料
     * @return collection
     */
    public function all($start,$end,$status,$member_id,$delete_member_id)
    {
        return $this->record
                    ->where('status','LIKE',$status)
                    ->where('member_id','LIKE',$member_id)
                    ->where('delete_member_id','LIKE',$delete_member_id)
                    ->whereBetween('created_at', [$start,$end])
                    ->get();
    }

    
    /**
     * 回傳特定內容
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->record->find($id);
    }

    /**
     * 新增
     * @param data
     * @return bool
     */
    public function add($data)
    {
        return $this->record->create($data);
    }


    /**
     * 更新資料
     * @param id, $data
     * @return Collection
     */
    public function update($id,$data)
    {  
        $item = $this->record->find($id);
        if( $item->update($data) ) {
            return true;
        } else {
            return false;
        }
    }


}