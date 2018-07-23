@extends('layouts.main')
@section('head')
<style>
    
    /*上方menu顯示title版本*/
    .m-bar-nav-close-bg {
        display: none;
    }
    
    .m-bar-nav-close-bg-title {
        display: block !important;
    }
    
    .m-page-title {
        display: block !important;
    }
    
    /*跑馬燈公告*/
    .m-marquee-position {
        display: block !important;
    }
    
    .pc-marquee-position {
        display: block !important;
    }

    .game-btn-area {
        position: relative;
        width: 100%;
        margin: 0 auto;
        margin-top: 50px;
    }
    
    @media screen and (min-width: 1200px) and (max-width: 1399px) {
        .game-btn-area {
            width: 80%;
        }    
    }
    
    @media screen and (max-width: 767px) {
        .game-btn-area {
            margin-top: 10%;
        }    
    }
    
    .col-game-btn {
        margin-bottom: 10px;
    }
    
    .game-home-btn {
        width: 100%;
    }
    
</style>



@stop 

@section('content')
@inject('CategoryService','App\Services\Game\CategoryService')
<!--
<h1>{{ $page_title }} </h1>

路徑
<ol class="breadcrumb">
    <li class="breadcrumb-item">遊戲大廳</li>
</ol>-->
<!--/.路徑-->

<!--
<a href="{{ route('front.page.show','game_instructions') }}">玩法說明</a>
-->

<!--背景-->
<div class="game-home-bg hidden-xs"></div>
<div class="m-game-home-bg hidden-sm hidden-md hidden-lg"></div>

<div class="game-btn-area">
    <div class="row">
        <div class="col-xs-6 col-sm-4 col-game-btn">
            <a href="{{ route('front.game.category.index','basketball') }}">
                <img class="game-home-btn hidden-xs" src="{{ asset('front/img/chess/web/game_01.png') }}"/>
                <img class="game-home-btn hidden-sm hidden-md hidden-lg" src="{{ asset('front/img/chess/phone/game_01.png') }}"/>
            </a>
        </div>
        <div class="col-xs-6 col-sm-4 col-game-btn">
            <a href="{{ route('front.game.category.index','usa_baseball') }}">
                <img class="game-home-btn hidden-xs" src="{{ asset('front/img/chess/web/game_02.png') }}"/>
                <img class="game-home-btn hidden-sm hidden-md hidden-lg" src="{{ asset('front/img/chess/phone/game_02.png') }}"/>
            </a>
        </div>
        <div class="col-xs-6 col-sm-4 col-game-btn">
            <a href="{{ route('front.game.category.index','football') }}">
                <img class="game-home-btn hidden-xs" src="{{ asset('front/img/chess/web/game_03.png') }}"/>
                <img class="game-home-btn hidden-sm hidden-md hidden-lg" src="{{ asset('front/img/chess/phone/game_03.png') }}"/>
            </a>
        </div>
        <div class="col-xs-6 col-sm-4 col-game-btn">
            <a href="{{ route('front.game.category.index','lottery539') }}">
                <img class="game-home-btn hidden-xs" src="{{ asset('front/img/chess/web/game_04.png') }}"/>
                <img class="game-home-btn hidden-sm hidden-md hidden-lg" src="{{ asset('front/img/chess/phone/game_04.png') }}"/>
            </a>
        </div>
        <div class="col-xs-6 col-sm-4 col-game-btn">
            <a href="{{ route('front.game.category.index','cn_chess') }}">
                <img class="game-home-btn hidden-xs" src="{{ asset('front/img/chess/web/game_05.png') }}"/>
                <img class="game-home-btn hidden-sm hidden-md hidden-lg" src="{{ asset('front/img/chess/phone/game_05.png') }}"/>
            </a>
        </div>
    </div>
   
</div>

<!--
<a class="btn btn-info" href="{{ route('front.game.category.index','usa_baseball') }}">美國職棒(MLB)</a>
<a class="btn btn-info" href="{{ route('front.game.category.index','basketball') }}">NBA</a>
<a class="btn btn-info" href="{{ route('front.game.category.index','cn_chess') }}">象棋</a>
<a class="btn btn-info" href="{{ route('front.game.category.index','lottery539') }}">彩球539</a>
<a class="btn btn-info" href="{{ route('front.game.category.index','football') }}">足球</a> 
<p style="color:red">即時賽況：<a href="https://live.leisu.com/lanqiu" target="_blank" style="text-decoration:underline;">雷速体育</a> </p>
-->
@stop

@section('footer-js')


@stop
