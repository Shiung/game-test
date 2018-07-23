<?php 
namespace App\Services\Game\Sport\Gamble;

/**
 * 賭盤操作：象棋-選紅黑
 *
 * @license MIT
 */

use App;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;
use App\Services\Game\Sport\Contracts\GambleInterface;
use App\Models\Sport\SportBetRecord;
use Validator;

class CnChessColorService implements GambleInterface
{
    //賭盤對應資料表名稱
    protected $bet_record_table = 'sport_bet_cn_chess_colors';
    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct()
    {

    }

    /**
     * 取得table名稱
     * @return string
     */
    public function getTable()
    {   
        return $this->bet_record_table;
    }

    /**
     * 取得所有下注選項
     * @param SportGame $game
     * @return array
     */
    public function getGambles($game=null)
    {   
        $arr = [];
        for($i=1; $i <40 ; $i+1) { 
            $arr[$i] = $i;
        }
        return $arr;
    }

    
    /**
     * 顯示後台的賭盤內容摘要
     *
     * @param SportGame $game
     *
     * @return string
     */
    public function showGameSummary($game)
    {
        //賭盤詳細參數
        $detail = $game->detail;

        $content = '@[紅多]'.$detail->red_ratio.'<br>';
        $content .= '@[黑多]'.$detail->black_ratio;
       
        return $content;
    }


    /**
     * 檢查參數是否完整
     *
     * @param array $detail
     *
     * @return bool
     */
    public function checkParameterComplete($detail){
        return true;
    }

    /**
     * 回傳單一賭盤的資訊參數
     *
     * @param SportGame $game
     * @param Sport $sport
     * @param $teams
     *
     * @return array
     */
    public function getGameParameter($game,$sport,$teams)
    {

        //詳細
        $detail = $game->detail;

        $data = [
            'type' => config('game.sport.game.number_to_code.'.$game->type),
            'typename' => '象棋紅黑',
            'gameid' => $game->id,
            'red_ratio' => $detail->red_ratio,
            'black_ratio' => $detail->black_ratio,
        ];

        
        return $data;
    }

    /**
     * 前台的賭盤資訊
     *
     * @param SportGame $game
     *
     * @return string
     */
    public function showGameRule($game)
    {
        $detail = $game->detail;
        $content = '紅多：<span style="color:red;">'. $detail->red_ratio.'</span>';
        $content .= '  黑多：<span style="color:red;">'.$detail->black_ratio.'</span>';

        return $content;
    }

    /**
     * 檢查下注選項是否存在
     * @param SportGame $game
     * @param array $data = []
     * @return bool
     */
    public function checkGambleExist($game,$data = [])
    {   
        $numbers = $data['numbers'];
        $arr = [];
        foreach ($numbers as $number) {
            if($number >= 0 && $number < 2){
                array_push($arr,$number);
            }
        }
        if(count($arr) != count($numbers)){
            return false;
        } 
        return true;
    }

    /**
     * 取得下注格式
     * @param int $game_id
     * @param array $amount_data
     * @param array $data
     * @return array
     */
    public function getFormatBetData($game_id,$amount_data,$data = [])
    {   
        $send_data = [
           'sport_game_id' => $game_id, 
           'bet_type' => 5, 
           'amounts' => $amount_data,
           'line' => json_encode([
                'red_ratio' => $data['red_ratio'],
                'black_ratio' => $data['black_ratio'],
            ]), 
           'gamble' => $data['gamble'],
        ];
        return $send_data;
        
    }


    /**
     * 顯示下注明細內容
     *
     * @param BetRecord $record
     *
     * @return string
     */
    public function showBetRecordSummary($record)
    {
        //下注詳細參數
        $details = $record->detail;
        $numbers = '';
        foreach ($details as $detail ) {
            $numbers = "<span style='color:".config('cn_chess.color_type.'.$detail->gamble.'.color')."'>".config('cn_chess.color_type.'.$detail->gamble.'.name')."</span>";
        }

        //賭盤 
        $game = $record->game;

        //賽程
        $sport = $game->sport;

        //開獎結果
        $open_numbers = '';
        $teams = $sport->teams;
        foreach ($teams as $team ) {
            $open_numbers .= "<span style='color:".config('cn_chess.number_to_chess.'.$team->number.'.color')."'>".config('cn_chess.number_to_chess.'.$team->number.'.chess')."</span>";

        }
        if(count($open_numbers) == 0){
            $result = '尚未開獎';
        } else {
            $result = $open_numbers;
        }

        //類別
        //$category = $sport->category;

        $content = '開獎號碼：['.$result."]<br>";
        $content .= $numbers;
        $content .= '@[紅多] <span style="color:red;">'.$detail->red_ratio.'</span> / ';
        $content .= '[黑多] <span style="color:red;">'.$detail->black_ratio.'</span> ';
       
        return $content;
    }


}
