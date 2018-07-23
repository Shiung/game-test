<?php 
namespace App\Services\Game\Sport\Gamble;

/**
 * 賭盤操作：象棋-選兩號
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

class CnChessNumberService implements GambleInterface
{
    //賭盤對應資料表名稱
    protected $bet_record_table = 'sport_bet_cn_chess_nums';
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

        $content = '@[中一顆]'.$detail->one_ratio.'<br>';
        $content .= '@[中兩顆]'.$detail->two_ratio.'<br>';
        $content .= '@[金幣疊牌加碼]'.$detail->virtual_cash_ratio.'<br>';
        $content .= '@[娛樂幣疊牌加碼]'.$detail->share_ratio;
       
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
            'typename' => '象棋數字',
            'gameid' => $game->id,
            'one_ratio' => $detail->one_ratio,
            'two_ratio' => $detail->two_ratio,
            'virtual_cash_ratio' => $detail->virtual_cash_ratio,
            'share_ratio' => $detail->share_ratio
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
        $content = '一顆球：<span style="color:red;">'. $detail->one_ratio.'</span>';
        $content .= '  兩顆球：<span style="color:red;">'.$detail->two_ratio.'</span>';
        $content .= '  金幣疊牌加碼：<span style="color:red;">'.$detail->virtual_cash_ratio.'</span>';
        $content .= '  娛樂幣疊牌加碼：<span style="color:red;">'.$detail->share_ratio.'</span>';

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
            if($number > 0 && $number < 23){
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
        $gamble = json_encode(['numbers' => $data['numbers']] );
        $send_data = [
           'sport_game_id' => $game_id, 
           'bet_type' => 4, 
           'amounts' => $amount_data,
           'line' => json_encode([
                'one_ratio' => $data['one_ratio'],
                'two_ratio' => $data['two_ratio'],
                'virtual_cash_ratio' => $data['virtual_cash_ratio'],
                'share_ratio' => $data['share_ratio']
            ]), 
           'gamble' => $gamble,
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
            if($detail->gamble != 1 && $detail->gamble != 2){
                $numbers = "<span style='color:".config('cn_chess.number_to_chess.'.$detail->gamble.'.color')."'>".config('cn_chess.number_to_chess.'.$detail->gamble.'.chess')."</span>";
            } else {
                $numbers .= " <span style='color:".config('cn_chess.number_to_chess.'.$detail->gamble.'.color')."'>".config('cn_chess.number_to_chess.'.$detail->gamble.'.chess')."</span>";
            
            }
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
        if(strlen($open_numbers) == 0){
            $result = '尚未開獎';
        } else {
            $result = $open_numbers;
        }

        $content = '開獎號碼：['.$result."]<br>";
        $content .= $numbers;
        $content .= '@[一顆] <span style="color:red;">'.$detail->one_ratio.'</span> / ';
        $content .= '[兩顆] <span style="color:red;">'.$detail->two_ratio.'</span> / ';
        $content .= '[金幣疊牌加碼] <span style="color:red;">'.$detail->virtual_cash_ratio.'</span>';
        $content .= '[娛樂幣疊牌加碼] <span style="color:red;">'.$detail->share_ratio.'</span>';
       
        return $content;
    }


}
