<?php 
namespace App\Services\Game\Sport\Gamble;

/**
 * 賭盤操作：運動-大小
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

class OverunderService implements GambleInterface
{
    //賭盤對應資料表名稱
    protected $bet_record_table = 'sport_bet_overunders';
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
        return [
            '1' => '大',
            '0' => '小'
        ];
    }

    /**
     * 新增
     * @param array $data
     * @return array
     */
    public function add($data)
    {   
        try{   
            $send_data = [
               'dead_heat_point' => $data['dead_heat_point'], 
               'real_bet_ratio' => $data['real_bet_ratio']/100, 
               'home_line' => $data['home_line']/100, 
               'away_line' => $data['away_line']/100, 
               'adjust_line' => $data['adjust_line']/100, 
               'sport_id' => $data['sport_id'], 
               'spread_one_side_bet' => $data['spread_one_side_bet'], 
            ];
            $send_data['token'] = Session::get('a_token');
            $result = curlApi(env('API_URL').'/sport/store_game_overunder',$send_data); 
        } catch (Exception $e){
            return ['status' => false, 'error_code' =>'System Error', 'error_msg'=> $e->getMessage()];
        }
        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']];
        }
        
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update($data,$id = null)
    {
        try{
            $send_data = [
               'dead_heat_point' => $data['dead_heat_point'], 
               'real_bet_ratio' => $data['real_bet_ratio']/100, 
               'home_line' => $data['home_line']/100, 
               'away_line' => $data['away_line']/100, 
               'adjust_line' => $data['adjust_line']/100, 
               'sport_id' => $data['sport_id'], 
               'spread_one_side_bet' => $data['spread_one_side_bet'], 
            ];
            $send_data['token'] = Session::get('a_token');
            
            $result = curlApi(env('API_URL').'/sport/store_game_overunder',$send_data); 
        } catch (Exception $e){
         return ['status' => false, 'error_code' =>'System Error', 'error_msg'=> $e->getMessage()];
        }
        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg']];
        }
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
        if(!$detail){
            return '<span style="color:red;">參數未設定完整'.$game->id.'</span>';
        }

        //檢查是否有未設定參數
        if(!$this->checkParameterComplete($detail->toArray())){
            return '<span style="color:red;">參數未設定完整</span>';
        }


        //賽程
        $sport = $game->sport;

        //隊伍
        $teams = $sport->teams;

        //類別
        $category = $sport->category;

        //主隊
        $home_team = $teams->where('home','1')->first();
        $away_team = $teams->where('home','0')->first();

        

        //處理平局分
        $point = $this->getPoint($detail);

        //網站顯示賠率
        $website_home_line = $detail->home_line+$detail->adjust_line;
        $website_away_line = $detail->away_line+$detail->adjust_line;

        $content = $home_team->name.'[主] <span style="color:green;font-weight:bold;"> '.$home_team->score.'</span> <span style="color:blue;">VS</span> '.$away_team->name.'<span style="color:green;font-weight:bold;"> '.$away_team->score."</span><br>";
        $content .= '<span style="color:red;">'.$point.'</span> <br> ';
        $content .= '@ [大]'.$detail->home_line.'(<span style="font-size:11px;">調整後</span>：'.$website_home_line.')<br>';
        $content .= '@ [小]'.$detail->away_line.'(<span style="font-size:11px;">調整後</span>：'.$website_away_line.')';
        return $content;
    }

    /**
     * 處理平局分
     *
     * @param SportGameOverunder $detail
     *
     * @return float
     */
    private function getPoint($detail){
        if(floor($detail->dead_heat_point)==$detail->dead_heat_point){
            //無小數點
            if($detail->real_bet_ratio < 0){
                $point = $detail->dead_heat_point.'-'.abs($detail->real_bet_ratio*100);
            } else if($detail->real_bet_ratio == 0){
                $point = $detail->dead_heat_point.'-平';
            } else {
                $point = $detail->dead_heat_point.'+'.abs($detail->real_bet_ratio*100);   
            }
            
        } else {
            //小數點
            $point = $detail->dead_heat_point;
        }
        return $point;
    }

    /**
     * 檢查參數是否完整
     *
     * @param array $detail
     *
     * @return bool
     */
    public function checkParameterComplete($detail){
        $v = Validator::make($detail, [
            'home_line' => 'required|not_in:0',
            'away_line' => 'required|not_in:0',
            'adjust_line' => 'required|min:0',
            'dead_heat_point' => 'required|min:0',
            'real_bet_ratio' => 'required',
        ]);
        if ($v->fails()){
            return false;
        }
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
        $point = $this->getPoint($detail);
        $data = [
            'type' => config('game.sport.game.number_to_code.'.$game->type),
            'typename' => '大小',
            'gameid' => $game->id,
            'point' => $point,
            'betstatus' => $game->bet_status
        ];

        //主隊(大)
        $home_data = [   
            'gamble' => 1,
            'line' => $detail->home_line+$detail->adjust_line,
            'gamblename' => '大',   
            'show_point' => $point
        ];

        //客隊（小）
        $away_data = [   
            'gamble' => 0,
            'line' => $detail->away_line+$detail->adjust_line,
            'gamblename' => '小',  
            'show_point' => '' 
        ];


        $data['home_data'] = $home_data;
        $data['away_data'] = $away_data;

        return $data;
    }

    /**
     * 檢查下注選項是否存在
     * @param SportGame $game
     * @param array $data = []
     * @return bool
     */
    public function checkGambleExist($game,$data = [])
    {   
        
        $gamble = $data['gamble'];
        if($gamble == 1 || $gamble  == 0){
            return true;
        } 
        return false;
    }

    /**
     * 下注
     * @param int $game_id
     * @param array $amount_data
     * @param array $data
     * @return array
     */
    public function bet($game,$amount_data,$data = [])
    {   
        try{   
            
            $send_data = [
               'sport_game_id' => $game->id, 
               'bet_type' => 1, 
               'gamble' => $data['gamble'], 
               'amounts' => $amount_data,
               'line' => json_encode(['line' => $data['line'] ]), 
            ];
            $send_data['token'] = Session::get('m_token');
            $result = curlApi(env('API_URL').'/sport/bet',$send_data); 
        } catch (Exception $e){
            return ['status' => false, 'error_code' =>'System Error', 'error_msg'=> $e->getMessage()];
        }
        $result = json_decode($result, true);
        if($result['result'] == 1){
            $content = $this->getBetSuccessInfo($result['bet_record_ids']);
            return ['status' => true ,'content' => $content];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg'],'detail' =>$result['detail']];
        }
        
    }

    /**
     * 下注成功回傳資訊
     * $game,$parameters = []
     * @return array
     */
    private function getBetSuccessInfo($ids)
    {
        $records  = [];
        $data['info'] = [
            'type_name' => '大小',
            'type' => 'overunder'
        ];
        foreach ($ids as $record_id) {
            $record = SportBetRecord::find($record_id);
            array_push($records,[
                'amount' => $record->amount,
                'account_name' => config('member.account.type.'.$record->account->type),
                'bet_number'=> $record->bet_number,
                'created_at'=> date('m-d H:i', strtotime($record->created_at))
            ]);
            $detail = $record->detail;
            $data['info']['gamble'] = $detail->gamble;
            ($detail->gameble == 1)?($data['info']['gamble_name'] = '大'):($data['info']['gamble_name'] = '小');
            $data['info']['line'] = $detail->line;
            $data['info']['real_bet_ratio'] = $detail->real_bet_ratio;
            $data['info']['dead_heat_point'] = $detail->dead_heat_point;
        }
        $data['records'] = $records;
        return $data;
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
        $detail = $record->detail;

        //賭盤 
        $game = $record->game;

        //賽程
        $sport = $game->sport;

        //隊伍
        $teams = $sport->teams;

        //類別
        //$category = $sport->category;

        //主隊
        $home_team = $teams->where('home','1')->first();
        $away_team = $teams->where('home','0')->first();

        //下注選項
        if($detail->gamble == 1){
            $gamble = '大';
        } else {
            $gamble = '小';
        }

        //處理平局分
        $point = $this->getPoint($detail);

        //網站顯示賠率
        $website_home_line = $detail->home_line+$detail->adjust_line;
        $website_away_line = $detail->away_line+$detail->adjust_line;

        $content = $home_team->name.'[主] <span style="color:green;font-weight:bold;"> '.$home_team->score.'</span> <span style="color:blue;">VS</span> '.$away_team->name.'<span style="color:green;font-weight:bold;"> '.$away_team->score."</span>";
        $content .= ' <span style="color:blue;"> '.$point.'</span> <br> ';
        $content .= '<span style="color:red"> '.$gamble.'</span>';
        $content .= ' @ <span style="color:red">'.$detail->line.'</span>';
        return $content;
    }


}
