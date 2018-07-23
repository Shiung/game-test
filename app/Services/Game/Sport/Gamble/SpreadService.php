<?php 
namespace App\Services\Game\Sport\Gamble;

/**
 * 賭盤操作：運動-讓分
 *
 * @license MIT
 */

use App;
use Illuminate\Support\Facades\DB;
use Exception;
use Session;
use App\Services\Game\Sport\Contracts\GambleInterface;
use App\Models\Sport\SportBetRecord;
use App\Models\Sport\SportTeam;
use Validator;

class SpreadService implements GambleInterface
{
    //賭盤對應資料表名稱
    protected $bet_record_table = 'sport_bet_spreads';
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
     * 取得下注選項
     * @param SportGame $game
     * @return array
     */
    public function getGambles($game)
    {   
        $arr = [];
        //賽程
        $sport = $game->sport;
        //隊伍
        $teams = $sport->teams;
        foreach ($teams as $team) {
            $arr[$team->id] = $team->name;
        }
        return $arr;

    }

    /**
     * 新增
     * $data
     * @return array
     */
    public function add($data)
    {   
        try{  
            if($data['dead_heat_team_id'] == 'N'){
                return ['status' => false, 'error_code' => 'CHOOSE_TEAM', 'error_msg' => '請選擇讓分基準隊伍' ];
            } 
            $send_data = [
               'dead_heat_point' => $data['dead_heat_point'], 
               'real_bet_ratio' => $data['real_bet_ratio']/100, 
               'home_line' => $data['home_line']/100, 
               'away_line' => $data['away_line']/100, 
               'adjust_line' => $data['adjust_line']/100, 
               'sport_id' => $data['sport_id'], 
               'dead_heat_team_id' => $data['dead_heat_team_id'], 
               'spread_one_side_bet' => $data['spread_one_side_bet'], 
            ];
            $send_data['token'] = Session::get('a_token');
            $result = curlApi(env('API_URL').'/sport/store_game_spread',$send_data); 
        } catch (Exception $e){
            return ['status' => false, 'error_code' =>'System Error', 'error_msg'=> 'ccccc'.$e->getMessage()];
        }

        $result = json_decode($result, true);
        if($result['result'] == 1){
            return ['status' => true];
        } else {
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result ];
        }
    }

    /**
     * 更新
     * $id, $data
     * @return array
     */
    public function update($data,$id = null)
    {
        try{
            if($data['dead_heat_team_id'] == 'N'){
                return ['status' => false, 'error_code' => 'CHOOSE_TEAM', 'error_msg' => '請選擇讓分基準隊伍' ];
            }
            $send_data = [
               'dead_heat_point' => $data['dead_heat_point'], 
               'real_bet_ratio' => $data['real_bet_ratio']/100, 
               'home_line' => $data['home_line']/100, 
               'away_line' => $data['away_line']/100, 
               'adjust_line' => $data['adjust_line']/100, 
               'sport_id' => $data['sport_id'], 
               'dead_heat_team_id' => $data['dead_heat_team_id'], 
               'spread_one_side_bet' => $data['spread_one_side_bet'], 
            ];
            $send_data['token'] = Session::get('a_token');
            
            $result = curlApi(env('API_URL').'/sport/store_game_spread',$send_data); 
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
            return '<span style="color:red;">參數未設定完整</span>';
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

        if($detail->dead_heat_team_id == $home_team->id){
            $content = $home_team->name.'[主] <span style="color:green;font-weight:bold;"> '.$home_team->score.'</span>   <span style="color:blue;">'.$point.'</span> '.$away_team->name.'<span style="color:green;font-weight:bold;"> '.$away_team->score."</span><br>";
        } else {
            $content = $away_team->name.'<span style="color:green;font-weight:bold;"> '.$away_team->score.'</span>   <span style="color:blue;">'.$point.'</span> '.$home_team->name.' [主] <span style="color:green;font-weight:bold;"> '.$home_team->score."</span><br>";
        }

        $content .= '@ [主]'.$detail->home_line.'(<span style="font-size:11px;">調整後</span>：'.$website_home_line.')<br>';
        $content .= '@ [客]'.$detail->away_line.'(<span style="font-size:11px;">調整後</span>：'.$website_away_line.')';
        return $content;
    }

    /**
     * 處理平局分
     *
     * @param SportGameSpread $game
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
            'dead_heat_team_id' => 'required',
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
        //隊伍資訊
        $home_team = $teams->where('home','1')->first();
        $away_team = $teams->where('home','0')->first();
        
        //詳細
        $detail = $game->detail;
        $point = $this->getPoint($detail);
        $data = [
            'type' => config('game.sport.game.number_to_code.'.$game->type),
            'typename' => '讓分',
            'gameid' => $game->id,
            'point' => $point,
            'betstatus' => $game->bet_status,
            'headteam' => $detail->dead_heat_team_id
        ];

        //主隊
        $home_data = [   
            'gamble' => $home_team->id,
            'line' => $detail->home_line+$detail->adjust_line,
            'gamblename' => $home_team->name,   
        ];

        //客隊
        $away_data = [   
            'gamble' => $away_team->id,
            'line' => $detail->away_line+$detail->adjust_line,
            'gamblename' => $away_team->name,   
        ];

        if($detail->dead_heat_team_id == $home_team->id){
            $home_data['show_point'] = $point;
            $away_data['show_point'] = '';
        } else {
            $home_data['show_point'] = '';
            $away_data['show_point'] = $point;
        }

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
        $sport = $game->sport;
        $teams = $sport->teams;
        //隊伍資訊
        $home_team = $teams->where('home','1')->first();
        $away_team = $teams->where('home','0')->first();
        $gamble = $data['gamble'];
        if($gamble == $home_team->id || $gamble  == $away_team->id){
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
               'bet_type' => 2, 
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
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg'],'detail' =>$send_data];
        }
        
    }

    /**
     * 下注成功回傳資訊
     * @param array $ids
     * @return array
     */
    private function getBetSuccessInfo($ids)
    {
        $records  = [];
        $data['info'] = [
            'type_name' => '讓分',
            'type' => 'spread'
        ];
        foreach ($ids as $record_id) {
            $record = SportBetRecord::find($record_id);
            array_push($records,[
                'amount' => $record->amount,
                'account_name' => config('member.account.type.'.$record->account->type ),
                'bet_number'=> $record->bet_number,
                'created_at'=> date('m-d H:i', strtotime($record->created_at))
            ]);
            $detail = $record->detail;
            $data['info']['gamble'] = $detail->gamble;
            $data['info']['gamble_name'] = SportTeam::find($detail->gamble)->name;
            $data['info']['line'] = $detail->line;
            $data['info']['real_bet_ratio'] = $detail->real_bet_ratio;
            $data['info']['dead_heat_point'] = $detail->dead_heat_point;
            $data['info']['dead_heat_team_id'] = $detail->dead_heat_team_id;
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
        if($home_team->id == $detail->gamble){
            $gamble = $home_team->name;
        } else {
            $gamble = $away_team->name;
        }

        //處理平局分
        $point = $this->getPoint($detail);


        if($detail->dead_heat_team_id == $home_team->id){
            $content = $home_team->name.'[主] <span style="color:green;font-weight:bold;"> '.$home_team->score.'</span>   <span style="color:blue;">'.$point.'</span> '.$away_team->name.'<span style="color:green;font-weight:bold;"> '.$away_team->score."</span><br>";
        } else {
            $content = $away_team->name.'<span style="color:green;font-weight:bold;"> '.$away_team->score.'</span>   <span style="color:blue;">'.$point.'</span> '.$home_team->name.' [主] <span style="color:green;font-weight:bold;"> '.$home_team->score."</span><br>";
        }
        $content .= '<span style="color:red"> '.$gamble.'</span>';
        $content .= ' @ <span style="color:rec">'.$detail->line.'</span>';
        return $content;
    }


}
