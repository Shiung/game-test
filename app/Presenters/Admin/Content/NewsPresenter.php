<?php
namespace App\Presenters\Admin\Content;

class NewsPresenter
{

     /**
     * 取得計畫訊息狀態
     *
     * @param  $status
     * @return string
     */
    public function getStatus($status)
    {
        switch ($status) {
            case 0:
                return "<span style='color:red;'>關閉</span>";
                break;
            case 1:
                return "<span style='color:green;'>顯示</span>";
                break;
        }
       
    }


}