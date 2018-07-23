<?php
namespace App\Repositories\Content;

use Doctrine\Common\Collections\Collection;
use App\Models\Content\Marquee;

class MarqueeRepository
{
    protected $marquee;
    /**
     * MarqueeRepository constructor.
     *
     * @param Marquee $marquee
     */
    public function __construct(Marquee $marquee)
    {
        $this->marquee = $marquee;
    }

    /**
     * 列表
     * @return Collection
     */
    public function all()
    {
        return $this->marquee
                ->orderBy('sort_order','asc')
                ->get();
    }

    /**
     * 依照id回傳特定資料
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->marquee->find($id);
    }

    /**
     * 新增資料
     * @param $data
     * @return BOOL
     */
    public function add($data)
    {  
        return $this->marquee->insertGetId($data);
    }

    /**
     * 更新資料
     * @param id, $data
     * @return Collection
     */
    public function update($id,$data)
    {  
        $item = $this->marquee->find($id);
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
        return $this->marquee->find($id)->delete();
    }
    


}