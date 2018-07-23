<?php
namespace App\Repositories;

use Doctrine\Common\Collections\Collection;
use App\Models\User;

class UserRepository
{
    protected $user;
    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * 回傳特定內容
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->user->find($id);
    }

    /**
     * 取得所有會員資料
     * @return collection
     */
    public function all()
    {
        return $this->user->where('type','<>','admin')->get();
    }

    /**
     * 依照帳號回傳特定內容
     * @param username
     * @return Collection
     */
    public function getUserByUsername($username)
    {
        return $this->user->where('username',$username)->where('type','<>','admin')->first();
    }

    /**
     * 依照帳號回傳特定內容(模糊搜尋)
     * @param username
     * @return Collection
     */
    public function getUserByFuzzyUsername($username)
    {
        return $this->user->where('username','LIKE','%'.$username.'%')->where('type','<>','admin')->get();
    }

    /**
     * 更新資料
     * @param id, $data
     * @return Collection
     */
    public function update($id,$data)
    {  
        $item = $this->user->find($id);
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
        return $this->user->insertGetId($data);
    }

    /**
     * 刪除資料
     * @param $id
     */
    public function delete($id)
    {  
        return $this->user->find($id)->delete();
    }

}