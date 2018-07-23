<?php
namespace App\Services\Member;

use App;
use App\Repositories\Member\MemberRepository;
use App\Services\System\AdminActivityService;
use App\Services\Shop\ProductService;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\MemberLevelRecord;
use Auth;
use Session;

class MemberService {
    
    protected $memberRepository;
    protected $productService;
    protected $adminLog;
    /**
     * MemberService constructor.
     * @param ProductService $productService
     * @param MemberRepository $memberRepository
     * @param AdminActivityService $adminLog
     */
    public function __construct(
        ProductService $productService,
        MemberRepository $memberRepository,
        AdminActivityService $adminLog
    ) {
        $this->adminLog = $adminLog;
        $this->memberRepository = $memberRepository;
        $this->productService = $productService;
    }

    /**
     * 取得會員列表
     * 
     * @return collection
     */
    public function all()
    {
        return $this->memberRepository->all();
    }

    /**
     * 取得單一會員
     * @param int $id
     * @return collection
     */
    public function find($id)
    {
        return $this->memberRepository->find($id);
    }


    /**
     * 更新
     * @param string $type
     * @param int $id
     * @param array $data
     * @param string $field
     * @return array
     */
    public function update($type = 'member',$id,$data,$field ='')
    {
        DB::beginTransaction();
        try{
            //如果要更新的欄位包含手機，檢查手機是否重複
            if (array_key_exists("phone",$data)){
                if($this->memberRepository->findByPhone($id,$data['phone'])){
                    return ['status' => false, 'error'=> '手機號碼重複'];
                }
            }
            //更新會員資料
            $this->memberRepository->update($id,$data);

            if($type == 'admin'){
                //如果是管理員更新的，要新增操作log
                $this->adminLog->add([ 'content' =>  '更新'.$field.'：'.$id ,'type' => '會員']); 
            }
            
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error'=> $e->getMessage()];
        }
        DB::commit();
        return ['status' => true];
    }

    /**
     * 取得直接下線列表
     * @param int $id
     * @param int $show_status
     * @return collection
     */
    public function getSubMembers($id,$show_status =1)
    {
        return $this->memberRepository->getSubMembers($id,$show_status);
    }

    /**
     * 取得樹第一代下線
     * @param int $id
     * @return collection
     */
    public function getTreeSubs($id)
    {
        return $this->memberRepository->getTreeSubs($id);
    }

    /**
     * 檢查手機是否是可使用的
     * @param string $phone
     * @param int $id
     * @return bool
     */
    public function checkIfPhoneCanUse($phone,$id = null)
    {
        $user =  $this->memberRepository->findByPhone($phone,$id);
        if(!$user){
            return true;
        } else {
            return false;
        }
    }

   

    /**
     * 查詢會員等級資訊
     * @param int $member_id
     * @param string user_type
     * @return array
     */
    public function searchMemberLevel($member_id,$user_type='member')
    {
        $result = $this->getLatestMemberLevel($member_id); 
        //會員資訊
        $level_expire = '無限期';
        $level = '無';
        $level_icon = '';
        if($user_type != 'admin_member'){
            if($result['result'] == 1){
                ($result['expire_date'])?($level_expire = $result['expire_date']):($level_expire = '無限期');
                $level = $result['name'];
                $level_icon = $result['icon'];
            } 
        }
        return ['level_name' => $level,'level_expire'=> $level_expire,'icon'=> $level_icon];
    }

    /**
     * 處理目前會員等級
     * @param int  $member_id
     * @return array
     */
    public function getLatestMemberLevel($member_id)
    {
        $levels = MemberLevelRecord::select(DB::raw('SUM(day_count) as days, member_id, member_level_id, MIN(member_level_records.created_at) as start_datetime, expired_status, interest,tree_name,icon'))
             ->where('member_id', $member_id)->where('expired_status',0)
             ->join('product_member_levels','member_level_id','=','product_member_levels.product_id')
             ->join('products','products.id','=','product_member_levels.product_id')
             ->groupBy('member_level_id')
             ->orderBy('interest','desc')
             ->get();
        foreach ($levels as $level) {

            if(!is_null($level->days)){
                $start_date = strtotime($level->start_datetime);
                $expire_time = strtotime('+'.$level->days.' days', $start_date);
                $now = strtotime("now");
                $less_second = $expire_time - $now;

                //沒過期 直接回傳會員等級結果
                if($less_second > 0) {
                    $expire_date = date("Y-m-d H:i:s",$expire_time);
                    return array('result'=>1, 'member_id'=>$member_id, 'member_level_id'=>$level->member_level_id, 'interest'=>$level->interest, 'expire_date'=>$expire_date,'name' => $level->tree_name,'icon'=> $level->icon);
                }

            } else if($level->member_id == $member_id) {
                return array('result'=>1, 'member_id'=>$member_id, 'member_level_id'=>$level->member_level_id, 'interest'=>$level->interest, 'expire_date'=>null,'name' => $level->tree_name,'icon'=> $level->icon);
            }

        }
      
      return array('result'=>0, 'error_code'=>'NULL_LEVEL', 'error_msg'=>'該會員目前沒有任何會員等級', 'detail'=>null);
    }

    /**
     * 檢查特定會員間是否為上下線關係
     * @param int $parent_id
     * @param int $sub_id
     * @return array
     */
    public function checkMemberInTree($parent_id,$sub_id)
    {
        DB::beginTransaction();
        try{
            $data['token'] = Session::get('m_token');
            $data['parent_id'] = $parent_id;
            $data['member_id'] = $sub_id;
            $result = curlApi(env('API_URL').'/user/check_member_inTree',$data); 
        } catch (Exception $e){
         DB::rollBack();
         return ['status' => false, 'error_code'=> 'EXCEPTION_ERROR','error_msg' => $e->getMessage()];
        }
        DB::commit();
        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true, 'in_tree' => $result['in_tree'], 'level' => $result['level']];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']];
        }
    }
    
  
}
