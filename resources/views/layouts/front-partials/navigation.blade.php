@inject('MemberService', 'App\Services\Member\MemberService')
<?php $member_level_info =  $MemberService->searchMemberLevel(Auth::guard('web')->user()->id) ?>

<div class="top-fixed-bar">
    
    <div class="pc-top-bg"></div>
    
    <!--bar背景圖片區塊-->
    <div class="pc-bar-area">
        <div class="pc-bar-logo">
            <img src="{{ asset('front/img/home/web/P01_menu_01.png') }}">
        </div>  
        
        <!--回首頁連結-->
        <a class="pc-home-link" href="{{ route('front.index') }}"><div class="pc-home-link-area"></div></a>
                
        <div class="pc-bar-name">
            {{ $member_level_info['level_name'] }}<img src="{{ asset($member_level_info['icon']) }}" width="20px">{{ Auth::guard('web')->user()->username }}
        </div>   
    </div>
    
    <div class="pc-bar-menu">
        @include('layouts.front-partials.menulist')
    </div>
    
    
</div>

<div class="pc-bar-height"></div>
