<?php 
namespace App\Services\Game\Sport\Contracts;

/**
 * 賭盤共同操作
 *
 * @license MIT
 */

interface GambleInterface
{
    
    /**
     * 顯示後台的賭盤內容摘要
     *
     * @param SportGame $game
     *
     * @return string
     */
    public function showGameSummary($game);


    /**
     * 回傳單一玩法參數（for前台）
     *
     * @param SportGame $game  
     * @param Sport $sport
     * @param SportTeam $teams
     *
     * @return array
     */
    public function getGameParameter($game,$sport,$teams);

    /**
     * 檢查參數完整
     *
     * @param array $detail
     *
     * @return bool
     */
    public function checkParameterComplete($detail);

    /**
     * 檢查下注選項值是否存在
     * @param SportGame $game
     * @param array $data
     *
     * @return bool
     */
    public function checkGambleExist($game,$data);


    /**
     * 顯示下注明細內容欄位
     *
     * @param BetRecord $record
     *
     * @return string
     */
    public function showBetRecordSummary($record);
}
