<?php
namespace App\Repositories\Content;

use Doctrine\Common\Collections\Collection;
use App\Models\Content\BoardMessage;

class BoardMessageRepository
{
    protected $message;
    /**
     * BoardMessageRepository constructor.
     *
     * @param BoardMessage $message
     */
    public function __construct(BoardMessage $message)
    {
        $this->message = $message;
    }

    /**
     * 依照日期區間回傳列表（給後台）
     * @param $$type,start,$end
     * @return Collection
     */
    public function all($start,$end)
    {
        return $this->message->with('member')
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

     /**
     * 列表分頁版（給前台）
     * @param $type,$page
     * @return Collection
     */
    public function allToPaginate($start,$end,$page)
    {
        if($start && $end){
            return $this->message->with('member')
                ->whereBetween('created_at', [$start,$end])
                ->orderBy('created_at','desc')
                ->paginate($page);
        } else {
            return $this->message->with('member')
                ->orderBy('created_at','desc')
                ->paginate($page);
        }
    }

    /**
     * 依照id回傳特定資料
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->message->find($id);
    }

    /**
     * 新增資料
     * @param $data
     * @return BOOL
     */
    public function add($data)
    {  
        return $this->message->insertGetId($data);
    }

    /**
     * 更新資料
     * @param id, $data
     * @return Collection
     */
    public function update($id,$data)
    {  
        $item = $this->message->find($id);
        if( $item->update($data) ) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 刪除資料
     * @param id
     * @return Collection
     */
    public function delete($id)
    {  
        return $this->message->find($id)->delete();
    }
    


}