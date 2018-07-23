<?php

namespace App\Http\Controllers\Admin\Game;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Game\Sport\SportGameService;
use App\Services\Game\Sport\CnChessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class CnChessesController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $sportService;
    protected $sportGameService;
    protected $page_title = '象棋';
    protected $route_code = 'cn_chess';
    protected $number_to_code = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(
        CnChessService $sportService,
        SportGameService $sportGameService
    ) {
        $this->sportService = $sportService;
        $this->sportGameService = $sportGameService;
    }

    /**
     * 歷史賽程資料頁面（已結束）
     * @param date $start
     * @param date $end
     * @return view  admin/game/cn_chess/history.blade.php
     */
    public function history($start = null, $end = null)
    {
        $category = $this->sportService->findCategory(4);
        if(!$category){
            abort(404);
        }
        if(!$start || !$end){
            $date_info = getDefaultDateRange(0);
            $start = $date_info['start'];
            $end = $date_info['end'];
        }

        $latest_data = $this->sportService->getLatestGame(); 
        
        $datas = $this->sportService->allGames($start,$end); 

        $data =[
            'latest_data' => $latest_data,
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
     * @return view  admin/game/cn_chess/show.blade.php
     */
    public function show($sport_id)
    {

        $sport = $this->sportService->find($sport_id); 
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


   


}
