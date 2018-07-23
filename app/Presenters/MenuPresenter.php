<?php
namespace App\Presenters;

class MenuPresenter
{
    /**
     * 檢查特定的menu tree是否要開啟
     *
     * @param  string $route_name
     * @return string
     */
    public function checkIfMenuOpen($route_names)
    {
        foreach ($route_names as $name) {
            if(request()->is('game-admin/dashboard/'.$name)){
            return true;
            }
        }
        return false;
    }

}