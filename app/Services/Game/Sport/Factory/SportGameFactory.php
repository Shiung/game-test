<?php
namespace App\Services\Game\Sport\Factory;

use App;
use App\Services\Game\Sport\Gamble\OverunderService;
use App\Services\Game\Sport\Gamble\SpreadService;
use App\Services\Game\Sport\Gamble\ChooseThreeService;
use App\Services\Game\Sport\Gamble\CnChessNumberService;
use App\Services\Game\Sport\Gamble\CnChessColorService;
use Exception;

class SportGameFactory {
    
    /**
     * 建立賭盤物件
     *
     * @param string $type
     *
     * @return LogisticsInterface
     */
    public static function create($type)
    {
        switch ($type) {
            case 1:
                return  new OverunderService();
            case 2:
                return  new SpreadService();
            case 3:
                return  new ChooseThreeService();
            case 4:
                return  new CnChessNumberService();
            case 5:
                return  new CnChessColorService();
            default:
                # code...
                break;
        }
    }

    
    
  
}
