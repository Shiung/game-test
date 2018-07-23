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


<!--背景-->
<div class="game-home-bg hidden-xs"></div>
<div class="m-game-home-bg hidden-sm hidden-md hidden-lg"></div>

<div class="game-btn-area">
    <div class="row">
        <!--我要購買-->
        <div class="col-xs-6 col-sm-4 col-game-btn">
            <a href="{{ route('front.shop.share_transaction.current_price') }}">
                <img class="game-home-btn hidden-xs" src="{{ asset('front/img/share/web/table_top_icon_01.png') }}"/>
                <img class="game-home-btn hidden-sm hidden-md hidden-lg" src="{{ asset('front/img/share/phone/table_top_icon_01.png') }}"/>
            </a>
        </div>
        <!--我要拍賣-->
        <div class="col-xs-6 col-sm-4 col-game-btn">
            <a href="{{ route('front.shop.share_transaction.sell_index') }}">
                <img class="game-home-btn hidden-xs" src="{{ asset('front/img/share/web/table_top_icon_02.png') }}"/>
                <img class="game-home-btn hidden-sm hidden-md hidden-lg" src="{{ asset('front/img/share/phone/table_top_icon_02.png') }}"/>
            </a>
        </div>
        <!--我的交易資訊-->
        <div class="col-xs-6 col-sm-4 col-game-btn">
            <a href="{{ route('front.shop.share_transaction.on_the_shelf') }}">
                <img class="game-home-btn hidden-xs" src="{{ asset('front/img/share/web/table_top_icon_03.png') }}"/>
                <img class="game-home-btn hidden-sm hidden-md hidden-lg" src="{{ asset('front/img/share/phone/table_top_icon_03.png') }}"/>
            </a>
        </div>
        <!--玩家交易資訊-->
        <div class="col-xs-6 col-sm-4 col-game-btn">
            <a href="{{ route('front.shop.share_transaction.all_auction') }}">
                <img class="game-home-btn hidden-xs" src="{{ asset('front/img/share/web/table_top_icon_04.png') }}"/>
                <img class="game-home-btn hidden-sm hidden-md hidden-lg" src="{{ asset('front/img/share/phone/table_top_icon_04.png') }}"/>
            </a>
        </div>
    </div>
   
</div>

@stop

@section('footer-js')

@stop
