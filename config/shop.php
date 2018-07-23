<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 商城相關設定
    |--------------------------------------------------------------------------
    |
    |
    */

    //線上儲值
    'charge' => [
        //付款狀態
        'pay_status' => [
            '0' => '<span style="color:red;">尚未付款</span>',
            '1' => '<span style="color:green;">已付款</span>'
        ],
        //確認狀態
        'confirm_status' => [
            '0' => '<span style="color:blue;">尚未發放</span>',
            '1' => '<span style="color:green;">已發放</span>',
            '2' => '<span style="color:red;">購買失敗</span>'
        ]
        
    ],
    //紅包群發
    'withdrawal' => [
        //確認狀態
        'confirm_status' => [
            '0' => '<span style="color:gray;">進行中</span>',
            '1' => '<span style="color:green;">已確認</span>',
            '2' => '<span style="color:red;">已拒絕</span>'
        ]
        
    ],
    'status' => [
        '0' => '<span style="color:red;">否</span>',
        '1' => '<span style="color:green;">是</span>'
    ],
    //商品
    'product' => [
        //上下架狀態
        'status' => [
            '0' => '<span style="color:red;">已下架</span>',
            '1' => '<span style="color:green;">上架中</span>'
        ]
        
    ],
    //商品交易紀錄
    'transaction' => [
        //交易類型
        'type' => [
            'buy' => '商城',
            'give' => '系統贈送',
            'transfer' => '會員交易'
        ]
        
    ],
    //娛樂幣紀錄
    'share_record' => [
        //娛樂幣增減類型
        'type' => [
            'company_add' => '公司發行／收回',
            'member_buy' => '會員購買',
            'company' => '公司贈送'
        ]
        
    ],


];
