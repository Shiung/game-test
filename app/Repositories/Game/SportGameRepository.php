<?php
namespace App\Repositories\Game;

use Doctrine\Common\Collections\Collection;
use App\Models\Sport\SportGame;

class SportGameRepository
{
    protected $game;
    /**
     * GameRepository constructor.
     *
     * @param Game $game
     */
    public function __construct(SportGame $game)
    {
        $this->game = $game;
    }

    /**
     * 依照日期區間回傳列表（給後台）
     * @param $category_id,$status,$start,$end
     * @return Collection
     */
    public function all($category_id,$status,$start = null,$end = null)
    {
        if($start && $end ){
            return $this->game
                    ->join('sports', function($join) use($category_id)
                    {
                        $join->on('sports.id', '=', 'sport_games.sport_id')
                              ->where('sports.sport_category_id','=',$category_id);
                    })
                    ->where('sport_games.bet_status', 'LIKE', $status)
                    ->whereBetween('sport_games.created_at', [$start,$end])
                     ->select('sport_games.*')
                    ->get();
            
        } else {
            return $this->game
                    ->join('sports', function($join)use($category_id)
                    {
                        $join->on('sports.id', '=', 'sport_games.sport_id')
                             ->where('sports.sport_category_id','=',$category_id);
                    })
                    ->where('sport_games.bet_status', 'LIKE', $status)
                    
                    ->get();
        }
        
    }


    /**
     * 依照id回傳特定資料
     * @param id
     * @return Collection
     */
    public function find($id)
    {
        return $this->game->find($id);
    }



}