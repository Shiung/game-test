<?php
namespace App\Presenters\Game;

use App\Models\Sport\Sport;
use App\Models\Sport\SportGame;
use App\Services\Game\CategoryService;
use App\Services\Game\Sport\SportGameService;
use App\Services\Game\Sport\SportService;

class SportPresenter
{

    protected $categoryService;
    protected $sportService;
    protected $sportGameService;
    //球類遊戲的賭盤類型代號
    protected $game_types = [1,2];

    /**
     * SportPresenter constructor.
     *
     * @param 
     */
    public function __construct(
        CategoryService $categoryService,
        SportGameService $sportGameService,
        SportService $sportService
    ) {
        $this->categoryService = $categoryService;
        $this->sportGameService = $sportGameService;
        $this->sportService = $sportService;
    }

    /**
     * 顯示賽程隊伍資訊
     *
     * @param  Sport $sport
     * @return string
     */
    public function showTeamInformation(Sport $sport)
    {
        $teams = $sport->teams;
        $home_team = $teams->where('home','1')->first();
        $guest_team = $teams->where('home','0')->first();
        $home_data = '[主] '.$home_team->name.' ： '.$home_team->score;
        $guest_data = '[客] '.$guest_team->name.' ： '.$guest_team->score;
        return $home_data.'<br>'.$guest_data;
       
    }

    /**
     * 顯示賽程開盤狀態資訊
     *
     * @param  Sport $sport
     * @return string
     */
    public function showGameStatus(Sport $sport)
    {
        $games = $sport->games;

        foreach ($this->game_types as $type) {
            if(count($games) == 0){
                echo config('game.sport.game.type.'.$type).'：<span style="color:red;">未建立賭盤</span><br>';
            } else {
                $current_game = $games->where('type',$type)->first();
                if(count($current_game) == 0 ){
                    echo config('game.sport.game.type.'.$type).'：<span style="color:red;font-size">未建立賭盤</span><br>';
                } else {
                    echo config('game.sport.game.type.'.$type).'：'.config('game.sport.game.bet_status.'.$current_game->bet_status).'<br>';
                }
            }
            
        }
        
       
    }

    /**
     * 顯示賭盤內容資訊（後台）
     *
     * @param  SportGame $game
     * @return string
     */
    public function showGameSummary(SportGame $game)
    {
        return $this->sportGameService->show($game->type,$game);
       
    }


    /**
     * 顯示玩法列表
     *
     * @param  Sport $sport
     * @return string
     */
    public function showGamesBySport(Sport $sport)
    {
        return $this->sportGameService->showGamesBySport($sport);
       
    }

    /**
     * 檢查參數是否完整
     *
     * @param  $type,$game
     * @return string
     */
    public function checkParameterComplete($type,$game)
    {
        return $this->sportGameService->checkParameterComplete($type,$game);
       
    }

    /**
     * 顯示賭盤內容資訊(前台玩法列表)
     *
     * @param  SportGame $game
     * @return string
     */
    public function showGameRule(SportGame $game)
    {
        return $this->sportGameService->showGameRule($game->type,$game);
       
    }

    /**
     * 檢查是否有人下過注
     *
     * @param  Sport $sport
     * @return bool
     */
    public function checkIfHasBetRecord(Sport $sport)
    {
        return $this->sportService->checkIfHasBetRecords($sport);     
    }

    /**
     * 顯示下注狀況
     *
     * @param  SportGame $game
     * @return string
     */
    public function showBetTotal(SportGame $game)
    {
        $content = '';
        //取得所有選項
        $gambles = $this->sportGameService->getGambles($game->type,$game);
        
        foreach ($gambles as $gamble => $name) {
            $data = $this->sportGameService->getBetTotalByGamble($game->type,$game,$gamble);
            if($data->sum('total') == 0){
                $sum = 0;
            } else {
                $sum = $data->sum('total');
            }
            $content .= $name.':'.$sum.'<br>';

        } 
        return $content;
        
    }


}