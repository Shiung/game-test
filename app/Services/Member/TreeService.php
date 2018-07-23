<?php
namespace App\Services\Member;

use App;
use App\Services\Member\MemberService;
use App\Services\Member\TreeStructureService;
use App\Services\System\ParameterService;
use Illuminate\Support\Facades\DB;
use Exception;

class TreeService {
    
    protected $memberService;
    protected $parameterService;
    protected $treeStructureService;
    /**
     * TreeService constructor.
     *
     * @param MemberService $memberService
     * @param TreeStructureService $treeStructureService
     * @param ParameterService $parameterService
     */
    public function __construct(
        MemberService $memberService,
        TreeStructureService $treeStructureService,
        ParameterService $parameterService
    ) {
        $this->memberService = $memberService;
        $this->parameterService = $parameterService;
        $this->treeStructureService = $treeStructureService;
    }

    /**
     * 建立一層樹
     * @param int $user_id
     * @return array
     */
    public function createOneTree($user_id){
        $tree_arr = [];
        $children_arr = [];
        $member = $this->memberService->find($user_id);

        $tree_count = $this->parameterService->find('tree_parent');
        $tree_subs_total_show = $this->parameterService->find('tree_subs_total_show');

        $this->treeStructureService->createtree($user_id,$tree_subs_total_show); //參數一為會員id, 參數二為查詢幾代
        $sub_count = $this->treeStructureService->treecount; //$tree_count為下線人數
        
        //基本資訊
        $user = $member->user;
        $tree_arr['parent']["status"]=0;
        $tree_arr['parent']["name"] = $member->name;
        $tree_arr['parent']["user_id"] = $member->user_id;
        $tree_arr['parent']["username"] = $user->username;
        $tree_arr['parent']["member_number"] = $member->member_number;
        $tree_arr['parent']["subs_count"] = $sub_count;
        $tree_arr['parent']["tree_level_name"] = $this->getLevel($user);

        //處理左右下線
        $subs = $member->tree_subs;
        for($i=1;$i<=$tree_count;$i++){
            $sub = $subs->where('position',$i)->first();
            $sub_data =  [
                'id' => $user_id.'-'.$i,
                'parent_id' => $user_id,
            ];
            if(!$sub){
                $sub_data['status'] = 1;
            } else {
                $sub_member = $this->memberService->find($sub->member_id);
                $sub_user = $sub_member->user;
                $this->treeStructureService->createtree($sub->member_id,$tree_subs_total_show); //參數一為會員id, 參數二為查詢幾代
                $sub_count = $this->treeStructureService->treecount; //$tree_count為下線人數

                $sub_data['status'] = 0;
                $sub_data["name"]= $sub_member->name;
                $sub_data["username"]= $sub_user->username;
                $sub_data["user_id"]= $sub->member_id;
                $sub_data["member_number"]= $sub_member->member_number;
                $sub_data["subs_count"]= $sub_count;
                $sub_data["tree_level_name"]= $this->getLevel($sub_user);
            }
            array_push($children_arr,$sub_data);
        }
        
        $tree_arr['children'] = $children_arr;
        return $tree_arr;

    }

    /**
     * 取得樹級別名稱
     * @param User $user
     * @return string
     */
    public function getLevel($user){
        $level = '無';
        if($user->type != 'admin_member'){
            $result = $this->memberService->searchMemberLevel($user->id);
            $level = $result['level_name']; 
        }
        return $level;

    }
    
   

    
    
  
}
