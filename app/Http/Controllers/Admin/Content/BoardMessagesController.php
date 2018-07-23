<?php

namespace App\Http\Controllers\Admin\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Content\BoardMessageService;
use App;
use Auth;

class BoardMessagesController extends Controller
{

    protected $messageService;
    protected $page_title = '留言板管理';
    protected $menu_title = '網站內容管理';
    protected $route_code = 'board_message';
    protected $view_data = [];
    
	public function __construct(
        BoardMessageService $messageService
    ) {
        $this->messageService = $messageService;
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];
    }

    /**
     * 留言板首頁
     * @param date $start
     * @param date $end
     * @return view  admin/content/board_message/index.blade.php
     */
    public function index($start = null,$end=null)
    {
        if(!$start || !$end){
            $date_info = getDefaultDateRange(5);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
    	$data=[
            'datas' => $this->messageService->allToPaginate($start,$end,30),
            'start' => $start,
            'end' => $end,
    	];

	    return view('admin.content.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }

   
    /**
     * 資料刪除處理
     *
     * @param  int $id
     * @return json
     */
    public function destroy($id)
    {
        $message = $this->messageService->find($id);
        if(!$message){
            return json_encode(array('result' => 0));
        }

        $result = $this->messageService->delete($id,'admin');
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        }  
    } 


}
