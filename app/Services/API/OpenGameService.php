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
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\API\AccountService;
use App\Services\API\PluginService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;


class OpenGameService {

	protected $accountService;
	protected $pluginService;

	public function __construct(AccountService $accountService, PluginService $pluginService)
	{
		$this->accountService = $accountService;
		$this->pluginService = $pluginService;
	}


	//開單一賭盤 status = Canceled / Postponed
	public function open_game_cancel($sport_game_id)
	{
		//更改開盤狀態 開盤計算中
		$sport_game = SportGame::findOrFail($sport_game_id);
		$sport_game->update([
			'processing_status' => 1,
		]);

		//找出該賭盤的所有下注
		$bet_records = $sport_game->bets;
		foreach ($bet_records as $bet_record) {
			//return bet money
			$r = $this->bet_record_cancel($bet_record);
			if($r['result']==0)
				return $r;
		}

		//賭盤開盤結束
		$sport_game->update([
			'processing_status' => 2,
			'bet_status' => 3,
		]);

		return array('result'=>1);
	}
	

	//開單一賭盤 status = Final
	public function open_game_final($sport_game_id)
	{
		//更改開盤狀態 開盤計算中
		$sport_game = SportGame::findOrFail($sport_game_id);
		$sport_game->update([
			'processing_status' => 1,
		]);
		$game = $sport_game->detail;

		//找出比賽分數
		$team_score = [];
		$teams = $sport_game->sport->teams;
		foreach ($teams as $team) {
			$team_score["id"][$team->home] = $team->id;
			$team_score["score"][$team->home] = $team->score;
		}

		//找出彩球結果
		$result539 = $sport_game->sport->numbers_539;

		//找出象棋結果
		$result_chesses = $sport_game->sport->numbers_chess;

		//找出該賭盤的所有下注
		$bet_records = $sport_game->bets;
		foreach ($bet_records as $bet_record) {

			//讓分或大小 輸贏判斷
			switch ($bet_record->type) {

				//大小
				case '1':
					$sum_score = array_sum($team_score["score"]);
					$bet_detail = $bet_record->detail; //下注的賠率參數

					//平局
					if($sum_score == $bet_detail->dead_heat_point){
						//有效下注額
						$real_bet_amount = $bet_record->amount * abs($bet_detail->real_bet_ratio);

						if($bet_detail->real_bet_ratio >= 0){ //大贏
							$r = $this->bet_record_bonus($bet_record, $real_bet_amount, 1, $bet_detail->line);
							if($r['result']==0)
								return $r;
						}else{ //小贏
							$r = $this->bet_record_bonus($bet_record, $real_bet_amount, 0, $bet_detail->line);
							if($r['result']==0)
								return $r;
						}

					//大贏
					}else if($sum_score > $bet_detail->dead_heat_point){
						$r = $this->bet_record_bonus($bet_record, $bet_record->amount, 1, $bet_detail->line);
						if($r['result']==0)
								return $r;

					//小贏
					}else{
						$r = $this->bet_record_bonus($bet_record, $bet_record->amount, 0, $bet_detail->line);
						if($r['result']==0)
								return $r;
					}

					break;
				
				//讓分
				case '2':
					$bet_detail = $bet_record->detail; //下注的賠率參數
					//讓分調整
					foreach ($team_score["id"] as $key => $team_id) {
						if($team_id == $bet_detail->dead_heat_team_id){
							$keyteam_score = $team_score["score"][$key] - $bet_detail->dead_heat_point;
							$keyteam_id = $team_id;
						}else{
							$otherteam_score = $team_score["score"][$key];
							$otherteam_id = $team_id;
						}
					}
					//echo $keyteam_score." ".$otherteam_score." ".$keyteam_id." ".$otherteam_id."/".$bet_detail->dead_heat_team_id."/";

					//平局
					if($keyteam_score == $otherteam_score){
						//有效下注額
						$real_bet_amount = $bet_record->amount * abs($bet_detail->real_bet_ratio);

						if($bet_detail->real_bet_ratio >= 0){ //key贏
							$r = $this->bet_record_bonus($bet_record, $real_bet_amount, $keyteam_id, $bet_detail->line);
							if($r['result']==0)
								return $r;
						}else{ //other win
							$r = $this->bet_record_bonus($bet_record, $real_bet_amount, $otherteam_id, $bet_detail->line);
							if($r['result']==0)
								return $r;
						}

					//key_team win
					}else if ($keyteam_score > $otherteam_score) {
						$r = $this->bet_record_bonus($bet_record, $bet_record->amount, $keyteam_id, $bet_detail->line);
						if($r['result']==0)
							return $r;

					//other_team win
					}else{
						$r = $this->bet_record_bonus($bet_record, $bet_record->amount, $otherteam_id, $bet_detail->line);
						if($r['result']==0)
							return $r;

					}

					break;

				//彩球
				case '3':
					$bet_details = $bet_record->detail; //彩球下注內容(號碼)
					$open_numbers = 0; //中的數量
					$real_bet_amount = $bet_record->amount; //有效下注額

					foreach ($bet_details as $bet_detail) {
						$check = $result539->where('number',$bet_detail->gamble);
						//中獎了
						if(!$check->isEmpty()){
							$open_numbers++;
						}
					}

					$r = $this->bet_record_bonus_539($bet_record, $real_bet_amount, $open_numbers);
					if($r['result']==0)
						return $r;

					break;

				//象棋大小
				case '4':
					//象棋號碼
					$chess_num = [];
					foreach ($result_chesses as $result_chess) {
						array_push($chess_num, $result_chess->number);
					}
					$r = $this->bet_record_bonus_chess_num($bet_record, $chess_num);
					if($r['result']==0)
						return $r;
					break;

				//象棋紅黑
				case '5':
					$red=0;
					$black=0;
					
					foreach ($result_chesses as $result_chess) {
						$color = $result_chess->chess->color;
						if($color==0)
							$red++;
						else
							$black++;
					}
					
					if($red>$black)
						$r = $this->bet_record_bonus_chess_color($bet_record, 0);
					else
						$r = $this->bet_record_bonus_chess_color($bet_record, 1);

					if($r['result']==0)
						return $r;

					break;
				
				default:
					# code...
					break;
			}
		}//下注foreach

		//賭盤開盤結束
		$sport_game->update([
			'processing_status' => 2,
			'bet_status' => 3,
		]);

		return array('result'=>1);
	}








	//計算結果 for cancel
	public function bet_record_cancel($bet_record)
	{
		try{
			//更新下注結果
			$bet_record->update([
				'real_bet_amount' => 0,
				'result_amount' => 0,
			]);

			//退錢	
			$account_type = $bet_record->account->type;
			$description = '#'.$bet_record->bet_number.' 賭盤取消,退回下注額';
			$transfer_result = $this->accountService->transfer(null,$bet_record->member_id,$account_type,$bet_record->amount,0,4,$description);
			if($transfer_result['result']==0)
				return $transfer_result;

		}catch(Exception $e){
			return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'bet return computing failed', 'detail'=>$e->getMessage());
		}

		return array('result'=>1);
	}


	//計算下注結果 for sport
	public function bet_record_bonus($bet_record, $real_bet_amount, $winner, $line)
	{
		try{
			//下注幣別
			$account_type = $bet_record->account->type;

			//輸贏boolean
			$win = null;

			//贏
			if($bet_record->detail->gamble == $winner){
				$result_amount = floor($real_bet_amount*$line);
				$win = 1;
			//輸
			}else{
				$result_amount = -$real_bet_amount;
				$win = 0;
				//權利馬要轉給專屬權利馬
				if($account_type==3){
					$description = '#'.$bet_record->bet_number.' 輸局,退回娛樂幣有效下注額';
					$transfer_result = $this->accountService->transfer(null,$bet_record->member_id,5,$real_bet_amount,0,12,$description);
					if($transfer_result['result']==0)
					return $transfer_result;
				}
			}

			//更新下注結果
			$bet_record->update([
				'real_bet_amount' => $real_bet_amount,
				'result_amount' => $result_amount,
			]);

			//匯錢
			/////有效下注退款 only for 金幣＆娛樂幣
			if($account_type==1 || $account_type==3){
				if($bet_record->amount - $real_bet_amount > 0){
					$return_money = $bet_record->amount - $real_bet_amount;
					$description = '#'.$bet_record->bet_number.' 有效下注退款:'.$bet_record->amount.'-'.$real_bet_amount.'='.$return_money;

					$transfer_result = $this->accountService->transfer(null,$bet_record->member_id,$bet_record->account->type,$return_money,0,4,$description);
					if($transfer_result['result']==0)
						return $transfer_result;
				}
			}

			/////贏給錢
			if($win == 1){
				//退回本金
				if($account_type==1 || $account_type==3){
					$description = '#'.$bet_record->bet_number.' 贏局,退回有效下注額';
					$transfer_result = $this->accountService->transfer(null,$bet_record->member_id,$account_type,$real_bet_amount,0,4,$description);
					if($transfer_result['result']==0)
					return $transfer_result;
				}
				//給贏的錢
				$description = '#'.$bet_record->bet_number.' 贏局,給予遊戲結果金幣:'.$real_bet_amount.'*'.$line.'='.$result_amount;
				$transfer_result = $this->accountService->transfer(null,$bet_record->member_id,1,$result_amount,0,4,$description);
				if($transfer_result['result']==0)
					return $transfer_result;
			}

		}catch(Exception $e){
			return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'OU/SP bet result computing failed', 'detail'=>$e->getMessage());

		}
		return array('result'=>1);
		
	}


	//計算下注結果 for 539
	public function bet_record_bonus_539($bet_record, $real_bet_amount, $win_numbers, $bet_number=3)
	{
		try{
			//下注幣別
			$account_type = $bet_record->account->type;
			
			//輸贏boolean
			$win = null;

			//lose
			if($win_numbers==0){
				$result_amount = -$real_bet_amount;
				$win=0;

				//權利馬要轉給專屬權利馬
				if($account_type==3){
					$description = '#'.$bet_record->bet_number.' 輸局,退回娛樂幣有效下注額';
					$transfer_result = $this->accountService->transfer(null,$bet_record->member_id,5,$real_bet_amount,0,12,$description);
					if($transfer_result['result']==0)
					return $transfer_result;
				}

			//win
			}else{

				$bet_line = $bet_record->detail->first();
				$win = 1;
				
				switch ($win_numbers) {
					case '1':
						$line = $bet_line->one_ratio;
						break;
					case '2':
						$line = $bet_line->two_ratio;
						break;
					case '3':
						$line = $bet_line->three_ratio;
						break;
					default:
						# code...
						break;
				}
				$result_amount = floor($real_bet_amount*$line);
				
			}

			//更新下注結果
			$bet_record->update([
				'real_bet_amount' => $real_bet_amount,
				'result_amount' => $result_amount,
			]);

			//匯錢
			/////贏給錢
			if($win==1){
				//退回本金
				if($account_type==1 || $account_type==3){
					$description = '#'.$bet_record->bet_number.' 贏局,退回有效下注額';
					$transfer_result = $this->accountService->transfer(null,$bet_record->member_id,$account_type,$real_bet_amount,0,4,$description);
					if($transfer_result['result']==0)
					return $transfer_result;
				}
				//給贏的錢
				$description = '#'.$bet_record->bet_number.' 贏局,給予遊戲結果金幣:'.$real_bet_amount.'*'.$line.'='.$result_amount;
				$transfer_result = $this->accountService->transfer(null,$bet_record->member_id,1,$result_amount,0,4,$description);
				if($transfer_result['result']==0)
					return $transfer_result;
			}

		}catch(Exception $e){
			return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'539 bet result computing failed', 'detail'=>$e->getMessage());

		}
		return array('result'=>1);
		
	}


	//計算象棋 數字
	public function bet_record_bonus_chess_num($bet_record, $chess_num)
	{
		try{
			$bet_details = $bet_record->detail;
			$win_numbers = 0; //中獎號碼數
			$win = 0; //輸贏判斷
			$real_bet_amount = $bet_record->amount; //有效下注		
			$account_type = $bet_record->account->type; //下注幣別

			//check 中獎
			foreach ($bet_details as $bet_detail) {
				if (in_array($bet_detail->gamble, $chess_num))
					$win_numbers++;
			}

			//lose
			if ($win_numbers==0) {
				$result_amount = -$real_bet_amount;

				//權利馬要轉給專屬權利馬
				if($account_type==3){
					$description = '#'.$bet_record->bet_number.' 輸局,退回娛樂幣有效下注額';
					$transfer_result = $this->accountService->transfer(null,$bet_record->member_id,5,$real_bet_amount,0,12,$description);
					if($transfer_result['result']==0)
					return $transfer_result;
				}

			//win
			}else{
				$win = 1;
				
				//賠率
				switch ($win_numbers) {
					case '1':
						$line = $bet_detail->one_ratio;
						break;
					case '2':
						$line = $bet_detail->two_ratio;
						//金幣加成
						if ($account_type==1)
							$line = $line+$bet_detail->virtual_cash_ratio;
						//娛樂幣加成
						if ($account_type==3)
							$line = $line+$bet_detail->share_ratio;
						break;
					default:
						# code...
						break;
				}

				//計算輸贏
				$result_amount = floor($real_bet_amount*$line);

				//金幣娛樂 退回本金
				if($account_type==1 || $account_type==3){
					$description = '#'.$bet_record->bet_number.' 贏局,退回有效下注額';
					$transfer_result = $this->accountService->transfer(null,$bet_record->member_id,$account_type,$real_bet_amount,0,4,$description);
					if($transfer_result['result']==0)
					return $transfer_result;
				}
				//給贏的錢
				$description = '#'.$bet_record->bet_number.' 贏局,給予遊戲結果金幣:'.$real_bet_amount.'*'.$line.'='.$result_amount;
				$transfer_result = $this->accountService->transfer(null,$bet_record->member_id,1,$result_amount,0,4,$description);
				if($transfer_result['result']==0)
					return $transfer_result;
			
			}

			//更新下注結果
			$bet_record->update([
				'real_bet_amount' => $real_bet_amount,
				'result_amount' => $result_amount,
			]);

		}catch (Exception $e) {
			return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'chess_num bet result computing failed', 'detail'=>$e->getMessage());
		}
		return array('result'=>1);
	}


	//計算象棋 紅黑
	public function bet_record_bonus_chess_color($bet_record, $chess_color)
	{
		try{
			$bet_detail = $bet_record->detail;
			$win_numbers = 0; //中獎號碼數
			$win = 0; //輸贏判斷
			$real_bet_amount = $bet_record->amount; //有效下注		
			$account_type = $bet_record->account->type; //下注幣別

			//lose
			if ($bet_detail->gamble != $chess_color) {
				$result_amount = -$real_bet_amount;

				//權利馬要轉給專屬權利馬
				if($account_type==3){
					$description = '#'.$bet_record->bet_number.' 輸局,退回娛樂幣有效下注額';
					$transfer_result = $this->accountService->transfer(null,$bet_record->member_id,5,$real_bet_amount,0,12,$description);
					if($transfer_result['result']==0)
					return $transfer_result;
				}

			//win
			}else{
				$win = 1;
				
				//賠率
				switch ($chess_color) {
					case '0':
						$line = $bet_detail->red_ratio;
						break;
					case '1':
						$line = $bet_detail->black_ratio;
						break;
					default:
						# code...
						break;
				}

				//計算輸贏
				$result_amount = floor($real_bet_amount*$line);

				//金幣娛樂 退回本金
				if($account_type==1 || $account_type==3){
					$description = '#'.$bet_record->bet_number.' 贏局,退回有效下注額';
					$transfer_result = $this->accountService->transfer(null,$bet_record->member_id,$account_type,$real_bet_amount,0,4,$description);
					if($transfer_result['result']==0)
					return $transfer_result;
				}
				//給贏的錢
				$description = '#'.$bet_record->bet_number.' 贏局,給予遊戲結果金幣:'.$real_bet_amount.'*'.$line.'='.$result_amount;
				$transfer_result = $this->accountService->transfer(null,$bet_record->member_id,1,$result_amount,0,4,$description);
				if($transfer_result['result']==0)
					return $transfer_result;
			
			}

			//更新下注結果
			$bet_record->update([
				'real_bet_amount' => $real_bet_amount,
				'result_amount' => $result_amount,
			]);

		}catch (Exception $e) {
			return array('result'=>0, 'error_code'=>'DB_ERROR', 'error_msg'=>'chess_color bet result computing failed', 'detail'=>$e->getMessage());
		}
		return array('result'=>1);
	}


}