<?php

namespace App\Http\Controllers\Admin\Member;

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
    protected $page_title = '社群';
    protected $menu_title = '社群';
    protected $route_code = 'tree';
    protected $view_data = [];

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
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];

    }


    /**
     * 社群結構樹頁面
     * @param int $id
     * @return view front/tree/index.blade.php
     */
    public function index($id)
    {
        $member = $this->memberService->find($id); 
        if(!$member){
            abort(404);
        }
        //取得左右區人數
        $tree = $this->treeService->createOneTree($id);

        $data = [
            'user_id' => $id,
            'root' => $tree['parent'],
            'children' => $tree['children'],
            'member' => $member,
        ];

        return view('admin.member.'.$this->route_code.'.index',array_merge($this->view_data,$data));  
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
