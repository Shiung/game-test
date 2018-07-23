<?php
namespace App\Services\API;

use Illuminate\Http\Request;

use App\Models\Account\Account;
use App\Models\Account\TransferAccountRecord;
use App\Models\Account\AccountRecord;
use App\Models\Account\AccountReceiveRecord;
use App\Models\Account\AccountRecordTransferRecord;
use App\Models\Parameter;
use App\Models\Member;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\MemberLevelRecord;
use App\Models\Tree;
use App\Models\Shop\ProductMemberLevel;
use App\Models\Sport\SportBetRecord;
use App\Models\Sport\SportGame;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\API\PluginService;
use App\Services\API\AccountService;
use App\Services\API\RoleService;
use App\Services\API\TreeService;
use Exception;
use Validator;
use DB;


class StatService {


	//象棋單一局統計
	public function chess_bet_one($user_id, $sport_id)
	{
		//find game id
		$games = SportGame::where('sport_id',$sport_id)->get();
		$game_ids = [];
		foreach ($games as $game) {
			array_push($game_ids, $game->id);
		}

		//sum of sport_bet_record
		$sum = SportBetRecord::whereIn('sport_game_id',$game_ids)->where('sport_bet_records.member_id',$user_id)
							->join('accounts','accounts.id','=','sport_bet_records.account_id')
							->groupBy('accounts.type')
							->select(DB::raw('sum(result_amount) as sum_result, accounts.type as account_type'))
							->get();

		return $sum;

	}

	
	//領取中心統計
	public function receive_center($start_datetime, $end_datetime, $record_types, $account_types,$member_ids=null)
	{
		$receive = AccountRecord::where('account_records.created_at','>=',$start_datetime)
		                        ->where('account_records.created_at','<',$end_datetime)
		                        ->join('accounts','accounts.id','=','account_records.account_id')
		                        ->whereIn('account_records.type',$record_types)
		                        ->whereIn('accounts.type',$account_types);
		if(!is_null($member_ids))
			$receive = $receive->whereIn('accounts.member_id',$member_ids);

		$receive = $receive->select(DB::raw('sum(account_records.amount) as amount'))->first();

		return $receive;                        
	}


	//賭盤日統計
	public function bet_game_record($startdate, $enddate, $period_type)
	{

		$end_date = date("Y-m-d", strtotime($enddate. "-1 day"));
		try{
			$stat = DB::select("select sum(sport_bet_records.amount) as st_amount, 
							count(*) as st_count, 
							sum(sport_bet_records.real_bet_amount) as st_real_bet_amount, 
							sum(sport_bet_records.result_amount) as st_result_amount,
							DATE(sport_bet_records.created_at) as stday
							from `sport_bet_records` 

							inner join `accounts` on `sport_bet_records`.`account_id` = `accounts`.`id` inner join `sport_games` on `sport_bet_records`.`sport_game_id` = `sport_games`.`id` inner join `sports` on `sport_games`.`sport_id` = `sports`.`id` 

 							where `sport_bet_records`.`created_at` >= '".$startdate."' and `sport_bet_records`.`created_at` < '".$enddate."' group by `stday` order by `stday` asc");

        }catch(Exception $e){
        	print_r($e->getMessage());
        }
        //print_r($stat);
        //echo "123";
        $statarray = $this->stat_game($startdate, $end_date, $period_type, $stat);
        return $statarray;
	}


	//日月週統計for賭盤 $stat =>Ｎ個欄位 stcount, stday
	public function stat_game($startdate,$enddate,$type,$stat){
        //print_r($stat);
        $datediff = floor((strtotime($enddate) - strtotime($startdate))/(60*60*24));
        for($i=0;$i<=$datediff;$i++){
            $key = date("Y-m-d", strtotime($startdate." + ".$i."day"));

            //day array
            $day[$key] = [
            		'amount' => 0,
            		'count' => 0,
            		'real_bet_amount' => 0,
            		'result_amount' =>0,
            	];

            $date = explode("-", $key);
            $m = $date[0]."-".$date[1];

            //month array
            $month[$m] = [
            		'amount' => 0,
            		'count' => 0,
            		'real_bet_amount' => 0,
            		'result_amount' =>0,
            	];

           	//year array
            $year[$date[0]] = [
            		'amount' => 0,
            		'count' => 0,
            		'real_bet_amount' => 0,
            		'result_amount' =>0,
            	];

            //week
            $weeknumber = date("W",strtotime($key));
            $weekday = date("Y-m-d",strtotime($date[0]."W".$weeknumber."1"));

            //week array
            $week[$weekday] = [
            		'amount' => 0,
            		'count' => 0,
            		'real_bet_amount' => 0,
            		'result_amount' =>0,
            	];
        }
       
        foreach($stat as $val){
            $date = explode("-", $val->stday);
            $m = $date[0]."-".$date[1]; 

            if(isset($day[$val->stday])){   
       
	            $day[$val->stday] = [
	            		'amount' => $val->st_amount,
	            		'count' => $val->st_count,
	            		'real_bet_amount' => $val->st_real_bet_amount,
	            		'result_amount' =>$val->st_result_amount, 
	            	];

	            $month[$m]['amount'] += $val->st_amount;
				$month[$m]['count'] += $val->st_count;
				$month[$m]['real_bet_amount'] += $val->st_real_bet_amount;
				$month[$m]['result_amount'] += $val->st_result_amount;

	            $year[$date[0]]['amount'] += $val->st_amount;
	            $year[$date[0]]['count'] += $val->st_count;
	            $year[$date[0]]['real_bet_amount'] += $val->st_real_bet_amount;
	            $year[$date[0]]['result_amount'] += $val->st_result_amount;

	            //week
	            $weeknumber = date("W",strtotime($val->stday));
	            $weekday = date("Y-m-d",strtotime($date[0]."W".$weeknumber."1"));

	            $week[$weekday]['amount'] += $val->st_amount;
	            $week[$weekday]['count'] += $val->st_count;
	            $week[$weekday]['real_bet_amount'] += $val->st_real_bet_amount;
	            $week[$weekday]['result_amount'] += $val->st_result_amount;
        	}
        }
        
        switch ($type) {
            case "d":
                return $day;
                break;
            case "m":
                return $month;
                break;
            case "y":
                return $year;
                break;
            case "w":
                return $week;
                break;
            default:
                return $day;
                break;
        }
    }


	//下注統計
	public function bet_record($start_date, $end_date, $member_ids=null, $bet_type='all', $account_type='all', $sport_type='all')
	{
		$records = DB::table('sport_bet_records')
					    ->join('accounts','sport_bet_records.account_id','=','accounts.id')
					    ->join('sport_games','sport_bet_records.sport_game_id','=','sport_games.id')
					    ->join('sports','sport_games.sport_id','=','sports.id')
					    ->join('members','members.user_id','=','sport_bet_records.member_id')
					    ->join('users','users.id','=','sport_bet_records.member_id')
					    ->where('sport_bet_records.created_at','>=',$start_date)
					    ->where('sport_bet_records.created_at','<',$end_date);

		if(!is_null($member_ids))
			$records = $records->whereIn('sport_bet_records.member_id',$member_ids);

		if($bet_type!='all')
			$records = $records->where('sport_bet_records.type',$bet_type);

		if($account_type!='all')
			$records = $records->where('accounts.type',$account_type);

		if($sport_type!='all')
			$records = $records->where('sports.sport_category_id',$sport_type);


		$records = $records->select(DB::raw('sport_games.id as game_id, sports.id as sport_id, sport_bet_records.id as bet_id, sport_bet_records.bet_number as bet_number, sport_bet_records.member_id as member_id, sport_bet_records.amount as amount, sport_bet_records.real_bet_amount as real_bet_amount, sport_bet_records.result_amount as result_amount, sport_bet_records.type as bet_type, accounts.type as account_type, sports.sport_category_id as sport_type, sport_bet_records.created_at as created_at, members.name as name, users.username as username'));

		return $records;
	}


	//區間計算
	public function period_date($type)
	{
		switch ($type) {

			case 'last_month':
				$start_date = date("Y-m-d", strtotime("first day of last month"));
				$end_date = date("Y-m")."-01";
				break;
			
			case 'this_month':
				$start_date = date("Y-m")."-01";
				$end_date = date("Y-m-d", strtotime("first day of next month"));
				break;

			case 'last_week':
				$this_week = date("W");
				$last_week = date("W", strtotime("-1 weeks"));
				$this_year = date("Y");
				if($last_week > $this_week)
					$last_year = $this_year-1;
				else
					$last_year = $this_year;

				$start_date = date("Y-m-d", strtotime($last_year."W".$last_week));
				$end_date = date("Y-m-d", strtotime($this_year."W".$this_week));
				break;

			case 'this_week':
				$this_week = date("W");
				$next_week = date("W", strtotime("+1 weeks"));
				$this_year = date("Y");
				if($next_week < $this_week)
					$next_year = $this_year+1;
				else
					$next_year = $this_year;

				$start_date = date("Y-m-d", strtotime($this_year."W".$this_week));
				$end_date = date("Y-m-d", strtotime($next_year."W".$next_week));
				break;

			case 'yesterday':
				$start_date = date("Y-m-d",strtotime("-1 days"));
				$end_date = date("Y-m-d");
				break;

			case 'today':
				$start_date = date("Y-m-d");
				$end_date = date("Y-m-d",strtotime("+1 days"));
				break;

			default:
				# code...
				break;
		}

		return ['start_date'=>$start_date, 'end_date'=>$end_date];
	}


	//商城營收 日月週
	public function product_date($startdate, $enddate, $period_type)
	{
		$sql = "sum(amount)";
		$end_date = date("Y-m-d", strtotime($enddate. "-1 day"));
		$stat = AccountRecord::select(DB::raw($sql." as stcount,DATE(created_at) as stday"))
							->where('created_at','>=',$startdate)->where('created_at','<',$enddate)
		                    ->where('type',7)
		                    ->groupBy("stday")
                            ->orderBy('stday', 'asc')
                  			->get();
        //print_r($stat);
        $statarray = $this->stat($startdate, $end_date, $period_type, $stat);
        return $statarray;
	}


	//經營 利息幣支出 日月週
	public function receive_center_date($startdate, $enddate, $period_type, $record_types, $account_types)
	{
		$end_date = date("Y-m-d", strtotime($enddate. "-1 day"));
		$stat = AccountRecord::select(DB::raw("sum(account_records.amount) as stcount,DATE(account_records.created_at) as stday"))
							->where('account_records.created_at','>=',$startdate)
		                    ->where('account_records.created_at','<',$enddate)
		                    ->join('accounts','accounts.id','=','account_records.account_id')
		                    ->whereIn('account_records.type',$record_types)
		                    ->whereIn('accounts.type',$account_types)
		                    ->groupBy("stday")
                            ->orderBy('stday', 'asc')
                  			->get();

        $statarray = $this->stat($startdate, $end_date, $period_type, $stat);
        return $statarray;
	}


	//各項統計group by member
	public function receive_center_member($startdate, $enddate, $record_types, $account_types)
	{
		$stat = AccountRecord::select(DB::raw("member_id, members.name as name, sum(account_records.amount) as stcount"))
							->where('account_records.created_at','>=',$startdate)
		                    ->where('account_records.created_at','<',$enddate)
		                    ->join('accounts','accounts.id','=','account_records.account_id')
		                    ->join('members','members.user_id','=','accounts.member_id')
		                    ->whereIn('account_records.type',$record_types)
		                    ->whereIn('accounts.type',$account_types)
		                    ->groupBy("accounts.member_id")
                  			->get();
        return $stat;
	}


	//日月週統計 $stat =>兩個欄位 stcount, stday
	public function stat($startdate,$enddate,$type,$stat){
        //print_r($stat);
        $datediff = floor((strtotime($enddate) - strtotime($startdate))/(60*60*24));
        for($i=0;$i<=$datediff;$i++){
            $key = date("Y-m-d", strtotime($startdate." + ".$i."day"));
            $day[$key]=0;
            $date = explode("-", $key);
            $m = $date[0]."-".$date[1];
            $month[$m]=0;
            $year[$date[0]]=0;
            //week
            $weeknumber = date("W",strtotime($key));
            $weekday = date("Y-m-d",strtotime($date[0]."W".$weeknumber."1"));
            $week[$weekday] = 0;
        }
       
        foreach($stat as $val){
            $date = explode("-", $val->stday);
            $m = $date[0]."-".$date[1];    
       
            $day[$val->stday] = $val->stcount;               
            $month[$m] += $val->stcount;
            $year[$date[0]] += $val->stcount;
            //week
            $weeknumber = date("W",strtotime($val->stday));
            $weekday = date("Y-m-d",strtotime($date[0]."W".$weeknumber."1"));
            $week[$weekday] += $val->stcount;
        }
        
        switch ($type) {
            case "d":
                return $day;
                break;
            case "m":
                return $month;
                break;
            case "y":
                return $year;
                break;
            case "w":
                return $week;
                break;
            default:
                return $day;
                break;
        }
    }
}