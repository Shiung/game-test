<?php

namespace App\Http\Controllers\Front\Game;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\Game\Sport\SportGameService;
use App\Services\Game\CategoryService;
use App\Services\Game\SSE\ChessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
// use Illuminate\Http\Response;
use Auth;
use Response;

class CnChessSSEController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $chessService;



    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(ChessService $chessService) 
    {
        $this->chessService = $chessService;
    }

    
    //header
    public function header()
    {
         $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function() {

            //while(true){
                echo 'retry:500'.PHP_EOL;
                $sport = $this->chessService->sport_chess();
                //$sec = strtotime($sport->start_datetime) - strtotime('now');
                echo 'data:'.$sport.PHP_EOL;
                echo PHP_EOL;
                ob_flush();
                flush();
            //}
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        return $response;
    }


    //最新開獎
    public function last_lottery()
    {
         
        $sport = $this->chessService->open_number();
        
        echo $sport;
        
    }


    //近五期開獎
    // public function last_five_lottery()
    // {

    //     $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function() {

    //         //while(true){
    //             echo 'retry:10000'.PHP_EOL;
    //             $sport = $this->chessService->last_five_lottery();
    //             //$sec = strtotime($sport->start_datetime) - strtotime('now');
    //             echo 'data:'.$sport.PHP_EOL;
    //             echo PHP_EOL;
    //             ob_flush();
    //             flush();
    //           //  sleep(0.5);
    //         //}
    //     });

    //     $response->headers->set('Content-Type', 'text/event-stream');
    //     $response->headers->set('Cache-Control', 'no-cache');
    //     return $response;
        
    // }
    public function last_five_lottery()
    {
        $sport = $this->chessService->last_five_lottery();
        return $sport;

    }


    //目前餘額  
    // public function balance()
    // {
    //    $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function() {
    //             $user = Auth::guard('web')->user();
    //         //while(true){
    //             echo 'retry:1000'.PHP_EOL;
    //             $sport = $this->chessService->balance($user->id);
    //             //$sec = strtotime($sport->start_datetime) - strtotime('now');
    //             echo 'data:'.$sport.PHP_EOL;
    //             echo PHP_EOL;
    //             ob_flush();
    //             flush();
    //           //  sleep(0.5);
    //         //}
    //     });

    //     $response->headers->set('Content-Type', 'text/event-stream');
    //     $response->headers->set('Cache-Control', 'no-cache');
    //     return $response; 
    // }
    public function balance()
    {
    
        $user = Auth::guard('web')->user();
        $sport = $this->chessService->balance($user->id);
        return $sport;

    }


    //下注紀錄
    // public function bet()
    // {
    //    $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function() {
    //             $user = Auth::guard('web')->user();
    //         //while(true){
    //             echo 'retry:1000'.PHP_EOL;
    //             $sport = $this->chessService->user_bets($user->id);
    //             //$sec = strtotime($sport->start_datetime) - strtotime('now');
    //             echo 'data:'.$sport.PHP_EOL;
    //             echo PHP_EOL;
    //             ob_flush();
    //             flush();
    //           //  sleep(0.5);
    //         //}
    //     });

    //     $response->headers->set('Content-Type', 'text/event-stream');
    //     $response->headers->set('Cache-Control', 'no-cache');
    //     return $response; 
    // }
    public function bet()
    {
        $user = Auth::guard('web')->user();
        $sport = $this->chessService->user_bets($user->id);
        return $sport;
    }

    public function chess_bet_one()
    {
        $sport = $this->chessService->chess_bet_one();
        return $sport;
    }
    

}
