<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\System\CnChessChipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class CnChessChipsController extends Controller
{
    /**
     * 參數設定
     *
     * @var string
     */
    protected $chipService;
    protected $page_title = '象棋籌碼設定';
    protected $menu_title = '象棋籌碼設定';
    protected $route_code = 'cn_chess_chip';
    protected $view_data = [];


    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(CnChessChipService $chipService)
    {
        $this->chipService = $chipService;
        $this->view_data = [
            'route_code' => $this->route_code,
            'page_title' => $this->page_title,
            'menu_title' => $this->menu_title,
        ];

    }
    
    /**
     * 所有資料頁面
     * 
     * @return view admin/system/cn_chess/index.blade.php
     */
    public function index()
    {
        $chips = [];
        $items = $this->chipService->all();
        foreach ($items as $item) {

            array_push($chips,[
                'id' => $item->id,
                'name' => $item->name,
                'chips' => json_decode($item->content, true)
            ]);
        }
        $data =[
            'datas' => $chips
        ];
        return view('admin.system.'.$this->route_code.'.index',array_merge($this->view_data,$data));
    }

    /**
     * 更新
     * @param Request $request
     * @return json
     */
    public function update(Request $request)
    {
        $result = $this->chipService->update($request->chips);
        if ( $result['status']) {
            return json_encode(array('result' => 1, 'text' => 'Success'));
        } else {
            return json_encode(array('result' => 0, 'text' => $result['error']));
        } 
    }




}
