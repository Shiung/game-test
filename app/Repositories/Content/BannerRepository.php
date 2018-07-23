<?php
namespace App\Repositories\Content;

use Doctrine\Common\Collections\Collection;
use App\Models\Content\Banner;

class BannerRepository
{
    protected $banner;
    /**
     * BannerRepository constructor.
     *
     * @param Banner $banner
     */
    public function __construct(Banner $banner)
    {
        $this->banner = $banner;
    }

    /**
     * 列表
     * @return Collection
     */
    public function all()
    {
        return $this->banner
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
        return $this->banner->find($id);
    }

    /**
     * 新增資料
     * @param $data
     * @return BOOL
     */
    public function add($data)
    {  
        return $this->banner->insertGetId($data);
    }

    /**
     * 更新資料
     * @param id, $data
     * @return Collection
     */
    public function update($id,$data)
    {  
        $item = $this->banner->find($id);
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
        return $this->banner->find($id)->delete();
    }
    


}