<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Content\NewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use App\Services\System\MemberNewsReadRecordService;

class NewsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $newsService;
    protected $newsReadRecordService;
    protected $page_title = '最新消息';
    protected $menu_title = '網站內容管理';
    protected $route_code = 'news';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(NewsService $newsService,MemberNewsReadRecordService $newsReadRecordService)
    {
        $this->newsService = $newsService;
        $this->newsReadRecordService = $newsReadRecordService;
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];
    }
    
    /**
     * 所有資料頁面
     * @param date $start
     * @param date $end
     * @return view  admin/content/news/index.blade.php
     */
    public function index($start = null, $end = null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(30);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$datas = $this->newsService->all('news',$start,$end); 
        $alert = $this->newsService->findSystemAlert();
        $data =[
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
            'alert' => $alert,
        ];
        return view('admin.content.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }

    
    /**
     * 新增畫面
     *
     * @return view  admin/content/news/create.blade.php
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
           'title' => $request->title, 
           'content' => $request->content, 
           'status' => $request->status, 
           'post_date' => $request->post_date, 
        ];
        $result = $this->newsService->add($data);
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
     * @return view  admin/content/news/edit.blade.php
     */
    public function edit($id)
    {
        $info = $this->newsService->find($id); 
        $data =[
            'data' => $info,
        ];
        return view('admin.content.'.$this->route_code.'.edit',array_merge($this->view_data,$data));
    }

    /**
     * 資料更新處理
     *
     * @param int $id
     * @param Request $request
     * @return json
     */
    public function update($id,Request $request)
    {   
        $data = [
            'title' => $request->title, 
            'content' => $request->content, 
            'status' => $request->status, 
            'post_date' => $request->post_date, 
        ];
        $result = $this->newsService->update($id,$data) ;
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }    
    }

    /**
     * 資料刪除處理
     *
     * @param int $id
     * @return json
     */
    public function destroy($id)
    {
        $result = $this->newsService->delete($id);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }    
    }



    /**
     * 系統彈跳視窗頁面
     * @param date $start
     * @param date $end
     * @return view  admin/content/news/system_alert.blade.php
     */
    public function systemAlertindex()
    {

        $alert = $this->newsService->findSystemAlert();
        $data =[
            'data' => $alert,
            'route_code' => $this->route_code,
            'page_title' => '系統彈跳公告管理',
            'menu_title' => $this->menu_title,
        ];
        return view('admin.content.'.$this->route_code.'.system_alert',$data);
    }


    /**
     * 彈跳系統資料更新處理
     *
     * @param int $id
     * @param Request $request
     * @return json
     */
    public function systemAlertUpdate(Request $request)
    {   
        $data = [
            'title' => $request->title, 
            'content' => $request->content, 
            'status' => $request->status, 
        ];
        $result = $this->newsService->updateSystemAlert($data) ;
        if ($result['status']) {
            $this->newsReadRecordService->delete(1);
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }    
    }
    
    


}
