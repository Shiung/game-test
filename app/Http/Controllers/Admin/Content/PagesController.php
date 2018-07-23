<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Content\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class PagesController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $pageService;
    protected $page_title = '頁面內容管理';
    protected $menu_title = '網站內容管理';
    protected $route_code = 'page';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];
    }
    
    /**
     * 所有資料頁面
     * @return view  admin/content/page/index.blade.php
     */
    public function index()
    {

    	$datas = $this->pageService->all(); 
        $data =[
            'datas' => $datas,
        ];
        return view('admin.content.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }

    
    /**
     * 新增畫面
     *
     * @return view  admin/content/page/create.blade.php
     */
    public function create()
    {
        $data=[
        ];
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
           'title' => $request->title, 
           'content' => $request->content, 
           'status' => $request->status, 
           'code' => $request->code, 
        ];
        $result = $this->pageService->add($data);
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
     * @return view  admin/content/page/edit.blade.php
     */
    public function edit($id)
    {
        $info = $this->pageService->find($id); 
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
            'title' => $request->title, 
            'content' => $request->content, 
            'status' => $request->status, 
            'code' => $request->code, 
        ];
        $result = $this->pageService->update($id,$data);
        if ( $result['status']) {
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
        $result = $this->pageService->delete($id);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }    
    }
    
    


}
