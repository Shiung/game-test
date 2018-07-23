<?php

namespace App\Http\Controllers\Front\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Content\PageService;
use App;
use Auth;

class PagesController extends Controller
{

    protected $pageService;
    protected $page_title = '資訊頁面';
    protected $route_code = 'page';
    
	public function __construct(
        PageService $pageService
    ) {
        $this->pageService = $pageService;
    }

    /**
     * 客製頁面
     * @param string code 頁面代碼
     * @return view  front/content/page/show.blade.php
     */
    public function show($code)
    {
        $data = $this->pageService->getPageByCode($code, 1);
        //頁面不存在
        if(!$data) {
            abort(404);
        }
        $data=[
            'data' => $data,
            'route_code' => $this->route_code,
            'page_title' => $this->page_title
        ];

        return view('front.content.page.show',$data);
    }



}
