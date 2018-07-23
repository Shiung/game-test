<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Content\BannerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class BannersController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $bannerService;
    protected $page_title = 'BANNER管理';
    protected $menu_title = '網站內容管理';
    protected $route_code = 'banner';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];
    }
    
    /**
     * 所有資料頁面
     * @return view  admin/content/banner/index.blade.php
     */
    public function index()
    {

    	$datas = $this->bannerService->all(); 
        $data =[
            'datas' => $datas,   
        ];
        return view('admin.content.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }

    
    /**
     * 新增畫面
     *
     * @return view  admin/content/banner/create.blade.php
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
           'name' => $request->name, 
           'filepath' => $request->filepath, 
           'url' => $request->url, 
           'sort_order' => $request->sort_order, 
        ];
        $result = $this->bannerService->add($data);
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
     * @return view  admin/content/banner/edit.blade.php
     */
    public function edit($id)
    {
        $info = $this->bannerService->find($id); 
        $data =[
            'data' => $info,
        ];
        return view('admin.content.'.$this->route_code.'.edit',array_merge($this->view_data,$data));
    }

    /**
     * 資料更新處理
     *
     * @param  int $id,
     * @param Request $request
     * @return json
     */
    public function update($id,Request $request)
    {   
        $data = [
            'name' => $request->name, 
            'filepath' => $request->filepath, 
            'url' => $request->url, 
            'sort_order' => $request->sort_order, 
        ];
        $result = $this->bannerService->update($id,$data);
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
        $result = $this->bannerService->delete($id);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }    
    }
    
    


}
