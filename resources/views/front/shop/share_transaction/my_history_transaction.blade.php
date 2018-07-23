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
        background-color: #009681;
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
        margin-left: -297px;
        width: 250px;
        height: 60px;
        line-height: 60px;
        font-size: 32px;
        font-weight: bold;
        text-align: center;
        background-color: white;
        color: #009681;
        border-top-left-radius: 25px;
        border-top-right-radius: 25px;
        z-index: 3;
    }
    
    .left-page-btn {
        position: absolute;
        bottom: 0;
        left: 50%;
        margin-left: -70px;
        width: 195px;
        height: 45px;
        line-height: 55px;
        font-size: 24px;
        font-weight: bold;
        text-align: left;
        padding-left: 45px;
        background-color: #008CC8;
        color: white;
        border-top-right-radius: 25px;
        z-index: 2;
    }
    
    .right-page-btn {
        position: absolute;
        bottom: 0;
        left: 50%;
        margin-left: 102px;
        width: 195px;
        height: 45px;
        line-height: 55px;
        font-size: 24px;
        font-weight: bold;
        text-align: left;
        padding-left: 45px;
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
            margin-left: -237px;
            width: 200px;
            height: 48px;
            line-height: 48px;
            font-size: 24px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .left-page-btn {
            margin-left: -60px;
            width: 160px;
            height: 36px;
            line-height: 40px;
            font-size: 18px;
            padding-left: 40px;
            border-top-right-radius: 20px;
        }

        .right-page-btn {
            margin-left: 77px;
            width: 160px;
            height: 36px;
            line-height: 40px;
            font-size: 18px;
            padding-left: 40px;
            border-top-right-radius: 20px;
        }
        
    }
    
    @media screen and (min-width: 768px) and (max-width: 991px) {

        .traction-top-btn-area {
            margin-top: -55px;
            height: 48px;
        }

        .current-page-btn {
            margin-left: -237px;
            width: 200px;
            height: 48px;
            line-height: 48px;
            font-size: 24px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .left-page-btn {
            margin-left: -60px;
            width: 160px;
            height: 36px;
            line-height: 40px;
            font-size: 18px;
            padding-left: 40px;
            border-top-right-radius: 20px;
        }

        .right-page-btn {
            margin-left: 77px;
            width: 160px;
            height: 36px;
            line-height: 40px;
            font-size: 18px;
            padding-left: 40px;
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
            left: 0%;
            margin-left: 0%;
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
            left: 50%;
            margin-left: -12.5%;
            width: 35%;
            height: 36px;
            line-height: 40px;
            font-size: 18px;
            padding-left: 0;
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
            left: 0%;
            margin-left: 0%;
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
            left: 50%;
            margin-left: -12.5%;
            width: 35%;
            height: 32px;
            line-height: 36px;
            font-size: 16px;
            padding-left: 0;
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
            left: 0%;
            margin-left: 0%;
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
            left: 50%;
            margin-left: -12.5%;
            width: 35%;
            height: 32px;
            line-height: 36px;
            font-size: 16px;
            padding-left: 0;
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
    
    #sell_list {
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
        border-left: 10px solid #009681;
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

    
    @media screen and (max-width: 767px) {
        .sorting_1 {
            line-height: 25px !important;
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
        color: #009681;
    }
    
    .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
        border :0;
        background-color: #FFF;
        color: #009681;
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
        <a href="{{ route('front.shop.share_transaction.my_history') }}"><div class="current-page-btn">拍賣紀錄</div></a>
        <a href="{{ route('front.shop.share_transaction.on_the_shelf') }}"><div class="left-page-btn">上架資訊</div></a>
        <a href="{{ route('front.shop.share_transaction.buy_history') }}"><div class="right-page-btn">購買紀錄</div></a>
    </div>
    
    <div class="share-table-title-area-small hidden-xs"></div> 
    
    <div class="share-table-area">
        <!--五筆最低價掛單-->
        <table id="sell_list" class="table">
            <thead>
                <th nowrap="nowrap" style="white-space:nowrap;">數量<div class="table-right-border"></div></th>
                <th nowrap="nowrap" style="white-space:nowrap;">單價<div class="table-right-border"></div></th>
                <th nowrap="nowrap" style="white-space:nowrap;">建立時間<div class="table-right-border"></div></th>
                <th nowrap="nowrap" style="white-space:nowrap;">狀態</th>
            </thead>
            <tbody>
            @foreach($sell_transactions as $sell_data)
                @if($sell_data->status != 0)
                <tr>
                    <td style="border-right: 1.5px solid #B6B7B9;">{{ number_format($sell_data->quantity) }}</td>
                    <td style="border-right: 1.5px solid #B6B7B9;">{{ $sell_data->price }}</td>
                    <td style="border-right: 1.5px solid #B6B7B9;">{{ $sell_data->created_at }}</td>
                    <td>
                        @if($sell_data->status == 1)
                        已成交
                        @elseif($sell_data->status == 2)
                        已過期
                        @else
                        已取消
                        @endif
                    </td>
                </tr>
                @endif
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

        var sell_table = $("#sell_list");

        //千分位
        webshims.setOptions('forms-ext', {
            replaceUI: 'true',
            types: 'number'
        });
        webshims.polyfill('forms forms-ext');


        //拍賣表格初始化
        sell_table.DataTable({
            "dom": '<"top"i>rt<"bottom"flp><"clear">',
            "order": [
                [2, "desc"]
            ],
            "pageLength": 10,
            "pagingType": "simple_numbers",
            "searching": false,
            "bLengthChange" : false,
            "bInfo" : false,
        });

        
    });

    
</script>

@stop

