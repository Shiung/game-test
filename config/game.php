<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 遊戲、賽程相關設定
    |--------------------------------------------------------------------------
    |
    |
    */

    'sport' => [
        //賽程狀態
        'status' => [
            'Scheduled' => '<span style="color:gray;">尚未開始</span>',
            'InProgress' => '<span style="color:green;">進行中</span>',
            'Final' => '<span style="color:black;">已結束</span>',
            'Suspended' => '<span style="color:red;">暫停</span>',
            'Postponed' => '<span style="color:red;">延期</span>',
            'Canceled' => '<span style="color:red;">取消</span>',
        ],
        'game' => [
            'sport_types' => [
                '1' => '大小',
                '2' => '讓分',
            ],
            //賭盤代號->英文
            'number_to_code' => [
                '1' => 'overunder',
                '2' => 'spread',
                '3' => 'choose_three',
            ],
            //賭盤代號->中文
            'type' => [
                '1' => '大小',
                '2' => '讓分',
                '3' => '選3球',
                '4' => '選棋',
                '5' => '選色'
            ],
            //開盤處理狀態
            'processing_status' => [
                '0' => '<span style="color:gray;">未開盤</span>',
                '1' => '<span style="color:blue;">開盤計算中</span>',
                '2' => '<span style="color:green;">已開盤</span>',
            ],
            //賭盤開放狀態
            'bet_status' => [
                '0' => '<span style="color:gray;">未開放下注</span>',
                '1' => '<span style="color:green;">開放下注中</span>',
                '2' => '<span style="color:gray;">關閉下注</span>',
                '3' => '<span style="color:blue;">已開盤</span>',
            ],
        ]

        
    ],
    'category' => [
        //遊戲代號轉換
        'type' => [
            'baseball' => '棒球',
            'basketball' => '籃球',
            'lottery' => '彩球539',
            'football' => '足球',
            'cn_chess' => '象棋',
        ],
        'category_id_to_name' => [
            '1' => '美棒(MLB)',
            '2' => '籃球(NBA)',
            '3' => '彩球539',
            '4' => '象棋',
            '5' => '足球',
        ],
        //不同遊戲對應的名稱與類型
        'usa_baseball' => [
            'name' => '美棒',
            'type' => 'baseball'
        ],
        'jp_baseball' => [
            'name' => '日棒',
            'type' => 'baseball'
        ],
        'tw_baseball' => [
            'name' => '中華職棒',
            'type' => 'baseball'
        ],
        'baseball' => [
            'name' => '棒球',
            'type' => 'baseball'
        ],
        'basketball' => [
            'name' => '籃球',
            'type' => 'basketball'
        ],
        'lottery539' => [
            'name' => '彩球',
            'type' => 'lottery539'
        ],

        'football' => [
            'name' => '足球',
            'type' => 'football'
        ],
        'cn_chess' => [
            'name' => '象棋',
            'type' => 'cn_chess'

        ]
        
    ],
    'status' => [
        '0' => '<span style="color:red;">否</span>',
        '1' => '<span style="color:green;">是</span>'
    ],
    'product' => [
        'status' => [
            '0' => '<span style="color:red;">已下架</span>',
            '1' => '<span style="color:green;">上架中</span>'
        ]
        
    ],


];
