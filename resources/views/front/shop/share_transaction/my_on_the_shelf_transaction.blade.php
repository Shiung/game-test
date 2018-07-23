@extends('layouts.main')
@section('head')
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">

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
    
    /*bar高度設置*/
    .pc-bar-height{
        height: 65px !important;
    }

    @media screen and (min-width: 992px) and (max-width: 1399px) {
        .pc-bar-height{
            height: 53px !important;
        }
    }
    
    @media screen and (min-width: 768px) and (max-width: 991px) {
        .pc-bar-height{
            height: 43px !important;
        }
    }

    /*i7plus*/
    @media screen and (min-width: 414px) and (max-width: 767px) {
        
        .m-top-margin{
            height: 43px !important;
        }
        
    }
    
    /*i7大小～plus以下 & Android主流螢幕*/
    @media screen and (min-width: 360px) and (max-width: 413px) {
        
        .m-top-margin{
            height: 38px !important;
        }
        
    }
    
    
    /*i5大小*/
    @media screen and (max-width: 359px) {
        
        .m-top-margin{
            height: 33px !important;
        }
        
    }
    
    /*上方資訊區背景色*/
    .share-title-area {
        background-color: #008CC8;
    }
    
    /*上方切換分頁按鈕區域*/
    
    .traction-top-btn-area {
        position: relative;
        margin-top: -80px;
        height: 60px;
    }
    
    .current-page-btn {
        position: absolute;
        bottom: 0;
        left: 50%;
        margin-left: -125px;
        width: 250px;
        height: 60px;
        line-height: 60px;
        font-size: 32px;
        font-weight: bold;
        text-align: center;
        background-color: white;
        color: #008CC8;
        border-top-left-radius: 25px;
        border-top-right-radius: 25px;
        z-index: 3;
    }
    
    .left-page-btn {
        position: absolute;
        bottom: 0;
        left: 50%;
        margin-left: -297px;
        width: 175px;
        height: 45px;
        line-height: 55px;
        font-size: 24px;
        font-weight: bold;
        text-align: right;
        padding-right: 25px;
        background-color: #009681;
        color: white;
        border-top-left-radius: 25px;
        z-index: 2;
    }
    
    .right-page-btn {
        position: absolute;
        bottom: 0;
        left: 50%;
        margin-left: 122px;
        width: 175px;
        height: 45px;
        line-height: 55px;
        font-size: 24px;
        font-weight: bold;
        text-align: left;
        padding-left: 25px;
        background-color: #58595B;
        color: white;
        border-top-right-radius: 25px;
        z-index: 1;
    }
    
   
    @media screen and (min-width: 992px) and (max-width: 1399px) {

        .traction-top-btn-area {
            margin-top: -70px;
            height: 48px;
        }

        .current-page-btn {
            margin-left: -100px;
            width: 200px;
            height: 48px;
            line-height: 48px;
            font-size: 24px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .left-page-btn {
            margin-left: -237px;
            width: 140px;
            height: 36px;
            line-height: 40px;
            font-size: 18px;
            padding-right: 20px;
            border-top-left-radius: 20px;
        }

        .right-page-btn {
            margin-left: 97px;
            width: 140px;
            height: 36px;
            line-height: 40px;
            font-size: 18px;
            padding-left: 20px;
            border-top-right-radius: 20px;
        }
        
    }
    
    @media screen and (min-width: 768px) and (max-width: 991px) {

        .traction-top-btn-area {
            margin-top: -55px;
            height: 48px;
        }

        .current-page-btn {
            margin-left: -100px;
            width: 200px;
            height: 48px;
            line-height: 48px;
            font-size: 24px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .left-page-btn {
            margin-left: -237px;
            width: 140px;
            height: 36px;
            line-height: 40px;
            font-size: 18px;
            padding-right: 20px;
            border-top-left-radius: 20px;
        }

        .right-page-btn {
            margin-left: 97px;
            width: 140px;
            height: 36px;
            line-height: 40px;
            font-size: 18px;
            padding-left: 20px;
            border-top-right-radius: 20px;
        }
        
    }

    /*i7plus*/
    @media screen and (min-width: 414px) and (max-width: 767px) {
        
        .share-title-area {
            height: 232px;
        }
        
        .traction-top-btn-area {
            position: relative;
            margin-top: -139px;
            height: 48px;
        }

        .current-page-btn {
            position: absolute;
            bottom: 0;
            left: 50%;
            margin-left: -22.5%;
            width: 45%;
            height: 48px;
            line-height: 48px;
            font-size: 24px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .left-page-btn {
            position: absolute;
            bottom: 0;
            left: 0%;
            margin-left: 0px;
            width: 35%;
            height: 36px;
            line-height: 40px;
            font-size: 18px;
            padding-right: 0px;
            text-align: center;
            border-top-left-radius: 20px;
        }

        .right-page-btn {
            position: absolute;
            bottom: 0;
            left: auto;
            right: 0;
            margin-left: 0px;
            width: 35%;
            height: 36px;
            line-height: 40px;
            font-size: 18px;
            padding-left: 0px;
            text-align: center;
            border-top-right-radius: 20px;
        }
        
    }
    
    /*i7大小～plus以下 & Android主流螢幕*/
    @media screen and (min-width: 360px) and (max-width: 413px) {
        
        .share-title-area {
            height: 210px;
        }
        
        .traction-top-btn-area {
            position: relative;
            margin-top: -135px;
            height: 45px;
        }

        .current-page-btn {
            position: absolute;
            bottom: 0;
            left: 50%;
            margin-left: -22.5%;
            width: 45%;
            height: 45px;
            line-height: 45px;
            font-size: 22px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .left-page-btn {
            position: absolute;
            bottom: 0;
            left: 0%;
            margin-left: 0px;
            width: 35%;
            height: 32px;
            line-height: 36px;
            font-size: 16px;
            padding-right: 0px;
            text-align: center;
            border-top-left-radius: 20px;
        }

        .right-page-btn {
            position: absolute;
            bottom: 0;
            left: auto;
            right: 0;
            margin-left: 0px;
            width: 35%;
            height: 32px;
            line-height: 36px;
            font-size: 16px;
            padding-left: 0px;
            text-align: center;
            border-top-right-radius: 20px;
        }
        
    }
    
    
    /*i5大小*/
    @media screen and (max-width: 359px) {

        
        .share-title-area {
            height: 190px;
        }
        
        .traction-top-btn-area {
            position: relative;
            margin-top: -132px;
            height: 45px;
        }

        .current-page-btn {
            position: absolute;
            bottom: 0;
            left: 50%;
            margin-left: -22.5%;
            width: 45%;
            height: 45px;
            line-height: 45px;
            font-size: 22px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .left-page-btn {
            position: absolute;
            bottom: 0;
            left: 0%;
            margin-left: 0px;
            width: 35%;
            height: 32px;
            line-height: 36px;
            font-size: 16px;
            padding-right: 0px;
            text-align: center;
            border-top-left-radius: 20px;
        }

        .right-page-btn {
            position: absolute;
            bottom: 0;
            left: auto;
            right: 0;
            margin-left: 0px;
            width: 35%;
            height: 32px;
            line-height: 36px;
            font-size: 16px;
            padding-left: 0px;
            text-align: center;
            border-top-right-radius: 20px;
        }
        
    }
        
    /*表格區域*/
    
    #data_list {
        position: relative;
        margin-bottom: 0;
    }
    
    table.dataTable thead > tr > th {
        font-size: 20px;
        text-align: center;
        color: #2E2B4A;
    }
    
    table.dataTable thead > tr {
        border-left: 10px solid rgba(255, 255, 255, 0);
        border-bottom: 4px solid #2E2B4A;
    }
    
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after {
        right: 30%;
    }
    
    .table > tbody > tr > td {
        padding: 0;
        height: 70px;
        line-height: 70px;
        text-align: center;
        font-size: 22px;
        color: #2E2B4A;
        font-family: Frutiger , sans-serif;
        font-weight: bold;
        font-stretch: condensed;
        border: 0;
    }
    
    tr:nth-child(2n+1) {
	    background-color: #FFF;
        border-left: 10px solid #00A3E0;
	}
    
    tr:nth-child(2n+2) {
	    background-color: #CACBCC;
        border-left: 10px solid #2E2B4A;
	}
    
    tr:last-child {
        border-bottom: 4px solid #2E2B4A;
    }
    
    .cancel img {
        height: 32px;
        cursor: pointer;
    }
    
    .table-right-border {
        position: absolute;
        right: -1.5px;
        top: 12px;
        width: 3px;
        height: 22px;
        background-color: #2E2B4A;
    }
    
    
    @media screen and (min-width: 1200px) and (max-width: 1399px) {
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            right: 32%;
        }
    }
    
    @media screen and (min-width: 992px) and (max-width: 1199px) {

        table.dataTable thead > tr > th {
            font-size: 18px;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            right: 32%;
        }

        .table > tbody > tr > td {
            height: 60px;
            line-height: 60px;
            font-size: 20px;
        }
        
        .cancel img {
            height: 30px;
        }
        
        .table-right-border {
            right: -1.5px;
            top: 10px;
            width: 3px;
            height: 20px;
        }
        
    }
    
    @media screen and (min-width: 768px) and (max-width: 991px) {
        
        table.dataTable thead > tr > th {
            font-size: 16px;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            right: 32%;
        }

        .table > tbody > tr > td {
            height: 50px;
            line-height: 50px;
            font-size: 18px;
        }
        
        .cancel img {
            height: 26px;
        }
        
        .table-right-border {
            right: -1.5px;
            top: 9px;
            width: 3px;
            height: 20px;
        }
        
    }

    /*i7plus*/
    @media screen and (min-width: 414px) and (max-width: 767px) {
        
        table.dataTable thead > tr > th {
            font-size: 14px;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            right: 8px;
        }

        .table > tbody > tr > td {
            height: 50px;
            line-height: 50px;
            font-size: 16px;
        }
        
        .cancel img {
            height: 26px;
        }
        
        .table-right-border {
            right: -1.5px;
            top: 9px;
            width: 3px;
            height: 20px;
        }
        
    }
    
    /*i7大小～plus以下 & Android主流螢幕*/
    @media screen and (min-width: 360px) and (max-width: 413px) {
        
        table.dataTable thead > tr > th {
            font-size: 14px;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            right: 8px;
        }

        .table > tbody > tr > td {
            height: 50px;
            line-height: 50px;
            font-size: 16px;
        }
        
        .cancel img {
            height: 26px;
        }
        
        .table-right-border {
            right: -1.5px;
            top: 9px;
            width: 3px;
            height: 20px;
        }
        
    }
    
    
    /*i5大小*/
    @media screen and (max-width: 359px) {
        
        table.dataTable thead > tr > th {
            font-size: 12px;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            right: 8px;
        }

        .table > tbody > tr > td {
            height: 50px;
            line-height: 50px;
            font-size: 14px;
        }
        
        .cancel img {
            height: 22px;
        }
        
        .table-right-border {
            right: -1px;
            top: 10px;
            width: 2px;
            height: 16px;
        }
        
    }
    
    /*sweet-alert*/
    
    .sweet-alert {
        background: url("{{ asset('front/img/share/table_popup_bet_01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        padding: 0px 35px;
        width: 360px;
        height: 500px;
        left: 50%;
        margin-left: -180px;
    }
    
    
    .sweet-alert .sa-icon {
        position: fixed;
        left: 50%;
    }
    
    .sweet-alert h2 {
        margin-top: 130px;
        margin-bottom: 0px;
        color: #5A5B5D;
    }
    
    .sweet-alert p {
        max-height: 280px;
        overflow-y: scroll;
    }
    
    .sweet-alert p::-webkit-scrollbar
    {
        width: 0px;
    }
    
    .sweet-alert button.confirm {
        background-color: #de0033 !important;
    }
    
    .sweet-alert button.cancel {
        background-color: #57585b !important;
    }
    
    .sweet-alert button {
        margin-top: 10px;
        padding: 5px 15px;
    }
    
    .sweet-alert button:hover {
        background-color: #de0033 !important;
    }
    
    .sweet-alert .sa-icon {
        width: 90px;
        height: 90px;
        margin-left: -45px;
        margin-top: 30px;
    }
    
    .sweet-alert .sa-icon.sa-warning {
        background: url("{{ asset('front/img/share/table_popup_01.gif') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        border:0;
    }
    .sweet-alert .sa-icon.sa-warning .sa-body {
        display:none; 
    }
    .sweet-alert .sa-icon.sa-warning .sa-dot {
        display:none; 
    }
    
    .sweet-alert .sa-icon.sa-success {
        background: url("{{ asset('front/img/share/table_popup_02.gif') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        border:0;
    }
    
    .sweet-alert .sa-icon.sa-success::before, .sweet-alert .sa-icon.sa-success::after {
        display:none;
    }
    .sweet-alert .sa-icon.sa-success::before {
        display:none;  
    }
    .sweet-alert .sa-icon.sa-success::after {
        display:none;
    }
    .sweet-alert .sa-icon.sa-success .sa-placeholder {
        display:none;
    }
    .sweet-alert .sa-icon.sa-success .sa-fix {
        display:none;
    }
    .sweet-alert .sa-icon.sa-success .sa-line {
        display:none;
    }
    .sweet-alert .sa-icon.sa-success .sa-line.sa-tip {
        display:none;
    }
    .sweet-alert .sa-icon.sa-success .sa-line.sa-long {
        display:none;
    }
    
    .sweet-alert .sa-icon.sa-error {
        background: url("{{ asset('front/img/share/table_popup_03.gif') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        border:0;
    }
    
    .sweet-alert .sa-icon.sa-error .sa-x-mark {
        display:none;
    }
    .sweet-alert .sa-icon.sa-error .sa-line {
        display:none;
    }
    .sweet-alert .sa-icon.sa-error .sa-line.sa-left {
        display:none;
    }
    .sweet-alert .sa-icon.sa-error .sa-line.sa-right {
        display:none;
    }
    
    
    /*交易取消alert*/
    .cancel-alert-title {
        color: #E50530;
        font-size: 36px;
        text-align: center;
        line-height: 150%;
    }
    
    .cancel-alert-info {
        color: #E50530;
        font-size: 18px;
        text-align: center;
        line-height: 180%;
    }
    
    
    .sa-button-container {
        position: absolute;
        width: 100%;
        left: 0;
        bottom: 30px;
    }
    
    div.dataTables_paginate {
        text-align: center;
        margin-top: 10px;
        font-size: 18px;
    }
    
    @media screen and (max-width: 767px) {
        div.dataTables_paginate {
            text-align: center;
            margin-top: 10px;
            font-size: 12px;
        }
    }
    
    .pagination > li:first-child > a, .pagination > li:first-child > span , .pagination > li:last-child > a, .pagination > li:last-child > span {
        color: #58585B;
        border: 0;
    }
    
    .pagination > li > a, .pagination > li > span {
        border: 0;
        background-color: rgba(0,0,0,0);
        color: #58585B;
    }
    
    .pagination > li > a:hover, .pagination > li > span:hover, .pagination > li > a:focus, .pagination > li > span:focus {
        border :0;
        background-color: #FFF;
        color: #008CC8;
    }
    
    .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
        border :0;
        background-color: #FFF;
        color: #008CC8;
    }
    
</style>
@stop

@section('full-size-content')

<!--背景-->
<div class="game-home-bg hidden-xs"></div>
<div class="m-game-home-bg hidden-sm hidden-md hidden-lg"></div>

<div class="share-title-area">
    
    <div class="container">
        <div class="row">
            
            <!--左方牌價-->
            <div class="col-sm-6 hidden-xs">
                <div class="share-title-left">  
                    <!--牌價-->
                    <div class="share-title-left-info">
                        <div class="share-title-left-info-new-title">
                            最新牌價
                        </div>
                        <div class="share-title-left-info-new">
                            {{  $share_product->price }}
                        </div>
                        <div class="share-title-left-info-amount-title">商城娛樂幣總數</div>
                        <div class="share-title-left-info-amount">{{  number_format($share['now']) }}</div>
                    </div>
                    
                    <!--幣icon-->
                    <div class="share-title-left-icon">
                        <img src="{{ asset('front/img/share/table_icon_01_white.gif') }}">
                    </div>
                </div>
            </div>
            
            <!--右方餘額-->
            <div class="col-sm-5 hidden-xs">
                <div class="row coin-account-row">
                    <div class="col-xs-6" style="padding-left:0;padding-right:0;">
                        <div class="coin-account-area">
                            <div class="coin-amount-icon">
                                <img src="{{ asset('front/img/icon/usercoin/user_bg_gold_01.png') }}"/>
                            </div>
                            <div class="coin-amount-font">
                                {{ number_format($cash_amount) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6" style="padding-left:0;padding-right:0;">
                        <div class="coin-account-area">
                            <div class="coin-amount-icon">
                                <img src="{{ asset('front/img/icon/usercoin/user_bg_ulg_01.png') }}"/>
                            </div>
                            <div class="coin-amount-font">
                                {{ number_format($share_amount) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-1 hidden-xs"></div>
            
        </div><!--/row-->
    </div><!--/container-->
    
</div>

<div class="container">
    <div class="traction-top-btn-area">
        <a href="{{ route('front.shop.share_transaction.on_the_shelf') }}"><div class="current-page-btn">上架資訊</div></a>
        <a href="{{ route('front.shop.share_transaction.my_history') }}"><div class="left-page-btn">拍賣紀錄</div></a>
        <a href="{{ route('front.shop.share_transaction.buy_history') }}"><div class="right-page-btn">購買紀錄</div></a>
    </div>
    
    <div class="share-table-title-area-small hidden-xs"></div> 
    
    <div class="share-table-area">
        <!--五筆最低價掛單-->
        <table id="data_list" class="table">
            <thead>
                <th nowrap="nowrap" style="white-space:nowrap;">數量<div class="table-right-border"></div></th>
                <th nowrap="nowrap" style="white-space:nowrap;">單價<div class="table-right-border"></div></th>
                <th nowrap="nowrap" style="white-space:nowrap;">倒數<div class="table-right-border"></div></th>
                <th nowrap="nowrap" style="white-space:nowrap;"></th>
            </thead>
            <tbody>
            @foreach($transactions as $data)
                <tr>
                    <td style="border-right: 1.5px solid #B6B7B9;">{{ number_format($data->quantity) }}</td>
                    <td style="border-right: 1.5px solid #B6B7B9;">{{ $data->price }}</td>
                    <td style="border-right: 1.5px solid #B6B7B9;">{{ $data->time_left }}</td>
                    <td><a class="cancel" data-id="{{ $data->id }}"><img src="{{ asset('front/img/share/table_no_green.png') }}"/></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!--/.五筆最低價掛單-->
    </div>
    
    <div class="share-table-bottom-area"></div>
    
</div>

@stop

@section('footer-js')

<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="{{ asset('plugins/js-webshim/minified/polyfiller.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function() {
   
        var table = $("#product_list");
        var table = $("#data_list");

        //千分位
        webshims.setOptions('forms-ext', {
            replaceUI: 'true',
            types: 'number'
        });
        webshims.polyfill('forms forms-ext');


        //表格初始化
        table.DataTable({
            "dom": '<"top"i>rt<"bottom"flp><"clear">',
            "order": [
                [1, "asc"]
            ],
            columns: [
                  {},
                  {},
                  {},
                  {"orderable": false},
            ],
            "pageLength": 10,
            "pagingType": "simple_numbers",
            "searching": false,
            "bLengthChange" : false,
            "bInfo" : false,
        });

        //取消
        table.on("click", ".cancel", function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: '拍賣取消確認',
                text: '<hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="cancel-alert-title">\\ 注意 /</div><div class="cancel-alert-info">拍賣取消，拍賣卡將不退回</br>確認要取消此筆交易?</div>',
                type: 'warning',
                html:true,
                showCancelButton: true,
                confirmButtonText: '確認',
                cancelButtonText: '取消'
            },function(){
                sendUri = APP_URL + "/shop/share_transaction/cancel" ;
                sendData = {'id' : id };
                system_ajax(sendUri,sendData,"PUT",function(data){
                    window.location.reload();
                },function(data){});
            });

        });//.取消

        
    });

    
</script>

@stop

