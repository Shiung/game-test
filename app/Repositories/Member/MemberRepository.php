<?php
namespace App\Repositories\Member;

use Doctrine\Common\Collections\Collection;
use App\Models\Member;
use App\Models\Tree;

class MemberRepository
{

    protected $member;
    protected $tree;
    /**
     * MemberRepository constructor.
     *
     * @param Member $member,Tree $tree
     */
    public function __construct(Member $member, Tree $tree)
    {
        $this->member = $member;
        $this->tree = $tree;
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
     * 依照手機查詢會員
     * @param phone
     * @return Collection
     */
    public function findByPhone($phone,$user_id = null)
    {
        if($user_id){
            return $this->member->where('phone',$phone)->where('user_id','<>',$user_id)->first();
        } else {
            return $this->member->where('phone',$phone)->first();
        }
        
    }

    /**
     * 取得直接下線列表
     * @param phone
     * @return Collection
     */
    public function getSubMembers($id,$show_status)
    {
        return $this->member->where('recommender_id',$id)->where('show_status','LIKE',$show_status)->get();
    }

    /**
     * 取得樹下線
     * @param id
     * @return Collection
     */
    public function getTreeSubs($id)
    {
        return $this->tree
                ->join('members AS m', 'm.user_id', '=', 'trees.parent_id')
                ->join('users AS u', 'm.user_id', '=', 'u.id')
                ->where('trees.parent_id',$id)
                ->orderBy('position','asc')
                ->select('m.user_id', 'trees.position', 'trees.position','u.username','m.member_number','m.name')
                ->get();
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