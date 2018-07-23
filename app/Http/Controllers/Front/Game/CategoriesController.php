<?php

namespace App\Http\Controllers\Front\Game;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Game\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $categoryService;
    protected $page_title = '球類競賽';
    protected $route_code = 'sport';
    protected $number_to_code = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        CategoryService $categoryService
    ) {
        $this->categoryService = $categoryService;
    }
    
    /**
     * 比賽類別
     * @return view front/game/index.blade.php
     */
    public function index()
    {
        $datas = $this->categoryService->allMainCategories();

        $data =[
            'datas' => $datas,
            'page_title' => '遊戲大廳',
            'route_code' => $this->route_code,
        ];
        return view('front.game.index',$data);
    }

    /**
     * 重新導向各遊戲類別頁面
     * @param string $type 遊戲類別代碼 （參考config/game.php）
     * @return route()
     */
    public function redirectSportIndex($type)
    {
        $game_type = config('game.category.'.$type.'.type');

        switch ($game_type) {
            case 'baseball':
                return redirect()->route('front.game.sport.index',$type);
                break;
            case 'lottery539':
                return redirect()->route('front.game.lottery539.gamble.index');
                break;
            case 'basketball':
                return redirect()->route('front.game.sport.index',$type);
                break;
            case 'football':
                return redirect()->route('front.game.sport.index',$type);
                break;
            case 'cn_chess':
                return redirect()->route('front.game.cn_chess.entry');

                break;
            default:
                return '功能開發中';
                break;
        }

    }

    /**
     * 重新導向歷史賽事
     * @param string $type 遊戲類別代碼 （參考config/game.php）
     * @param date $start 日期
     * @return route()
     */
    public function redirectHistory($type,$start = null)
    {
        $game_type = config('game.category.'.$type.'.type');

        switch ($game_type) {
            case 'baseball':
                return redirect()->route('front.game.sport.history',[$type,$start]);
                break;
            case 'lottery539':
                return redirect()->route('front.game.lottery539.history',[$type,$start]);
                break;
            case 'basketball':
                return redirect()->route('front.game.sport.history',[$type,$start]);
                break;
            case 'football':
                return redirect()->route('front.game.sport.history',[$type,$start]);
                break;
            default:
                return '功能開發中';
                break;
        }

    }


    

}
