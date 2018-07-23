<?php 
namespace App\Services\Game\Sport\Gamble;

/**
 * 賭盤操作：彩球539-選3號
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

class ChooseThreeService implements GambleInterface
{
    //賭盤對應資料表名稱
    protected $bet_record_table = 'sport_bet_539';
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
     * 更新 
     * @param array $data
     * @param int $id
     * @return array
     */
    public function update($data,$id = null)
    {
        try{
            $send_data = [
               'number' => $data['sport_number'], 
               'sport_id' => $id, 
               'result' => $data['result'], 
            ];
            $send_data['token'] = Session::get('a_token');
            
            $result = curlApi(env('API_URL').'/sport/modify_game_539',$send_data); 
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

        //類別
        $category = $sport->category;

        $content = '@[一顆]'.$detail->one_ratio.'<br>';
        $content .= '@[兩顆]'.$detail->two_ratio.'<br>';
        $content .= '@[三顆]'.$detail->three_ratio;
       
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
        $v = Validator::make($detail, [
            'one_ratio' => 'required|not_in:0',
            'two_ratio' => 'required|not_in:0',
            'three_ratio' => 'required|not_in:0',
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

        $data = [
            'type' => config('game.sport.game.number_to_code.'.$game->type),
            'typename' => '選三號',
            'gameid' => $game->id,
            'one_ratio' => $detail->one_ratio,
            'two_ratio' => $detail->two_ratio,
            'three_ratio' => $detail->three_ratio
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
        $content .= '  三顆球：<span style="color:red;">'.$detail->three_ratio.'</span>';
        return $content;
    }

    /**
     * 檢查下注選項是否存在
     * @param SportGame $game
     * @param array $data
     * @return bool
     */
    public function checkGambleExist($game,$data = [])
    {   
        $numbers = $data['numbers'];
        $arr = [];
        foreach ($numbers as $number) {
            if($number > 0 && $number < 40){
                array_push($arr,$number);
            }
        }
        if(count($arr) != count($numbers)){
            return false;
        } 
        return true;
    }

    /**
     * 下注
     * @param SportGame $game
     * @param array $amount_data
     * @param array $data
     * @return array
     */
    public function bet($game,$amount_data,$data = [])
    {   
        try{   
            $gamble = json_encode(['numbers' => $data['numbers']] );
            $send_data = [
               'sport_game_id' => $game->id, 
               'bet_type' => 3, 
               'amounts' => $amount_data,
               'line' => json_encode([
                    'one_ratio' => $data['one_ratio'],
                    'two_ratio' => $data['two_ratio'],
                    'three_ratio' => $data['three_ratio']
                ]), 
               'gamble' => $gamble,
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
            return ['status' => false, 'error_code' => $result['error_code'], 'error_msg' => $result['error_msg'],'detail' => $result['detail']];
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
            'type_name' => '選三號',
            'type' => 'choose_three'
        ];
        foreach ($ids as $record_id) {
            $record = SportBetRecord::find($record_id);
            array_push($records,[
                'amount' => $record->amount,
                'account_name' => config('member.account.type.'.$record->account->type),
                'bet_number'=> $record->bet_number,
                'created_at'=> date('m-d H:i', strtotime($record->created_at))
            ]);
            $details = $record->detail;
            $numbers = [];
            foreach ($details as $detail) {
                array_push($numbers,$detail->gamble);
                $data['info']['one_ratio'] = $detail->one_ratio;
                $data['info']['two_ratio'] = $detail->two_ratio;
                $data['info']['three_ratio'] = $detail->three_ratio;
            }
            $data['info']['numbers'] = $numbers;
            
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
        $details = $record->detail;
        $numbers = [];
        foreach ($details as $detail ) {
            array_push($numbers,$detail->gamble);
        }

        //賭盤 
        $game = $record->game;

        //賽程
        $sport = $game->sport;

        //隊伍
        $open_numbers = [];
        $teams = $sport->teams;
        foreach ($teams as $team ) {
            array_push($open_numbers,$team->number);
        }
        if(count($open_numbers) == 0){
            $result = '尚未開獎';
        } else {
            $result = json_encode($open_numbers);
        }

        //類別
        //$category = $sport->category;

        $content = '開獎號碼：<span style="color:green;">'.$result."</span><br>";
        $content .= '<span style="color:red;">'.json_encode($numbers)."</span>";
        $content .= '@[一顆] <span style="color:red;">'.$detail->one_ratio.'</span> / ';
        $content .= '[兩顆] <span style="color:red;">'.$detail->two_ratio.'</span> / ';
        $content .= '[三顆] <span style="color:red;">'.$detail->three_ratio.'</span>';
       
        return $content;
    }


}
