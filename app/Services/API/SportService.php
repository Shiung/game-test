<?php
namespace App\Services\API;

use Illuminate\Http\Request;

use App\Models\Account\Account;
use App\Models\Account\TransferAccountRecord;
use App\Models\Account\AccountRecord;
use App\Models\Account\AccountReciveRecord;
use App\Models\Account\AccountRecordTransferRecord;
use App\Models\Parameter;
use App\Models\Member;
use App\Models\Log\AdminActivity;
use App\Models\Sport\Sport;
use App\Models\Sport\SportTeam;
use App\Models\Sport\SportGame;
use App\Models\Sport\SportGameOverUnder;
use App\Models\Sport\SportGameSpread;
use App\Models\Sport\SportGame539;
use App\Models\Sport\SportBetRecord;
use App\Models\Sport\SportBetOverunder;
use App\Models\Sport\SportBetSpread;
use App\Models\Sport\SportBet539;
use App\Models\Sport\SportBetCnChessNum;
use App\Models\Sport\SportBetCnChessColor;
use App\Models\Sport\Sport539Number;
use App\Models\Sport\SportCnChessNumber;
use App\Models\Sport\SportGameCnChessNum;
use App\Models\Sport\SportGameCnChessColor;
use App\Models\Sport\CnChess;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\API\AccountService;
use App\Services\API\PluginService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;


class SportService {

	protected $accountService;
	protected $pluginService;

	public function __construct(AccountService $accountService, PluginService $pluginService)
	{
		$this->accountService = $accountService;
		$this->pluginService = $pluginService;
	}
	

/*

	賽程 賭盤

 */

	//MLB API
	public function fantasyData_MLB($date)
	{

		$ch = curl_init();

		$headers = array(
		    // Request headers
		    'Ocp-Apim-Subscription-Key: a644a3a1d4344019a21609c9eab64d57',
		);
		$url = 'https://api.fantasydata.net/v3/mlb/scores/JSON/GamesByDate/'.$date;

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		//curl_setopt($ch,CURLOPT_HEADER, true);

		$temp = curl_exec($ch);
		$arr = json_decode($temp,true);
		//print_r($arr);
		curl_close($ch);

		//debug
		if(is_array($arr)){
			if(count($arr)>0)
				return array('result'=>1, 'games'=>$arr);
			else
				return array('result'=>0, 'error_code'=>'NULL_GAME', 'error_msg'=>'目前無比賽資料', 'detail'=>null);
		}else{
				return array('result'=>0, 'error_code'=>'ERROR_CRAWLER', 'error_msg'=>'API抓取資料失敗', 'detail'=>null);
		}
	}


	//象棋 新增賽程跟賭盤(排程)
	public function sport_chess_create()
	{
		//開始翻牌時間計算
		$chess_interval = Parameter::where('name','cn_chess_interval')->firstOrFail()->value;
		$now_min = date("i");
		$start_min = $now_min + $chess_interval;
		if($start_min >= 60){
			$start_datetime = date('Y-m-d H:00:00',strtotime('+1 hour'));
		}else{
			$start_datetime = date('Y-m-d H:').$start_min.":00";
		}

		//期別
		$today = date('ymd');
		$last_sport = Sport::where('sport_category_id',4)->orderBy('start_datetime','desc')->first();
		
		if(!is_null($last_sport)){
			$n = explode("-", $last_sport->sport_number);
			if($n[0]!=$today){
				$number = date("ymd")."-001";
			}else{
				$today_number =  preg_replace('/^0*/', '', $n[1]);
				$today_number++;
				$today_number = str_pad($today_number,3,'0',STR_PAD_LEFT);
				$number = date("ymd")."-".$today_number;
			}


		}else{
			$number = $today."-001";
		}

		//新增賽程
		$sport_create = $this->store_sports(4,$start_datetime,$start_datetime,'Scheduled',$number); 
		if($sport_create['result']==0)
			return $sport_create;

		//新增賭盤
		$sport_game_create1 = SportGame::create([
			'sport_id' => $sport_create['sport']->id,
			'bet_status' => 1,
			'processing_status' => 0,
			'type' => 4,
		]);

		$sport_game_create2 = SportGame::create([
			'sport_id' => $sport_create['sport']->id,
			'bet_status' => 1,
			'processing_status' => 0,
			'type' => 5,
		]);

		//新增賭盤詳細資料
		$one_ratio = Parameter::where('name','cn_chess_one_ratio')->firstOrFail()->value;
		$two_ratio = Parameter::where('name','cn_chess_two_ratio')->firstOrFail()->value;
		$virtual_cash_ratio = Parameter::where('name','cn_chess_virtual_cash_ratio')->firstOrFail()->value;
		$share_ratio = Parameter::where('name','cn_chess_share_ratio')->firstOrFail()->value;

		SportGameCnChessNum::create([
				'sport_game_id' => $sport_game_create1->id,
				'one_ratio' => $one_ratio,
				'two_ratio' => $two_ratio,
				'virtual_cash_ratio' => $virtual_cash_ratio,
				'share_ratio' => $share_ratio,
			]);

		$red_ratio = Parameter::where('name','cn_chess_red_ratio')->firstOrFail()->value;
		$black_ratio = Parameter::where('name','cn_chess_black_ratio')->firstOrFail()->value;

		SportGameCnChessColor::create([
				'sport_game_id' => $sport_game_create2->id,
				'red_ratio' => $red_ratio,
				'black_ratio' => $black_ratio,
			]);

		return array('result'=>1, 'sport_game_id'=> [$sport_game_create1->id, $sport_game_create2->id]);;
	}


	//象棋關閉下注+開獎
	public function sport_chess_open_number($sport_id)
	{
		//關閉下注
		try{
			//結束賽程狀態
			$sport = Sport::findOrFail($sport_id);
			$sport->update(['status'=>'Final']);

			//關閉賭局
			$sport_games = $sport->games;
			foreach ($sport_games as $sport_game) {
				$sport_game->update(['bet_status'=>2]);
			}

		}catch(Exception $e){
			return array('result'=>0, 'error_code'=>'CLOSE_ERROR', 'error_msg'=>'象棋關閉下注失敗', 'sport_id'=>$sport_id, 'detail'=>$e->getMessage());

		}

		//開獎
		try{
			$max_num = CnChess::orderBy('id','desc')->firstOrFail();
			$tmp = range(1,$max_num->id);
			$open_nums = array_rand($tmp,5);
			foreach ($open_nums as $open_num) {
				SportCnChessNumber::create([
						'number' => $tmp[$open_num],
						'sport_id' => $sport_id,
					]);
			}

		}catch(Exception $e){
			return array('result'=>0, 'error_code'=>'OPEN_ERROR', 'error_msg'=>'象棋開獎失敗', 'sport_id'=>$sport_id, 'detail'=>$e->getMessage());
		}

		return array('result'=>1);

	}


	//彩球 新增賽程跟賭盤(排程)
	public function sport_539_create()
	{
		//新增賽程
		$sport_starttime_539 = Parameter::where('name','sport_starttime_539')->firstOrFail()->value;
		$start_datetime = date("Y-m-d")." ".$sport_starttime_539;
		$sport_create = $this->store_sports(3,$start_datetime,$start_datetime,'Scheduled'); 
		if($sport_create['result']==0)
			return $sport_create;

		//新增賭盤
		$sport_game_create = SportGame::create([
			'sport_id' => $sport_create['sport']->id,
			'bet_status' => 1,
			'processing_status' => 0,
			'type' => 3,
		]);

		$one_ratio = Parameter::where('name','one_ratio_539')->firstOrFail()->value;
		$two_ratio = Parameter::where('name','two_ratio_539')->firstOrFail()->value;
		$three_ratio = Parameter::where('name','three_ratio_539')->firstOrFail()->value;

		$sport_game_539 = SportGame539::create([
			'sport_game_id' => $sport_game_create->id,
			'one_ratio' => $one_ratio,
			'two_ratio' => $two_ratio,
			'three_ratio' => $three_ratio,
		]);

		return array('result'=>1, 'sport_game_id'=>$sport_game_create->id);
	}


	//彩球 編輯
	public function sport_539_modify($sport_id, $number, $result539)
	{
		$sport = Sport::findOrFail($sport_id);
		$sport->update([
			'sport_number' => $number,
			'status' => 'Final',
		]);
		
		Sport539Number::where('sport_id',$sport_id)->delete();

		foreach ($result539 as $value) {
			Sport539Number::create([
				'number' => $value,
				'sport_id' => $sport->id,
			]);
		}
	}


	//新增賽程表
	public function store_sports($category_id, $start_datetime, $taiwanDateTime, $status, $number=null, $name=null, $sport_id=null)
	{
		//update
		try{
			if(!is_null($number)) //api check update or create
				$sport = Sport::where('sport_number',$number)->where('sport_category_id',$category_id)->firstOrFail();
			else //admin create or update
				$sport = Sport::findOrFail($sport_id);

			$sport->update([
				'start_datetime' => $start_datetime,
				'taiwan_datetime' => $taiwanDateTime,
				'status' => $status,
			]);

		//create
		}catch(Exception $e){
			//echo 'create_new '.$e->getMessage();
			if ($e instanceof ModelNotFoundException) {
				$sport = Sport::create([
					'name' => $name,
					'sport_number' => $number,
					'sport_category_id' => $category_id,
					'start_datetime' => $start_datetime,
					'taiwan_datetime' => $taiwanDateTime,
					'status' => $status,
				]);
			}else{
				return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'更新賽程失敗', 'detail'=>$e->getMessage());
			}
		}

		return array('result'=>1, 'sport'=>$sport);
	}


	//新增賽程隊伍
	public function store_sport_teams($name, $sport_id, $score, $home, $sport_team_id=null)
	{

		//update
		try{
			if(is_null($score))
				$score=0;

			if(is_null($sport_team_id))
				$sport_team = SportTeam::where('sport_id',$sport_id)->where('name',$name)->firstOrFail();
			else
				$sport_team = SportTeam::find($sport_team_id);

			$sport_team->update([
				'score' => $score,
				'name' => $name,
				'home' => $home,
			]);

		//create
		}catch(Exception $e){
			//echo 'create_new '.$e->getMessage();
			if ($e instanceof ModelNotFoundException) {
				$sport_team = SportTeam::create([
					'name' => $name,
					'sport_id' => $sport_id,
					'score' => $score,
					'home' => $home,
				]);
			}else{
				return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'更新隊伍失敗', 'detail'=>$e->getMessage());
			}
		}

		return array('result'=>1, 'sport_team'=>$sport_team);
	}
	

	//新增大小賭盤資料
	public function store_game_overunder($sport_id, $overunder, $real_bet_ratio=null, $home_line=null, $away_line=null, $adjust_line=0, $oneside_bet=null)
	{
		//update
		try{
			$game = SportGame::where('sport_id',$sport_id)->where('type',1)->firstOrFail()->detail;

			$game->update([
				'dead_heat_point' => $overunder,
				'real_bet_ratio' => $real_bet_ratio,
				'home_line' => $home_line,
				'away_line' => $away_line,
				'adjust_line' => $adjust_line,
				'spread_one_side_bet' => $oneside_bet,
			]);

			$overunder_id = $game->id;
		//create
		}catch(Exception $e){
			//echo 'create_new '.$e->getMessage();
			if ($e instanceof ModelNotFoundException) {
				$game = SportGame::create([
					'sport_id' => $sport_id,
					'bet_status' => 0,
					'processing_status' => 0,
					'type' => 1,
				]);

				$game_overunder = SportGameOverUnder::create([
					'sport_game_id' => $game->id,
					'dead_heat_point' => $overunder,
					'real_bet_ratio' => $real_bet_ratio,
					'home_line' => $home_line,
					'away_line' => $away_line,
					'adjust_line' => $adjust_line,
					'spread_one_side_bet' => $oneside_bet,
				]);

				$overunder_id = $game_overunder->id;
			}else{
				return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'更新大小盤失敗', 'detail'=>$e->getMessage());
			}
		}

		return array('result'=>1, 'game_overunder_id'=>$overunder_id);
	}


	//新增讓分賭盤資料
	public function store_game_spread($sport_id, $pointspread, $spread_team, $oneside_bet=null, $real_bet_ratio=null, $home_line=null, $away_line=null, $adjust_line=0)
	{
		//update
		try{
			//echo "update_spread";
			$game = SportGame::where('sport_id',$sport_id)->where('type',2)->firstOrFail()->detail;

			$game->update([
				'dead_heat_point' => $pointspread,
				'real_bet_ratio' => $real_bet_ratio,
				'home_line' => $home_line,
				'away_line' => $away_line,
				'spread_one_side_bet' => $oneside_bet,
				'dead_heat_team_id' => $spread_team,
				'adjust_line' => $adjust_line,
			]);
			$spread_id = $game->id;

		//create
		}catch(Exception $e){
			//echo 'create_new '.$e->getMessage();
			if ($e instanceof ModelNotFoundException) {
				$game = SportGame::create([
					'sport_id' => $sport_id,
					'bet_status' => 0,
					'processing_status' => 0,
					'type' => 2,
				]);

				$game_spread = SportGameSpread::create([
					'sport_game_id' => $game->id,
					'dead_heat_point' => $pointspread,
					'real_bet_ratio' => $real_bet_ratio,
					'home_line' => $home_line,
					'away_line' => $away_line,
					'spread_one_side_bet' => $oneside_bet,
					'dead_heat_team_id' => $spread_team,
					'adjust_line' => $adjust_line,
				]);
				$spread_id = $game_spread->id;
			}else{
				//print_r($e);
				//exit();
				return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'更新讓分盤失敗', 'detail'=>$e->getMessage());
			}
			
		}
		return array('result'=>1, 'game_spread_id'=>$spread_id);


	}


/*

	下注

 */



	//新增下注
	public function create_sport_bet($sport_game_id, $member_id, $account_type, $amount, $bet_type, $gamble, $line)
	{
		//新增下注紀錄
		$account = Account::where('member_id',$member_id)->where('type',$account_type)->firstOrFail();
		$sport_game_detail = SportGame::findOrFail($sport_game_id)->detail;
		$sport_bet = SportBetRecord::create([
			'sport_game_id' => $sport_game_id,
			'member_id' => $member_id,
			'account_id' => $account->id,
			'amount' => $amount,
			'type' => $bet_type,
		]);

		//單號
		$bet_number = date("mdy").str_pad($sport_bet->id, 7, '0', STR_PAD_LEFT);
		
		//判斷賠率
		$bet_line = json_decode($line,1); 

		switch ($bet_type) {
			//大小
			case '1':
				//判斷實際賠率
				if($gamble==0){
					$real_line = $sport_game_detail->away_line + $sport_game_detail->adjust_line;
				}else{
					$real_line = $sport_game_detail->home_line + $sport_game_detail->adjust_line;
				}

				$bet_record = SportBetOverunder::create([
					'sport_bet_record_id' => $sport_bet->id,
					'gamble' => $gamble,
					'dead_heat_point' => $sport_game_detail->dead_heat_point,
					'real_bet_ratio' => $sport_game_detail->real_bet_ratio,
					'line' => $real_line,
				]);

				if($bet_line['line']!=$real_line)
					return array('result'=>0, 'error_code'=>'LINE_CHANGED', 'error_msg'=>'賠率已改變', 'detail'=>$bet_record);

				$bet_number = "OU".$bet_number;
				break;
			
			//讓分
			case '2':
				//判斷實際賠率
				$sport_team = SportTeam::findOrFail($gamble);
				if($sport_team->home==1){
					$real_line = $sport_game_detail->home_line + $sport_game_detail->adjust_line;
				}else{
					$real_line = $sport_game_detail->away_line + $sport_game_detail->adjust_line;
				}

				$bet_record = SportBetSpread::create([
					'sport_bet_record_id' => $sport_bet->id,
					'gamble' => $gamble,
					'dead_heat_point' => $sport_game_detail->dead_heat_point,
					'real_bet_ratio' => $sport_game_detail->real_bet_ratio,
					'line' => $real_line,
					'dead_heat_team_id' => $sport_game_detail->dead_heat_team_id,
				]);

				if($bet_line['line']!=$real_line)
					return array('result'=>0, 'error_code'=>'LINE_CHANGED', 'error_msg'=>'賠率已改變', 'detail'=>$bet_record);

				$bet_number = "SP".$bet_number;
				break;

			//539
			case '3':
				foreach ($gamble as $number) {
					$bet_record = SportBet539::create([
						'sport_bet_record_id' => $sport_bet->id,
						'gamble' => $number,
						'one_ratio' => $sport_game_detail->one_ratio,
						'two_ratio' => $sport_game_detail->two_ratio,
						'three_ratio' => $sport_game_detail->three_ratio,
					]);
				}

				if($bet_line['one_ratio']!=$bet_record->one_ratio || $bet_line['two_ratio']!=$bet_record->two_ratio || $bet_line['three_ratio']!=$bet_record->three_ratio)
					return array('result'=>0, 'error_code'=>'LINE_CHANGED', 'error_msg'=>'賠率已改變', 'detail'=>$bet_record);

				$bet_number = "LF".$bet_number;
				break;

			//象棋數字
			case '4':
				foreach ($gamble as $number) {
					$bet_record = SportBetCnChessNum::create([
						'sport_bet_record_id' => $sport_bet->id,
						'gamble' => $number,
						'one_ratio' => $sport_game_detail->one_ratio,
						'two_ratio' => $sport_game_detail->two_ratio,
						'virtual_cash_ratio' => $sport_game_detail->virtual_cash_ratio,
						'share_ratio' => $sport_game_detail->share_ratio,
					]);
				}

				if($bet_line['one_ratio']!=$bet_record->one_ratio || $bet_line['two_ratio']!=$bet_record->two_ratio || $bet_line['virtual_cash_ratio']!=$bet_record->virtual_cash_ratio || $bet_line['share_ratio']!=$bet_record->share_ratio)
					return array('result'=>0, 'error_code'=>'LINE_CHANGED', 'error_msg'=>'賠率已改變', 'detail'=>$bet_record);

				$bet_number = "CN".$bet_number;
				break;

			//象棋紅黑
			case '5':
				$bet_record = SportBetCnChessColor::create([
					'sport_bet_record_id' => $sport_bet->id,
					'gamble' => $gamble,
					'red_ratio' => $sport_game_detail->red_ratio,
					'black_ratio' => $sport_game_detail->black_ratio,
				]);
				
				if($bet_line['red_ratio']!=$bet_record->red_ratio || $bet_line['black_ratio']!=$bet_record->black_ratio)
					return array('result'=>0, 'error_code'=>'LINE_CHANGED', 'error_msg'=>'賠率已改變', 'detail'=>$bet_record);

				$bet_number = "CC".$bet_number;
				break;

			default:
				# code...
				break;
		}

		//更新單號
		$sport_bet->update([
			'bet_number' => $bet_number,
		]);

		//繳交下注的錢
		$description = '#'.$sport_bet->bet_number.' 進行下注';
		$transfer = $this->accountService->transfer($member_id,null,$account_type,$amount,0,4,$description);
		if($transfer['result']==0)
			return $transfer;

		return array('result'=>1, 'sport_bet_record_id' => $sport_bet->id);
	}


	//關閉下注
	public function bet_close()
	{
		$sport_games = SportGame::whereIn('bet_status',[0,1])->whereIn('type',[1,2,3])->get();
		$ids = [];

		foreach ($sport_games as $sport_game) {
			$start_datetime = $sport_game->sport->taiwan_datetime;
			$close_mins = Parameter::where('name','bet_status_closetime')->firstOrFail()->value;
			$period_seconds = $close_mins*60;
			$expire = $this->pluginService->bet_closetime_check($period_seconds, $start_datetime);

			//過期關閉下注
			if($expire['status']==1){
				$sport_game->update([
					'bet_status' => 2,
				]);
				array_push($ids, $sport_game->id);
			}
		}

		return $ids;

	}


	//檢查賭盤是否有下注
	public function check_bet_in_game($sport_game_id)
	{
		$game = SportGame::findOrFail($sport_game_id);
		$bets = $game->bets;
		if($bets->isEmpty())
			return 0;
		else
			return 1;
	}


	//檢查大小讓分下注的單邊下注值
	public function check_oneside_bet($sport_game_id,$bet_amount,$bet_team_id)
	{
		try{
			$game = SportGame::find($sport_game_id);
			$oneside_bet = $game->detail->spread_one_side_bet;

			if(!is_null($oneside_bet)){

				//讓分
				if($game->type==2){
					$diff_bets = SportBetRecord::where('sport_game_id',$sport_game_id)
											->join('sport_bet_spreads','sport_bet_records.id','=','sport_bet_spreads.sport_bet_record_id')
											->groupBy('gamble')
											->select(DB::raw('SUM(amount) as amount, gamble'))
											->get();
				//大小
				}else if($game->type==1){
					$diff_bets = SportBetRecord::where('sport_game_id',$sport_game_id)
											->join('sport_bet_overunders','sport_bet_records.id','=','sport_bet_overunders.sport_bet_record_id')
											->groupBy('gamble')
											->select(DB::raw('SUM(amount) as amount, gamble'))
											->get();
				}

				//變數初始化
				$diff_amount = 0;
				$bet_team_bet_amount = 0;
				$other_team_bet_amount = 0;
				
				//print_r($diff_bets);
				foreach ($diff_bets as $diff_bet) {
					$diff_amount = $diff_bet->amount - $diff_amount;
					$diff_amount = abs($diff_amount);

					//下注單的下注隊伍的下注總額
					if($diff_bet->gamble == $bet_team_id){
						$bet_team_bet_amount = $diff_bet->amount;
					//非下注隊伍的下注總額
					}else{
						$other_team_bet_amount = $diff_bet->amount;
					}
				}

				
				//可以下注 (在下注額比較高的隊伍,最多可以下 單邊下注值-差額)
				if($bet_amount <= ($oneside_bet - $diff_amount) && $bet_team_bet_amount >= $other_team_bet_amount){
					return array('result'=>1, 'bet_status'=>1, 'bet_amount'=>($oneside_bet - $diff_amount));

				//可以下注 (在下注額比較少的隊伍,最多可以下 單邊下注值+差額)
				}else if($bet_amount <= ($oneside_bet + $diff_amount) && $bet_team_bet_amount < $other_team_bet_amount){
					return array('result'=>1, 'bet_status'=>1, 'bet_amount'=>($oneside_bet - $diff_amount));

				//不可下注
				}else{
					return array('result'=>1, 'bet_status'=>0, 'bet_amount'=>($oneside_bet - $diff_amount));
				}

			}else{
				return array('result'=>1, 'bet_status'=>1);
			}
		}catch (Exception $e){
			return array('result'=>0, 'error_code'=>'ONESIDE_BET_CHECK_ERROR', 'error_msg'=>'單邊下注限制判斷失敗', 'detail'=>$e->getMessage());
		}

		
	}

}