<?php

namespace App\Http\Controllers\Front\Member;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Game\Sport\CnChessService;
use App;
use Auth;
use Validator;

class CnChessHistoryController extends Controller
{

    protected $sportService;
    protected $sportGameService;
    protected $page_title = '象棋開獎紀錄';
    protected $route_code = 'cn_chess_history';
    
	public function __construct(
        CnChessService $sportService
    ) {
        $this->sportService = $sportService;
    }

    /**
     * 搜尋結果明細
     * @param Request $request
     * @return view front/member/cn_chess_history/index.blade.php
     */
    public function index($date = null)
    {
        $today = date('Y-m-d');
        if(!$date){
            $date = date('Y-m-d');
        } else {
            //檢查是否於七天內
            $days = countDaysBetweenTwoDate($date,$today);
            if($days >= 7 ){
                abort(404);
            }
        }
        
        $datas = $this->sportService->allGames($date,$date,0); 

        $data =[
            'datas' => $datas,
            'date' => $date,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title ,
        ];
        return view('front.member.'.$this->route_code.'.index',$data); 
    }

    
}
