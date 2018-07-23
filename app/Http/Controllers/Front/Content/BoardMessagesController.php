<?php

namespace App\Http\Controllers\Front\Content;

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
    protected $page_title = '留言板';
    protected $route_code = 'board_message';
    protected $user;
    
	public function __construct(
        BoardMessageService $messageService
    ) {
        $this->messageService = $messageService;
        $this->user = Auth::guard('web')->user();
    }

    /**
     * 留言板首頁
     * @param date $start
     * @param date $end
     * @return view  front/content/board_message/index.blade.php
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
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
    	];

	    return view('front.content.'.$this->route_code.'.index',$data);
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
           'member_id' => Auth::guard('web')->user()->id, 
           'content' => $request->content, 
        ];
        $result = $this->messageService->add($data);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => 'Failed：'.$result['error']));
        }      
    }

    /**
     * 資料更新處理
     *
     * @param  int $id 留言id
     * @param  Request $request
     * @return json
     */
    public function update($id,Request $request)
    {   
        $message = $this->messageService->find($id);
        //檢查是否有修改權限
        if(!$message){
            return json_encode(array('result' => 0));
        }
        if($this->user->type == 'member'){
            if($message->member_id != $this->user->id){
                return json_encode(array('result' => 0));
            }
        }
        
        $data = [
            'content' => $request->content, 
        ];
        $result = $this->messageService->update($id,$data) ;
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => 'Failed：'.$result['error']));
        }    
    }

    /**
     * 資料刪除處理
     *
     * @param  int $id 留言id
     * @return json
     */
    public function destroy($id)
    {
        $message = $this->messageService->find($id);
        //檢查是否有修改權限
        if(!$message){
            return json_encode(array('result' => 0));
        }
        if($this->user->type == 'member'){
            if($message->member_id != $this->user->id){
                return json_encode(array('result' => 0));
            }
        }
        $result = $this->messageService->delete($id);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => 'Failed：'.$result['error']));
        }  
    } 


}
