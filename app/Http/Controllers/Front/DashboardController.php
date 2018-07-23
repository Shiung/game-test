<?php

namespace App\Http\Controllers\Front;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Content\MarqueeService;
use App\Services\Content\BannerService;
use App\Services\Content\NewsService;
use App\Services\Content\BoardMessageService;
use App\Services\System\MemberNewsReadRecordService;
use App\Services\System\ParameterService;
use App;
use Auth;

class DashboardController extends Controller
{

    protected $marqueeService;
    protected $bannerService;
    protected $newsService;
    protected $boardMessageService;
    protected $newsReadRecordService;
    protected $parameterService;

	public function __construct(
        MarqueeService $marqueeService,
        BannerService $bannerService,
        NewsService $newsService,
        BoardMessageService $boardMessageService,
        MemberNewsReadRecordService $newsReadRecordService,
        ParameterService $parameterService
    ) {
        $this->marqueeService = $marqueeService;
        $this->bannerService = $bannerService;
        $this->newsService = $newsService;
        $this->boardMessageService = $boardMessageService;
        $this->newsReadRecordService = $newsReadRecordService;
        $this->parameterService = $parameterService;
    }

    /**
     * 登入後首頁
     *
     * @return view front/home.blade.php
     */
    public function index()
    {
        if($this->newsReadRecordService->checkIfNewsRead(Auth::guard('web')->user()->id,1)){
            $system_alert_read = 1;
        } else {
            $system_alert_read = 0;
        }
    	$data=[
            'banners' => $this->bannerService->all(),
            'news' => $this->newsService->allToPaginate('news',5),
            'messages' => $this->boardMessageService->allToPaginate(null,null,5),
            'system_alert' => $this->newsService->findSystemAlert(),
            'system_alert_read' => $system_alert_read,
    		'page_title' => env('COMPANY_NAME'),
    	];

	    return view('front.home',$data);
    }

    /**
     * 會員專區頁面
     *
     * @return view front/member_center.blade.php
     */
    public function memberCenter()
    {
        $data=[
            'user' => Auth::guard('web')->user(),
            'member' => Auth::guard('web')->user()->member,
            'page_title' => '會員專區',
        ];

        return view('front.member_center',$data);
    }

    /**
     * 維修頁面
     *
     * @return view front/maintenance.blade.php
     */
    public function maintenance()
    {
        //若是網站開放期間，導向首頁
        if($this->parameterService->find('web_status') == '1'){
            return redirect()->route('front.index');
        }
        $data=[
            'page_title' => '網站維修中',
        ];

        return view('front.maintenance',$data);
    }

}
