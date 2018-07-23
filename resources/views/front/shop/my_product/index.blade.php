@extends('layouts.main')
@section('head')

<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script>
  $(function() {
    $(".fancybox").fancybox();  
  });
</script>
<style>
    .sweet-alert button.cancel{
        background-color: #FF0000;
    }
    
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
    
    @media screen and (max-width: 767px) {
    
        .row-account {
            margin-top: 10%;
        }
    
    }

    .col-account {
        position: relative;
        padding-bottom: 10px;
        padding-left: 0px;
        padding-right: 0px;
    }
    
    .amount-area {
        position: relative;
        width: 100%;
    }
    
    .account-amount-icon {
        position: relative;
        width: 100%;
        z-index: 2;
    }
    
    .account-amount-icon img {
        width: 100%;
    }
    
    .account-amount-font {
        position: absolute;
        text-align: right;
        color: #FFF;
        right: 15%;
        top: 50%;
        margin-top: -25px;
        line-height: 50px;
        z-index: 3;
        
        font-family: Frutiger;
        font-size: 24px;
        font-weight: bold;
        font-stretch: condensed;
        
    }
    
    @media screen and (max-width: 767px) {
    
        .col-account {
            position: relative;
            padding-bottom: 0;
            margin-bottom: 10px;
        }

        .account-amount-font {
            right: 12%;
            margin-top: -15px;
            line-height: 30px;
            font-size: 16px;
        }
    
    }
    
    
    .check-in-table-title {
        position: relative;
        width: 100%;
        margin-top: 20px;
        margin-bottom: -20px;
        font-size: 18px;
    }
    
    .check-in-table-area {
        position: relative;
        width: 100%;
        height: 470px;
        overflow-y: scroll;
        overflow-x: hidden;
        font-size: 18px;
    }
    
    @media screen and (min-width: 992px) and (max-width: 1399px) {
        
        .check-in-table-area {
            height: 350px;
        }
        
    }
    
    @media screen and (min-width: 768px) and (max-width: 991px) {
        
        .check-in-table-area {
            height: 300px;
        }
        
    }
    
    
    @media screen and (max-width: 767px) {
        
        .check-in-table-title {
            font-size: 14px;
            margin-top: 5px;
        }
        
        .check-in-table-area {
            height: 320px;
            font-size: 14px;
        }  
        
    }
    
    /*i7大小～plus以下*/
    @media screen and (min-width: 375px) and (max-width: 413px) {

        .check-in-table-title {
            font-size: 14px;
        }
        
        .check-in-table-area {
            height: 280px;
            font-size: 14px;
        }

    }

    /*Android主流*/
    @media screen and (min-width: 360px) and (max-width: 374px) {

        .check-in-table-title {
            font-size: 12px;
        }
        
        .check-in-table-area {
            height: 260px;
            font-size: 12px;
        }
        
    }

    /*i5大小*/
    @media screen and (max-width: 359px) {

        .check-in-table-title {
            font-size: 12px;
        }
        
        .check-in-table-area {
            height: 210px;
            font-size: 12px;
        }
        
    }
    
    @media screen and (min-width: 768px) {
        
        .check-in-table-title {
            padding-right: 25px;
        }
        
        .check-in-table-area {
            padding-right: 15px;
        }

        .check-in-table-area::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0);
            border-radius: 10px;
            background-color: rgba(0,0,0,0);
        }

        .check-in-table-area::-webkit-scrollbar
        {
            width: 10px;
            background-color: #191639;
            border-left: 3px solid #9a9a9a;
            border-right: 3px solid #9a9a9a;
        }

        .check-in-table-area::-webkit-scrollbar-thumb
        {
            border-radius: 10px;
            background-color: #191639;
        }
    
    }

    
    
    .table-checkin > thead > tr > th, .table-checkin > tbody > tr > th, .table-checkin > tfoot > tr > th, .table-checkin > thead > tr > td, .table-checkin > tbody > tr > td, .table-checkin > tfoot > tr > td {
        vertical-align: middle;
        text-align: center;
    }
    
    .table-checkin > thead > tr > th {
        position: relative;
        color: #191639;
        border-bottom: 2px solid #191639;
        height: 36px;
        line-height: 32px;
    }
    
    .table-title-border {
        position: absolute;
        top: 8px;
        right: -1px;
        width: 2px;
        height: 32px;
        background-color: #191639;
    }
    
    .table-checkin > tbody > tr > td {
        border: 1px solid #191639;
        color: #191639;
    }
    
    tr:nth-child(4n+3) , tr:nth-child(4n+4) {
	    background: linear-gradient(to right, rgba(214, 213, 213, 0) , #E7E7E7 , rgba(214, 213, 213, 0));
	}
    
    @media screen and (max-width: 767px) {
        tr:nth-child(4n+3) , tr:nth-child(4n+4) {
            background-attachment:fixed;
        }
    }
    
    .btn-use {
        width: 60px;
        height: 39px;
        background: url("{{ asset('front/img/icon/button/btn_use_off.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    .btn-use:hover , .btn-use:focus {
        width: 60px;
        height: 39px;
        background: url("{{ asset('front/img/icon/button/btn_use_on.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
     @media screen and (max-width: 767px) {
        .btn-use {
            width: 37px;
            height: 24px;
        }

        .btn-use:hover , .btn-use:focus {
            width: 37px;
            height: 24px;
        }
    }
    
</style>
@stop 

@section('content')
@inject('ProductPresenter','App\Presenters\Shop\ProductPresenter')
<!--背景-->
<div class="ball-bg hidden-xs"></div>
<div class="m-ball-bg hidden-sm hidden-md hidden-lg"></div>

<!--餘額-->
<div class="row row-account">
    
    <!--金幣-->
    <div class="col-xs-6 col-sm-3 col-account">
        <div class="amount-area">
            <div class="account-amount-icon">
                <img src="{{ asset('front/img/icon/usercoin/user_bg_gold_01.png') }}"/>
            </div>
            <div class="account-amount-font">
                {{ number_format($account_amount['cash']) }}
            </div>
        </div>

    </div>
    
    <!--娛樂幣-->
    <div class="col-xs-6 col-sm-3 col-account">
        <div class="amount-area">
            <div class="account-amount-icon">
                <img src="{{ asset('front/img/icon/usercoin/user_bg_ulg_01.png') }}"/>
            </div>
            <div class="account-amount-font">
                {{ number_format($account_amount['right']) }}
            </div>
        </div>
    </div>
    
    <!--紅利-->
    <div class="col-xs-6 col-sm-3 col-account">
        <div class="amount-area">
            <div class="account-amount-icon">
                <img src="{{ asset('front/img/icon/usercoin/user_bg_bonus_01.png') }}"/>
            </div>
            <div class="account-amount-font">
                {{ number_format($account_amount['interest']) }}
            </div>
        </div>
    </div>
    
    <!--禮券-->
    <div class="col-xs-6 col-sm-3 col-account">
        <div class="amount-area">
            <div class="account-amount-icon">
                <img src="{{ asset('front/img/icon/usercoin/user_bg_gift_01.png') }}"/>
            </div>
            <div class="account-amount-font">
                {{ number_format($account_amount['run']) }}
            </div>
        </div>
    </div>

</div>
<!--/.餘額-->

<div class="check-in-table-title">
    <table class="table table-checkin">
        <thead>
            <th style="width:24%;">商品名稱<div class="table-title-border"></div></th>
            <th style="width:29%;">金額<div class="table-title-border"></div></th>
            <th style="width:29%;">數量<div class="table-title-border"></div></th>
            <th style="width:18%;">使用</th>
        </thead>
    </table>
</div>

<!--列表-->
<div class="check-in-table-area">
    <table class="table table-checkin">
        <tbody>
        @foreach($datas as $data)

            <tr class="tr1">
                <td rowspan="2" style="border-left:0; width:24%;"><a href="{{ route('front.shop.product.show',[$data->id,0]) }}" class="fancybox fancybox.iframe" style="color:#191639;"><img src="{{ $ProductPresenter->showMyProductImg($data) }}" width="50px"></a></td>
                <td style="width:29%;">{{ number_format($data->price) }}</td>
                <td style="width:29%;">{{ number_format($data->bag_quantity) }}</td>
                <td rowspan="2" style="width:18%; border-right:0; padding:8px 0px;"><a href="{{ route('front.shop.use.redirect',$data->id) }}"><div class="btn-use"></div></a></td>
            </tr>
            <tr class="tr2">
                <td colspan="2" style="text-align:left;">{{ $data->description }}</td>
            </tr>
                  
        @endforeach
        </tbody>
    </table>
</div>

<!--/.列表-->

@stop

@section('footer-js')



@stop
