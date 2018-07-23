<?php

namespace App\Http\Controllers\Admin\Game;

use App\Http\Controllers\Controller;
use App\Http\Requests;
//use App\Services\Game\Sport\SportService;
use App\Services\Game\Sport\SportGameService;
use App\Services\Game\Sport\Lottery539Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class Lottery539sController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $sportService;
    protected $sportGameService;
    protected $page_title = '彩球539';
    protected $route_code = 'lottery539';
    protected $number_to_code = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        Lottery539Service $sportService,
        SportGameService $sportGameService
    ) {
        $this->sportService = $sportService;
        $this->sportGameService = $sportGameService;
    }
    
    /**
     * 最新賽程資料頁面（未打完）
     * @param int $category_id
     * @return view  admin/game/lottery539/index.blade.php
     */
    public function index($category_id=3)
    {
        $category = $this->sportService->findCategory($category_id);
        if(!$category){
            abort(404);
        }
    	$datas = $this->sportService->allByStatus($category_id,0); 
        
        $data =[
            'datas' => $datas,
            'category_id' => $category_id,
            'route_code' => $this->route_code,
            'page_title' => $category->name,
            'menu_title' => $category->name,
        ];
        return view('admin.game.'.$this->route_code.'.index',$data);
    }

    /**
     * 歷史賽程資料頁面（已結束）
     * @param date $start
     * @param date $end
     * @return view  admin/game/lottery539/history.blade.php
     */
    public function history($start = null, $end = null)
    {
        $category = $this->sportService->findCategory(3);
        if(!$category){
            abort(404);
        }
        if(!$start || !$end){
            $date_info = getDefaultDateRange(7);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
        $datas = $this->sportService->allByStatus($category->id,1,$start,$end); 
        
        $data =[
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
            'category_id' => $category->id,
            'route_code' => $this->route_code,
            'page_title' => $category->name,
            'menu_title' => $category->name,
        ];
        return view('admin.game.'.$this->route_code.'.history',$data);
    }

    /**
     * 詳細資料頁面
     *
     * @param  int $sport_id
     * @return view  admin/game/lottery539/show.blade.php
     */
    public function show($id)
    {

        $sport = $this->sportService->find($id); 
        if(!$sport){
            abort(404);
        }
        $category = $sport->category;
        $data =[
            'data' => $sport,
            'category_id' => $sport->sport_category_id, 
            'route_code' => $this->route_code,
            'page_title' => $category->name,
            'menu_title' => $category->name,
        ];

        return view('admin.game.'.$this->route_code.'.show',$data);
        
    }


    /**
     * 編輯頁面
     *
     * @param  int $sport_id
     * @return view  admin/game/lottery539/edit.blade.php
     */
    public function edit($sport_id)
    {
        $sport = $this->sportService->find($sport_id); 
        if(!$sport){
            abort(404);
        }
        $teams = $sport->teams;
        $category = $sport->category;
        $data =[
            'data' => $sport,
            'category_id' => $sport->sport_category_id, 
            'route_code' => $this->route_code,
            'page_title' => $category->name,
            'menu_title' => $category->name,
            'numbers' => $sport->teams
        ];

        return view('admin.game.'.$this->route_code.'.edit',$data);
        
    }

    /**
     * 資料完整更新處理
     *
     * @param  int $sport_id,
     * @param Request $request
     * @return json
     */
    public function update($sport_id,Request $request)
    {   
        //檢查數字格式
        if(!$this->sportService->checkIfNumbersValid( $request->lottery_numbers)){
            return json_encode(array('result' => 0, 'text' => '開獎號碼有誤，請重新確認'));
        }
        $data= [
           'result' => json_encode(['numbers' => $request->lottery_numbers]), 
           'sport_id' => $sport_id,
           'number' => $request->sport_number, 
        ];
        $result = $this->sportService->update($data) ;
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg'],'content' => $result['content']));
        }  
    }


    /**
     * ===========
     * 單一賽程賭盤管理
     * ===========
     */

    /**
     * 賭盤列表
     * @param int $sport_id
     * @return view  admin/game/lottery539/gamble/index.blade.php
     */
    public function gamebleIndex($sport_id)
    {
        $sport = $this->sportService->find($sport_id);
        if(!$sport){
            abort(404);
        }
        $datas = $sport->games; 
        $teams = $sport->teams;
        $category = $sport->category;
        $data =[
            'datas' => $datas,
            'sport' => $sport,
            'route_code' => $this->route_code,
            'category' => $category,
            'page_title' => '#'.$sport->id,
            'menu_title' => $category->name,
        ];

        return view('admin.game.'.$this->route_code.'.gamble.index',$data);
    } 



}
