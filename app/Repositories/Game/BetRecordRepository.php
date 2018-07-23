<?php
namespace App\Repositories\Game;

use Doctrine\Common\Collections\Collection;
use App\Models\Sport\SportBetRecord;
use Illuminate\Support\Facades\DB;

class BetRecordRepository
{
    protected $record;
    /**
     * BetRecordRepository constructor.
     *
     * @param SportBetRecord $record
     */
    public function __construct(SportBetRecord $record)
    {
        $this->record = $record;
    }


    /**
     * 依照日期區間回傳列表（給後台）
     * @param $start,$end
     * @return Collection
     */
    public function all($start,$end)
    {
        return $this->record
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 
     * @param $member_id,$start,$end
     * @return Collection
     */
    public function allByMember($member_id,$start,$end)
    {
        return $this->record
                ->where('member_id',$member_id)
                ->whereBetween('created_at', [$start,$end])
                ->get();
    }

    /**
     * 依照id回傳特定資料
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->record->find($id);
    }

    /**
     * 依照下注選項跟賭盤id找到該選項的下注總額
     * @param $gamble_table game_id  $gamble(下注選項)
     * @return total
     */
    public function getBetTotalByGamble($gamble_table,$game_id,$gamble)
    {
        return $this->record
                ->join($gamble_table.' AS D', 'sport_bet_records.id', '=', 'D.sport_bet_record_id')
                ->where('D.gamble',$gamble)
                ->where('sport_bet_records.sport_game_id',$game_id)
                ->select(DB::raw('SUM(sport_bet_records.amount) as total'))->get();
    }



}