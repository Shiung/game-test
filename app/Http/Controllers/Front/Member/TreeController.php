<?php

namespace App\Http\Controllers\Front\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App;
use Session;
use App\Services\UserService;
use App\Services\Member\MemberService;
use App\Services\Member\TreeService;
use Validator;

class TreeController extends Controller
{

    /**
     * 參數設定
     *
     * @var string
     */
    protected $userService;
    protected $memberService;
    protected $treeService;
    protected $user;
    protected $page_title = '社群';
    protected $route_code = 'tree';

    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        UserService $userService,
        MemberService $memberService,
        TreeService $treeService
    ) {
        $this->userService = $userService;
        $this->memberService = $memberService;
        $this->treeService = $treeService;
        $this->user = Auth::guard('web')->user();

    }


    /**
     * 社群結構頁面
     *
     * @return view front/member/tree/index.blade.php
     */
    public function index()
    {
        //取得左右區人數
        $tree = $this->treeService->createOneTree($this->user->id);

        $data = [
         'user_id' => $this->user->id,
            'root' => $tree['parent'],
            'children' => $tree['children'],
            'member' => $this->user->member,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
        ];

        return view('front.member.'.$this->route_code.'.index',$data);  
    }

    /**
     * 取得社群結構樹（for 樹狀圖）
     * @param string $username
     * @return string
     */
    public function search($username)
    {
        //確定下線是否存在
        $user = $this->userService->getUserByUsername($username);
        if(!$user){
            return json_encode(['result' => 0,'text' => 'No user'] );
        } else {
            $tree = $this->treeService->createOneTree($user->id);
            return json_encode(['result' => 1,'tree' => $tree] );
        }
        
    }


}
