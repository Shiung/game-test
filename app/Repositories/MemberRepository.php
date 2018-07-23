<?php
namespace App\Repositories;

use Doctrine\Common\Collections\Collection;
use App\Models\Member;

class MemberRepository
{

    protected $member;
    /**
     * MemberRepository constructor.
     *
     * @param Member $member
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * 取得所有會員資料
     * @return collection
     */
    public function all()
    {
        return $this->member->with('user')->get();
    }
    
    /**
     * 回傳特定內容
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->member->find($id);
    }

    /**
     * 更新資料
     * @param id, $data
     * @return Collection
     */
    public function update($id,$data)
    {  
        $item = $this->member->find($id);
        if( $item->update($data) ) {
            return true;
        } else {
            return false;
        }
    }


}