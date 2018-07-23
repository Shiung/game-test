<?php
namespace App\Repositories;

use Doctrine\Common\Collections\Collection;
use App\Models\Admin;

class AdminRepository
{
    protected $admin;
    /**
     * AdminRepository constructor.
     *
     * @param Admin $admin
     */
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }
    /**
     * 回傳特定內容
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->admin->find($id);
    }

    /**
     * 回傳所有項目
     * @return Collection
     */
    public function all()
    {
        return $this->admin->get();
    }

    /**
     * 更新資料
     * @param id, $data
     * @return Collection
     */
    public function update($id,$data)
    {  
        $item = $this->admin->find($id);
        if( $item->update($data) ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 新增資料
     * @param $data
     * @return BOOL
     */
    public function add($data)
    {  
        return $this->admin->create($data);
    }

    /**
     * 刪除資料
     * @param $id
     * @return BOOL
     */
    public function delete($id)
    {  
        return $this->admin->find($id)->delete();
    }


}