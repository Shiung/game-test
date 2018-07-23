<?php
namespace App\Repositories\Shop;

use Doctrine\Common\Collections\Collection;
use App\Models\Shop\Charge;

class ChargeRepository
{
    protected $charge;
    /**
     * ChargeRepository constructor.
     *
     * @param Charge $charge
     */
    public function __construct(Charge $charge)
    {
        $this->charge = $charge;
    }


    /**
     * 依照日期區間回傳列表（給後台）
     * @param $start,$end
     * @return Collection
     */
    public function all($start,$end)
    {
        return $this->charge
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 
     * @param $member_id,$start,$end
     * @return Collection
     */
    public function allByMember($member_id,$start,$end)
    {
        return $this->charge
                ->where('member_id',$member_id)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 新增資料
     * @param $data
     * @return BOOL
     */
    public function add($data)
    {  
        return $this->charge->insertGetId($data);
    }

    /**
     * 依照id回傳特定資料
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->charge->find($id);
    }

    /**
     * 更新資料
     * @param id, $data
     * @return bool
     */
    public function update($id,$data)
    {  
        $item = $this->charge->find($id);
        if( $item->update($data) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 刪除資料
     * @param id
     * @return bool
     */
    public function delete($id)
    {  
        return $this->charge->find($id)->delete();
    }




}