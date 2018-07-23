<?php
namespace App\Services\Member;

use App\Models\Tree;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class TreeStructureService {

    public $treelist = array();
    public $parentlist = array();
    public $treecount = 0;
    public $first_R = 0;
    public $first_L = 0;
    public $first_position = '';
    public $first_member = 0;
    public $treeindex=0;

    //產生tree
    function createtree($member, $end_level=null, $parent=NULL, $level=1){
        if(is_null($parent)){
            $this->treelist = array();
            $this->treeindex = 0;
            $this->treecount = 0;
        }

        //超過幾代 結束
        if(!is_null($end_level) && $level > $end_level)
            return 1;

        //find $member's children
        $datas = Tree::where('parent_id','=',$member)->get();
        foreach ($datas as $children){

            //store member and parent
            $this->treelist["member"][$this->treeindex]=$children->member_id;
            $this->treelist["parent"][$this->treeindex]=$children->parent_id;
            $this->treelist["level"][$this->treeindex]=$level;
            $this->treecount++;

            //找下一個
            $this->treeindex++;
            $newlevel = $level+1;
            $this->createtree($children->member_id, $end_level, $member, $newlevel);
        }
    } 

    //安置
    function insertnode($member,$parent,$node){
        if($node%2==0)
            $data = array("member_id"=>$member,"parent_id"=>$parent,"position"=>"R");
        else 
            $data = array("member_id"=>$member,"parent_id"=>$parent,"position"=>"L");
        
        $result = Tree::create($data);
        if(!$result)
            throw new Exception ("error");
        else
            return $r=array("result" => 1);
    }


    
    //呼叫createparent前 tree->parentlist需要初始化
    function createparent($member,$level=1){
        
        $data = Tree::findOrFail($member);       

        $newlevel = $level+1;
        if(!is_null($data->parent_id)){
            $this->parentlist[$level]=$data->parent_id;
            $this->createparent($data->parent_id,$newlevel);
        }                 
    }
    
    //找到所有推薦人
    function find_recommenders($member_id){
        $recommenders = Member::where('recommender_id',$member_id)->get();
        $recommender_ids = $recommenders->pluck('user_id');

        return $recommender_ids;
    }

  
    //edit@2016-12-07
    function checkTree($member,$parent)
    {
        $return = array();
        $this->parentlist = array();
        $this->createparent($member);
        $level = array_search($parent, $this->parentlist);
        if ($level == false) {
            $return["result"]=0;
        } else {
            $return["result"]=1;
            $return["level"]=$level;
            if ($level==1)
                $member_position = $member;
            else
                $member_position = $this->parentlist[$level-1];
            $tree = Tree::where("member_id","=",$member_position)->firstOrFail();
            $return["position"]=$tree->position;
        }
        $return["tree"]=$this->parentlist;
        return $return;
    }



    
    
}
