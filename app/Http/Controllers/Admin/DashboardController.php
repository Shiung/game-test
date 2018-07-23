<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Services\System\ParameterService;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Session;
use Auth;

class DashboardController extends Controller
{

    protected $parameterService;
	public function __construct(ParameterService $parameterService) 
    {
        $this->parameterService = $parameterService;
    }

    /**
     * 後台首頁頁面
     *
     * @return view admin/home.blade.php
     */
    public function index()
    {
    	$data=[
            'web_status' => $this->parameterService->find('web_status'),
    		'page_title' => env('COMPANY_NAME').'管理系統',
            'menu_title' => env('COMPANY_NAME'),
    	];
	    return view('admin.home',$data);
    }

}
