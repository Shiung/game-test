<?php
namespace App\Presenters;

use App\Services\Member\MemberService;
use Auth;

class MemberPresenter
{

    protected $memberService;
    protected $user;

    /**
     * BetPresenter constructor.
     *
     * @param 
     */
    public function __construct(
        MemberService $memberService
    ) {
        $this->memberService = $memberService;
        $this->user = Auth::guard('web')->user();
    }


    /**
     * 顯示會員等級
     * @return string
     */
    public function showMemberLevel()
    {
        $level_expire = '無限期';
        $level = '無';
        if($this->user->type != 'admin_member'){
            $result = $this->memberService->getMemberLevel('member',$this->user->id);
            if($result['status']){
                ($result['expire'])?($level_expire = $result['expire']):($level_expire = '無限期');
                $level = $result['level']->name;
            } 
        }

        return '等級：'.$level.'(到期日：'.date("Y-m-d", strtotime($level_expire) ).')';
       
    }


   
}