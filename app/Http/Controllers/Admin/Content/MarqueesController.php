<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Content\MarqueeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class MarqueesController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $marqueeService;
    protected $page_title = '跑馬燈管理';
    protected $menu_title = '網站內容管理';
    protected $route_code = 'marquee';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(MarqueeService $marqueeService)
    {
        $this->marqueeService = $marqueeService;
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];
    }
    
    /**
     * 所有資料頁面
     * @return view  admin/content/marquee/index.blade.php
     */
    public function index()
    {

    	$datas = $this->marqueeService->all(); 
        $data =[
            'datas' => $datas,
        ];
        return view('admin.content.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }

    
    /**
     * 新增畫面
     *
     * @return view  admin/content/marquee/create.blade.php
     */
    public function create()
    {
        $data=[];
        return view('admin.content.'.$this->route_code.'.create',array_merge($this->view_data,$data));
    }

    /**
     * 資料儲存處理
     *
     * @param  Request $request
     * @return json
     */
    public function store(Request $request)
    {
        $data= [
           'content' => $request->content, 
           'sort_order' => $request->sort_order, 
        ];
        $result = $this->marqueeService->add($data);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }      
    }

    /**
     * 編輯頁面
     *
     * @param  int $id
     * @return view  admin/content/marquee/edit.blade.php
     */
    public function edit($id)
    {
        $info = $this->marqueeService->find($id); 
        $data =[
            'data' => $info,
        ];
        return view('admin.content.'.$this->route_code.'.edit',array_merge($this->view_data,$data));
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
        $data = [
            'sort_order' => $request->sort_order, 
            'content' => $request->content, 
        ];
        $result = $this->marqueeService->update($id,$data);
        if ($result['status'] ) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }    
    }

    /**
     * 資料刪除處理
     *
     * @param  int $id
     * @return json
     */
    public function destroy($id)
    {
        $result = $this->marqueeService->delete($id);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }    
    }
    
    


}
