<?php

namespace App\Http\Controllers\Front\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Content\NewsService;
use App;
use Auth;

class NewsController extends Controller
{

    protected $newsService;
    protected $page_title = '最新消息';
    protected $route_code = 'news';
    
	public function __construct(
        NewsService $newsService
    ) {
        $this->newsService = $newsService;
    }

    /**
     * 簽到中心首頁
     *
     * @return view  front/content/news/index.blade.php
     */
    public function index()
    {
    	$data=[
            'alert' => $this->newsService->findSystemAlert(),
            'datas' => $this->newsService->allToPaginate('news',10),
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
    	];

	    return view('front.content.news.index',$data);
    }

    /**
     * 單一頁面
     * @param  int $id 最新消息id
     * @return view  front/content/news/show.blade.php
     */
    public function show($id)
    {
        $data = $this->newsService->find($id);
        //不存在
        if(!$data) {
            abort(404);
        }
        //未開放
        if($data->status == 0) {
            abort(404);
        }
        $data=[
            'data' => $data,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
        ];

        return view('front.content.news.show',$data);
    }

    /**
     * 系統彈跳公告
     *
     * @return view  front/content/news/system_alert.blade.php
     */
    public function getSystemAlert()
    {
        $data = $this->newsService->findSystemAlert();
        $data = [
            'data' => $data
        ];
        return view('front.content.news.system_alert',$data);
    }

}
