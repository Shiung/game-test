<?php

namespace App\Http\Controllers\Admin\Game;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Game\Sport\SportService;
use App\Services\Game\Sport\SportGameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class SportsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $sportService;
    protected $sportGameService;
    protected $page_title = '球類競賽管理';
    protected $route_code = 'sport';
    protected $number_to_code = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        SportService $sportService,
        SportGameService $sportGameService
    ) {
        $this->sportService = $sportService;
        $this->sportGameService = $sportGameService;
        $this->number_to_code = config('game.sport.game.number_to_code');
    }
    
    /**
     * 最新賽程資料頁面（未打完）
     * @param int $category_id
     * @return view  admin/game/sport/index.blade.php
     */
    public function index($category_id=1)
    {
        $category = $this->sportService->findCategory($category_id);
        if(!$category){
            abort(404);
        }
    	$datas = $this->sportService->all($category_id,['Scheduled','InProgress','Suspended']); 
        
        $data =[
            'datas' => $datas,
            'category_id' => $category_id,
            'route_code' => $this->route_code,
            'page_title' => $category->name,
            'menu_title' => $category->name
        ];
        return view('admin.game.'.$this->route_code.'.index',$data);
    }

    /**
     * 歷史賽程資料頁面（已結束）
     * @param int $category_id
     * @param date $start
     * @param date $end
     * @return view  admin/game/sport/history.blade.php
     */
    public function history($category_id=1,$start = null, $end = null)
    {
        $category = $this->sportService->findCategory($category_id);
        if(!$category){
            abort(404);
        }
        if(!$start || !$end){
            $date_info = getDefaultDateRange(7);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
        $datas = $this->sportService->all($category_id,['Canceled','Final','Postponed'],$start,$end); 
        
        $data =[
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
            'category_id' => $category_id,
            'route_code' => $this->route_code,
            'page_title' => $category->name,
            'menu_title' => $category->name
        ];
        return view('admin.game.'.$this->route_code.'.history',$data);
    }

    /**
     * 詳細資料頁面
     *
     * @param int $sport_id
     * @return view  admin/game/sport/show.blade.php
     */
    public function show($sport_id)
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
            'home_team' => $teams->where('home','1')->first(),
            'away_team' => $teams->where('home','0')->first(),
            'route_code' => $this->route_code,
            'page_title' => $category->name,
            'menu_title' => $category->name
        ];

        return view('admin.game.'.$this->route_code.'.show',$data);
        
    }

    
    /**
     * 新增畫面
     * @param int $category_id
     * @return view  admin/game/sport/create.blade.php
     */
    public function create($category_id)
    {
        $category = $this->sportService->findCategory($category_id);
        if(!$category){
            abort(404);
        }
        $data=[
            'category_id' => $category_id,
            'category' => $category,
            'page_title' => $category->name,
            'route_code' => $this->route_code,
            'menu_title' => $category->name
        ];
        return view('admin.game.'.$this->route_code.'.create',$data);
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
           'category_id' => $request->category_id, 
           'start_datetime' => $request->start_datetime, 
           'taiwan_datetime' => $request->taiwan_datetime, 
           'status' => $request->status, 
           'awayteam_name' => $request->awayteam_name, 
           'hometeam_name' => $request->hometeam_name, 
           'awayteam_score' => $request->awayteam_score, 
           'hometeam_score' => $request->hometeam_score, 
           'sport_id' => $request->sport_id,
        ];
        $result = $this->sportService->add($data);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
        }      
    }

    /**
     * 編輯頁面
     *
     * @param  int $sport_id
     * @return view  admin/game/sport/edit.blade.php
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
            'category' => $category,
            'home_team' => $teams->where('home','1')->first(),
            'away_team' => $teams->where('home','0')->first(),
            'route_code' => $this->route_code,
            'page_title' => $category->name,
            'menu_title' => $category->name
        ];

        //如果沒有賭盤，到編輯頁面
        //如果有賭盤開放下注，到修改分數頁面
        if(count($sport->games) == 0 ){
            return view('admin.game.'.$this->route_code.'.edit',$data);
        } else {
            //有人下過注
            if($this->sportService->checkIfHasBetRecords($sport)){
                return view('admin.game.'.$this->route_code.'.score_edit',$data);
            }
            //沒人下注、未開放下注
            if($sport->games->where('bet_status','0')->count() == count($sport->games)){   
                return view('admin.game.'.$this->route_code.'.edit',$data);
            } else {    
                return view('admin.game.'.$this->route_code.'.score_edit',$data);
            }
        }
        
    }

    /**
     * 賽程資料完整更新處理
     *
     * @param  int $sport_id
     * @param Request $request
     * @return json
     */
    public function update($sport_id,Request $request)
    {   
        $data= [
           'start_datetime' => $request->start_datetime,
           'taiwan_datetime' => $request->taiwan_datetime,  
           'status' => $request->status, 
           'awayteam_name' => $request->awayteam_name, 
           'hometeam_name' => $request->hometeam_name, 
           'awayteam_score' => $request->awayteam_score, 
           'hometeam_score' => $request->hometeam_score, 
           'sport_id' => $sport_id,
           'category_id' => $request->category_id, 
           'awayteam_id' => $request->awayteam_id,
           'hometeam_id' => $request->hometeam_id,
        ];
        $result = $this->sportService->update($data) ;
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
        }    
    }

    /**
     * 賽程比分更新處理
     *
     * @param int $sport_id
     * @param Request $request
     * @return json
     */
    public function updateScore($sport_id,Request $request)
    {   
        $data= [
           'awayteam_score' => $request->awayteam_score, 
           'hometeam_score' => $request->hometeam_score, 
           'sport_id' => $sport_id,
           'awayteam_id' => $request->awayteam_id,
           'hometeam_id' => $request->hometeam_id,
        ];
        $result = $this->sportService->updateScore($data) ;
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
        }    
    }

    /**
     * 賽程狀態編輯頁面
     *
     * @param  int $sport_id
     * @return view  admin/game/sport/status_edit.blade.php
     */
    public function editStatus($sport_id)
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
            'home_team' => $teams->where('home','1')->first(),
            'away_team' => $teams->where('home','0')->first(),
            'route_code' => $this->route_code,
            'page_title' => $category->name,
            'menu_title' => $category->name
        ];

        return view('admin.game.'.$this->route_code.'.status_edit',$data);
        
    }


    /**
     * 賽程狀態更新
     *
     * @param int $sport_id
     * @param Request $request
     * @return json
     */
    public function updateStatus($sport_id,Request $request)
    {   
        $data= [
           'status' => $request->status, 
           'sport_id' => $sport_id,
        ];
        $result = $this->sportService->updateStatus($data) ;
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
        }    
    }

    /**
     * 資料刪除處理
     *
     * @param  int $sport_id
     * @return json
     */
    public function destroy($sport_id)
    {
        $result = $this->sportService->delete($sport_id);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
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
     * @return view  admin/game/sport/gamble/index.blade.php
     */
    public function gamebleIndex($sport_id)
    {
        $sport = $this->sportService->find($sport_id);
        if(!$sport){
            abort(404);
        }
        $datas = $sport->games; 
        $teams = $sport->teams;
        $category  = $sport->category;
        $data =[
            'datas' => $datas,
            'sport' => $sport,
            'home_team' => $teams->where('home','1')->first(),
            'away_team' => $teams->where('home','0')->first(),
            'route_code' => $this->route_code,
            'category' => $category,
            'page_title' => '#'.$sport->id,
            'menu_title' => $category->name
        ];

        return view('admin.game.'.$this->route_code.'.gamble.index',$data);
    } 


    /**
     * 賭盤資訊
     * @param int $sport_game_id
     * @return view  admin/game/sport/gamble/show/遊戲類型.blade.php
     */
    public function gamebleShow($sport_game_id)
    {
        $game = $this->sportGameService->find($sport_game_id);
        if(!$game){
            abort(404);
        }

        $sport = $game->sport;
        $teams = $sport->teams;
        $data =[
            'data' => $game,
            'sport' => $sport,
            'route_code' => $this->route_code,
            'home_team' => $teams->where('home','1')->first(),
            'away_team' => $teams->where('home','0')->first(),
            'category' => $sport->category,
            'detail' => $game->detail,
            'page_title' => '#'.config('game.sport.game.type.'.$game->type)
        ];

        return view('admin.game.'.$this->route_code.'.gamble.show.'.$this->number_to_code[$game->type],$data);
    } 

    /**
     * 賭盤編輯
     * @param int $sport_game_id
     * @return view  admin/game/sport/gamble/edit/遊戲類型.blade.php
     */
    public function gamebleEdit($sport_game_id)
    {
        $game = $this->sportGameService->find($sport_game_id);
        if(!$game){
            abort(404);
        }

        $sport = $game->sport;
        $teams = $sport->teams;
        $data =[
            'data' => $game,
            'sport' => $sport,
            'type' => $game->type,
            'route_code' => $this->route_code,
            'home_team' => $teams->where('home','1')->first(),
            'away_team' => $teams->where('home','0')->first(),
            'category' => $sport->category,
            'detail' => $game->detail,
            'page_title' => '#'.config('game.sport.game.type.'.$game->type)
        ];

        return view('admin.game.'.$this->route_code.'.gamble.edit.'.$this->number_to_code[$game->type],$data);
    } 

    /**
     * 賭盤資料更新處理
     *
     * @param  Request $request
     * @return json
     */
    public function gambleUpdate($sport_game_id,Request $request)
    {
        $result = $this->sportGameService->update($request->type,$request->all(),$sport_game_id);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
        } 
    }

    /**
     * 賭盤新增
     * @param int $sport_id
     * @return view  admin/game/sport/gamble/create/遊戲類型.blade.php
     * @return index view
     */
    public function gamebleCreate($sport_id,$type = 1)
    {
        $sport = $this->sportService->find($sport_id);
        if(!$sport){
            abort(404);
        }
        $teams = $sport->teams;
        $data =[
            'sport' => $sport,
            'type' => $type,
            'category' => $sport->category,
            'home_team' => $teams->where('home','1')->first(),
            'away_team' => $teams->where('home','0')->first(),
            'route_code' => $this->route_code,
            'page_title' => '#'.$sport->sport_number
        ];
        return view('admin.game.'.$this->route_code.'.gamble.create.'.$this->number_to_code[$type],$data);
    } 

    /**
     * 賭盤資料儲存處理
     *
     * @param  Request $request
     * @return json
     */
    public function gambleStore(Request $request)
    {
        $result = $this->sportGameService->add($request->type,$request->all());
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
        } 
    }


}
