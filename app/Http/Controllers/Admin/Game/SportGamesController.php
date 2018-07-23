<?php

namespace App\Http\Controllers\Admin\Game;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Game\Sport\SportService;
use App\Services\Game\Sport\SportGameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class SportGamesController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $sportService;
    protected $sportGameService;
    protected $page_title = '賭盤列表';
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
     * 所有賭盤資料
     * @param int $category_id
     * @param date $start
     * @param date $end
     * @return view  admin/game/sport/gambles.blade.php
     */
    public function index($category_id=1,$start = null, $end = null)
    {
        $category = $this->sportService->findCategory($category_id);
        if(!$category){
            abort(404);
        }
        if(!$start || !$end){
            $date_info = getDefaultDateRange(0);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }
        $datas = $this->sportGameService->all($category_id,'%',$start,$end); 
        
        $data =[
            'datas' => $datas,
            'start' => $start,
            'end' => $end,
            'category_id' => $category_id,
            'route_code' => $this->route_code,
            'page_title' => $category->name,
            'menu_title' => $category->name
        ];
        return view('admin.game.sport.gambles',$data);
    }

  
    /**
     * 賭盤資訊
     * @param int $sport_game_id
     * @return view  admin/game/sport/gamble/show/遊戲類型.blade.php
     */
    public function show($sport_game_id)
    {
        $game = $this->sportGameService->find($sport_game_id);
        if(!$game){
            abort(404);
        }

        $sport = $game->sport;
        $teams = $sport->teams;
        $category = $sport->category;
        $data =[
            'data' => $game,
            'sport' => $sport,
            'route_code' => $this->route_code,
            'home_team' => $teams->where('home','1')->first(),
            'away_team' => $teams->where('home','0')->first(),
            'category' => $category,
            'detail' => $game->detail,
            'menu_title' => $category->name,
            'page_title' => '#'.config('game.sport.game.type.'.$game->type)
        ];

        return view('admin.game.sport.gamble.show.'.$this->number_to_code[$game->type],$data);
    } 

    /**
     * 賭盤編輯
     * @param int $sport_game_id
     * @return view  admin/game/sport/gamble/edit/遊戲類型.blade.php
     */
    public function edit($sport_game_id)
    {
        $game = $this->sportGameService->find($sport_game_id);
        if(!$game){
            abort(404);
        }

        $sport = $game->sport;
        $teams = $sport->teams;
        $category = $sport->category;
        $data =[
            'data' => $game,
            'sport' => $sport,
            'type' => $game->type,
            'route_code' => $this->route_code,
            'home_team' => $teams->where('home','1')->first(),
            'away_team' => $teams->where('home','0')->first(),
            'category' => $category,
            'detail' => $game->detail,
            'menu_title' => $category->name,
            'page_title' => '#'.config('game.sport.game.type.'.$game->type)
        ];

        return view('admin.game.sport.gamble.edit.'.$this->number_to_code[$game->type],$data);
    } 

    /**
     * 賭盤資料更新處理
     * @param  int $sport_game_id
     * @param  Request $request
     * @return json
     */
    public function update($sport_game_id,Request $request)
    {
        $result = $this->sportGameService->update($request->type,$request->all(),$sport_game_id);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
        } 
    }

    /**
     * 賭盤狀態更新處理
     * @param  int $sport_game_id
     * @param  Request $request
     * @return json
     */
    public function changeStatus($sport_game_id,Request $request)
    {
        $result = $this->sportGameService->changeStatus($request->bet_status,$sport_game_id);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
        } 
    }

    /**
     * 賭盤新增
     * @param int $sport_id
     * @param int $type 賭盤類型
     * @return view  admin/game/sport/gamble/create/遊戲類型.blade.php
     */
    public function create($sport_id,$type = 1)
    {
        $sport = $this->sportService->find($sport_id);
        if(!$sport){
            abort(404);
        }
        $teams = $sport->teams;
        $category = $sport->category;
        $data =[
            'sport' => $sport,
            'type' => $type,
            'category' => $category,
            'home_team' => $teams->where('home','1')->first(),
            'away_team' => $teams->where('home','0')->first(),
            'route_code' => $this->route_code,
            'menu_title' => $category->name,
            'page_title' => '#'.$sport->sport_number
        ];
        return view('admin.game.sport.gamble.create.'.$this->number_to_code[$type],$data);
    } 

    /**
     * 賭盤資料儲存處理
     *
     * @param  Request $request
     * @return json
     */
    public function store(Request $request)
    {
        $result = $this->sportGameService->add($request->type,$request->all());
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
        } 
    }

    /**
     * 資料刪除處理
     *
     * @param  int $sport_game_id
     * @return json
     */
    public function destroy($sport_game_id)
    {
        $result = $this->sportGameService->delete($sport_game_id);
        if ($result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error_msg']));
        }
    }

     /**
     * 賭盤下注明細
     * @param int $sport_game_id
     * @return view  admin/game/sport/gamble/bet_record.blade.php
     */
    public function betRecord($sport_game_id)
    {
        $game = $this->sportGameService->find($sport_game_id);
        if(!$game){
            abort(404);
        }

        $sport = $game->sport;
        $teams = $sport->teams;
        $category = $sport->category;
        $records = $game->bets;
        $data =[
            'data' => $game,
            'sport' => $sport,
            'datas' => $records,
            'route_code' => $this->route_code,
            'home_team' => $teams->where('home','1')->first(),
            'away_team' => $teams->where('home','0')->first(),
            'category' => $category,
            'detail' => $game->detail,
            'page_title' => '#'.config('game.sport.game.type.'.$game->type)
        ];

        return view('admin.game.sport.gamble.bet_record',$data);
    } 


}
