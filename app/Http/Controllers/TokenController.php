<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use Auth;
use App\Services\TokenService;
use App\Models\User;
use App\Models\Member;
use Session;

class TokenController extends Controller
{

    protected $tokenService;
    /**
     * 開頭宣告
     *
     * @return void
     */
    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }
    
    
    /**
     * 取得管理員token
     * @param Request $request
     * @return string
     */
    public function getAdminToken(Request $request)
    {
        if(Auth::guard('admin')->user()){
            $user = User::find(Auth::guard('admin')->user()->id);
            if (Session::has('a_token')) {
                $token = Session::get('a_token');
            } else {
                $token = 'no';
            }
            $this->tokenService->setToken($user,$token);
          
            return Session::get('a_token');
        }
        

    }


    /**
     * 取得會員token
     * @param Request $request
     * @return string
     */
    public function getMemberToken(Request $request)
    {
        if(Auth::guard('web')->user()){
            $user = Auth::guard('web')->user();
            if (Session::has('m_token')) {
                $token = Session::get('m_token');
            } else {
                $token = 'no';
            }

            $this->tokenService->setToken($user,$token);
            return Session::get('m_token');
        }
        
    }

    
   
}
