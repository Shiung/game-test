<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\UserService;
use App\Services\System\AdminService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Lang;

class AdminsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $userService;
    protected $adminService;
    protected $page_title = '管理員列表';
    protected $menu_title = '管理員列表';
    protected $route_code = 'admin';


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(UserService $userService, AdminService $adminService)
    {
        $this->userService = $userService;
        $this->adminService = $adminService;
    }

    

    /**
     * 管理員列表頁面
     *
     * @return view admin/admin/index.blade.php
     */
    public function index()
    {
    	$datas= $this->adminService->all();  
	    $data=[
            'datas' => $datas,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title
        ];  
	    return view('admin.'.$this->route_code.'.index',$data);
    }

    /**
     * 新增管理員畫面
     *
     * @return view admin/admin/create.blade.php
     */
    public function create()
    {
        $data=[
            'page_title' => $this->page_title,
            'route_code' => $this->route_code,
            'menu_title' => $this->menu_title
        ]; 
        return view('admin.'.$this->route_code.'.create',$data);
    }

    /**
     * 資料儲存處理
     *
     * @param  Request $request
     * @return json
     */
    public function store(Request $request)
    {

        //先檢查有沒有某帳號存在
        $user = $this->userService->getUserByUsername($request->username);
        if($user){
            return json_encode(array('result' => 0, 'text' => '此帳號已被使用')); 
        }

        $result = $this->adminService->add([
            'username' => $request->username,
            'name' => $request->name,
            'type' => $request->type,
            'password' => bcrypt($request->password),
        ]);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        } 
           
    }

    /**
     * 編輯管理員頁面
     *
     * @param  int $id
     * @return view admin/admin/edit.blade.php
     */
    public function edit($id)
    {
        $admin = $this->adminService->find($id);
        if(!$admin){
            abort(404);
        }

        $data=[
            'data' => $admin,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title
        ];
        return view('admin.'.$this->route_code.'.edit',$data);
    }

    /**
     * 資料更新處理
     *
     * @param  int $id
     * @param Request $request
     * @return json
     */
    public function update($id,Request $request)
    {  
        $admin = $this->adminService->find($id);
        if(!$admin){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }

        if ($request->target=='info') {
            $array=[
                'name' =>  $request->name, 
                'type' => $request->type,
            ];
            $result = $this->adminService->update($id,$array);

        } else {
            $array=[
                'password' =>  bcrypt($request->password), 
            ];
            $result = $this->adminService->update($id,$array,'pass');
        } 

        
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        } 

        
    }


    /**
     * 編輯管理員權限頁面
     *
     * @param  int $id
     * @return view admin/admin/permission_edit.blade.php
     */
    public function editPermission($id)
    {
        $admin = $this->adminService->find($id);
        if(!$admin){
            abort(404);
        }

        //取得開放權限
        $roles = $this->adminService->getRoles();
        

        //該管理員有的權限
        $userRoles = $admin->roles->toArray();     

        $data=[
            'data'=> $admin ,
            'roles' =>  $roles,
            'user_roles' => $userRoles,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title
        ];
        return view('admin.'.$this->route_code.'.permission_edit',$data);
    }

    /**
     * 更新權限
     *
     * @param  int $user_id
     * @param Request $request
     * @return json
     */
    public function updatePermission($user_id,Request $request)
    {
        $admin = $this->adminService->find($user_id);
        if(!$admin){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }

        $result = $this->adminService->updatePermission($user_id,$request->roles);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        } 

    }


    /**
     * 資料刪除處理
     *
     * @param int  $id
     * @return json
     */
    public function destroy($id)
    {
        $admin = $this->adminService->find($id);
        if(!$admin){
            return json_encode(array('result' => 0, 'text' => '資料不存在'));
        }    
        $result = $this->adminService->delete($id);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        } 
        
    }

  
}
