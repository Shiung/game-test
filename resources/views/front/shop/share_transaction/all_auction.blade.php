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
        background-color: #58595B;
    }
    
    .xs-coin-show {
        margin-top: -20px;
    }
    
    /*表單抬頭標題顏色*/
    .share-table-title {
        color: #58595B;
    }
    
    /*i7plus*/
    @media screen and (min-width: 414px) and (max-width: 767px) {

        .share-title-left {
            width: 365px;
            margin: 0 auto;
        }

    }

    /*i7大小～plus以下 & Android主流螢幕*/
    @media screen and (min-width: 360px) and (max-width: 413px) {

        .share-title-left {
            width: 340px;
            margin: 0 auto;
        }


    }

    /*i5大小*/
    @media screen and (max-width: 359px) {

        .share-title-left {
            width: 320px;
            margin: 0 auto;
        }

    }
    
    /*資料表格區域*/
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
        border-left: 10px solid #A6A8AA;
	}
    
    tr:nth-child(2n+2) {
	    background-color: #CACBCC;
        border-left: 10px solid #2E2B4A;
	}
    
    tr:last-child {
        border-bottom: 4px solid #2E2B4A;
    }
    
    .buy img {
        height: 32px;
        cursor: pointer;
    }
    
    .cancel img {
        height: 32px;
        cursor: pointer;
    }
    
    .buy_item {
        width: 60px;
        height: 32px;
        background: url("{{ asset('front/img/share/table_buy_gary.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
        margin-top:19px;
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
            right: 28%;
        }
    }
    
    @media screen and (min-width: 992px) and (max-width: 1199px) {

        table.dataTable thead > tr > th {
            font-size: 18px;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            right: 30%;
        }

        .table > tbody > tr > td {
            height: 60px;
            line-height: 60px;
            font-size: 20px;
        }
        
        .buy img {
            height: 30px;
        }
        
        .cancel img {
            height: 30px;
        }
        
        .buy_item {
            width: 57px;
            height: 30px;
            margin-top: 15px;
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
            right: 30%;
        }

        .table > tbody > tr > td {
            height: 50px;
            line-height: 50px;
            font-size: 18px;
        }
        
        .buy img {
            height: 26px;
        }
        
        .cancel img {
            height: 26px;
        }
                
        .buy_item {
            width: 50px;
            height: 26px;
            margin-top: 12px;
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
        
        .buy img {
            height: 26px;
        }
        
        .cancel img {
            height: 26px;
        }
        
        .buy_item {
            width: 50px;
            height: 26px;
            margin-top: 12px;
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
        
        .buy img {
            height: 26px;
        }
        
        .cancel img {
            height: 26px;
        }
                    
        .buy_item {
            width: 50px;
            height: 26px;
            margin-top: 12px;
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
        
        .buy img {
            height: 22px;
        }
        
        .cancel img {
            height: 22px;
        }
                 
        .buy_item {
            width: 42px;
            height: 22px;
            margin-top: 14px;
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
    
    /*交易確認alert*/
    
    .check-unit {
        font-size: 38px;
        color: #008CC8;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
        line-height: 120%;
    }
    
    .check-price {
        position: relative;
        font-size: 56px;
        color: #008CC8;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
        line-height: 120%;
        text-align: center;
    }
    
    .check-price-icon {
        display: inline-block;/*讓div並排*/ 
        vertical-align: bottom;
        width:30px;
        height: 35px;
        background: url("{{ asset('front/img/share/table_icon_01_blue.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin-right: 5px;
    }
    
    .check-price-info {
        display: inline-block;/*讓div並排*/ 
        vertical-align: bottom;
    }
    
    .check-coin-plus {
        position: relative;
        width: 100%;
        height: 60px;
        line-height: 60px;
        margin: 0 auto;
        color: #00A3E0;
        font-size: 28px;
        font-family: Frutiger , sans-serif;
        font-weight: bold;
        font-stretch: condensed;
        text-align: left;
        padding-left: 90px;
    }
    
    .check-coin-plus-icon {
        position: absolute;
        top: 5px;
        left: 30px;
        width: 50px;
        height: 50px;
        background: url("{{ asset('front/img/icon/currency/currency_ulg_02.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .check-coin-use {
        position: relative;
        width: 100%;
        height: 60px;
        line-height: 60px;
        margin: 0 auto;
        color: #D4A435;
        font-size: 28px;
        font-family: Frutiger , sans-serif;
        font-weight: bold;
        font-stretch: condensed;
        text-align: left;
        padding-left: 90px;
    }
    
    .check-coin-use-icon {
        position: absolute;
        top: 5px;
        left: 30px;
        width: 50px;
        height: 50px;
        background: url("{{ asset('front/img/icon/currency/currency_gold_02.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    /*交易成功alert*/
    
    .success-unit {
        font-size: 38px;
        color: #38A556;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
        line-height: 120%;
    }
    
    .success-price {
        position: relative;
        font-size: 56px;
        color: #38A556;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
        line-height: 120%;
        text-align: center;
    }
    
    .success-price-icon {
        display: inline-block;/*讓div並排*/ 
        vertical-align: bottom;
        width:30px;
        height: 35px;
        background: url("{{ asset('front/img/share/table_icon_01_green.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin-right: 5px;
    }
    
    .success-price-info {
        display: inline-block;/*讓div並排*/ 
        vertical-align: bottom;
    }
    
    .error-text {
        color: #E60B35;
        text-align: center;
        margin-top: 10px;
        font-size: 18px;
        line-height: 150%;
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
        color: #CACBCC;
        border: 0;
    }
    
    .pagination > li > a, .pagination > li > span {
        border: 0;
        background-color: rgba(0,0,0,0);
        color: #CACBCC;
    }
    
    .pagination > li > a:hover, .pagination > li > span:hover, .pagination > li > a:focus, .pagination > li > span:focus {
        border :0;
        background-color: #FFF;
        color: #2E2B4A;
    }
    
    .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
        border :0;
        background-color: #FFF;
        color: #2E2B4A;
    }
    
</style>
@stop

@section('full-size-content')

<!--背景-->
<div class="game-home-bg hidden-xs"></div>
<div class="m-game-home-bg hidden-sm hidden-md hidden-lg"></div>

<!--上方資訊顯示區-->
<div class="share-title-area">
    
    <div class="container">
        <div class="row">
            
            <!--左方牌價-->
            <div class="col-sm-6 share-title-col">
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
                        <img src="{{ asset('front/img/share/table_icon_01_white.png') }}">
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
                                {{ number_format($cash_account) }}
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

<div class="container xs-coin-show hidden-sm hidden-md hidden-lg">
    <div class="row">
        <div class="col-xs-6" style="padding-left:0;padding-right:0;">
            <div class="coin-account-area">
                <div class="coin-amount-icon">
                    <img src="{{ asset('front/img/icon/usercoin/user_bg_gold_01.png') }}"/>
                </div>
                <div class="coin-amount-font">
                    {{ number_format($cash_account) }}
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

<!--表單抬頭-->
<div class="container">
    <div class="share-table-title-area">
        <div class="share-table-title">所有拍賣資訊</div>
        <div id="refresh" class="share-refresh"><img src="{{ asset('front/img/share/table_icon_06_03.png') }}"/></div>
    </div>   
    
    <div class="share-table-area">
        <!--掛單-->
        <table id="data_list" class="table">
            <thead>
                <th class="hidden-xs">會員<div class="table-right-border"></div></th>
                <th>數量<div class="table-right-border"></div></th>
                <th>單價<div class="table-right-border"></div></th>
                <th class="hidden-xs">總計<div class="table-right-border"></div></th>
                <th>倒數<div class="table-right-border"></div></th>
                <th></th>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr>
                    <td class="hidden-xs" style="border-right: 1.5px solid #B6B7B9;">{{ $data->seller_user->username }}</td>
                    <td style="border-right: 1.5px solid #B6B7B9;">{{ number_format($data->quantity) }}</td>
                    <td style="border-right: 1.5px solid #B6B7B9;">{{ $data->price }}</td>
                    <td class="hidden-xs" style="border-right: 1.5px solid #B6B7B9;">{{ number_format($data->amount) }}</td>
                    <td style="border-right: 1.5px solid #B6B7B9;">{{ $data->time_left }}</td>
                    <td>
                        @if($data->seller_id != $user->id)
                        <a class="buy" data-id="{{ $data->id }}" data-price="{{ $data->price }}" data-quantity="{{ $data->quantity }}"><img src="{{ asset('front/img/share/table_buy_gary.png') }}"/></a>
                        @else
                        <a class="cancel" data-id="{{ $data->id }}"><img src="{{ asset('front/img/share/table_no_green.png') }}"/></a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!--/.掛單-->
    </div>
    
    <div class="share-table-bottom-area"></div>
    
</div>

@stop

@section('footer-js')
<!-- main-->
<script src="{{ asset('front/js/share_transaction.js') }}"></script>
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
        var id = $('#product_id').val();
        var price = $('#price').val();
        var table = $("#data_list");
        var user_id = '{{ $user->id }}';

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
                [2, "asc"]
            ],
            columns: [
                { className: "hidden-xs" , title: '會員<div class="table-right-border"></div>' },
                { title: '數量<div class="table-right-border"></div>' },
                { title: '單價<div class="table-right-border"></div>' },
                { className: "hidden-xs" , title: '總計<div class="table-right-border"></div>' },
                { title: '倒數<div class="table-right-border"></div>' },
                { title: '' , "orderable": false},
            ],
            "pageLength": 10,
            "pagingType": "simple_numbers",
            "searching": false,
            "bLengthChange" : false,
            "bInfo" : false,
        });

        //購買
        table.on("click", ".buy", function(e) {
            e.preventDefault();
            id = $(this).data('id');
            price = $(this).data('price');
            quantity = $(this).data('quantity');
            total = quantity*price;
            swal({
                title: '購買交易確認',
                text: '<hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="check-price"><div class="check-price-icon"></div><div class="check-price-info">'+price+'</div></div><hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="check-coin-plus"><div class="check-coin-plus-icon"></div>＋'+numeral(quantity).format('0,0')+'</div><div class="check-coin-use"><div class="check-coin-use-icon"></div>－'+numeral(total).format('0,0')+'</div>',
                type: 'warning',
                html:true,
                showCancelButton: true,
                confirmButtonText: '確認',
                cancelButtonText: '取消'
            },function(){
                sendUri = APP_URL + "/shop/share_transaction/deal" ;
                sendData = {'id' : id };
                shareTransactionConfirm(sendUri,sendData,quantity,total,'member_buy');
            });

        });//.購買

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

        //點擊手動更新
        $( "#refresh" ).click(function() {
            refreshData()

        });//.點擊手動更新

        //手動更新表格資料
        function refreshData(){

          $.ajax({
            url:APP_URL + "/shop/share_transaction/cheapest_data",
            type : "GET",
            success:function(msg){  
                   
                var data=JSON.parse(msg);  

                dataSet= [];
                for(var key in data.datas){    
                    if(user_id != data.datas[key]['seller_id']){
                        btn_td = '<a class="buy" data-id="'+data.datas[key]['id']+'" data-price="'+data.datas[key]['price']+'" data-quantity="'+data.datas[key]['quantity']+'"><div class="buy_item"></div></a>';
                    } else {
                        btn_td = '<a class="cancel" data-id="'+data.datas[key]['id']+'"><img src="'+"{{ asset('front/img/share/table_no_green.png') }}"+'"/></a>'
                    }
                  table_obj = [
                    data.datas[key]['seller_username'],
                    numeral(data.datas[key]['quantity']).format('0,0'),
                    data.datas[key]['price'],
                    numeral(data.datas[key]['amount']).format('0,0'),
                    data.datas[key]['time_left'],
                    btn_td
                  ];
                   dataSet.push(table_obj);
                }  

                //更新表格內容
                table.DataTable( {
                    "dom": '<"top"i>rt<"bottom"flp><"clear">',
                    data: dataSet,
                    columns: [
                        { className: "hidden-xs" , title: '會員<div class="table-right-border"></div>' },
                        { title: '數量<div class="table-right-border"></div>' },
                        { title: '單價<div class="table-right-border"></div>' },
                        { className: "hidden-xs" , title: '總計<div class="table-right-border"></div>' },
                        { title: '倒數<div class="table-right-border"></div>' },
                        { title: '' , "orderable": false},
                    ],
                    "order": [[ 1, "asc" ]],
                    "pageLength": 10,
                    "pagingType": "simple_numbers",
                    "searching": false,
                    "bLengthChange" : false,
                    "bInfo" : false,
                    "destroy": true,
                });
                
                $('#data_list tr td:nth-child(1)').css({"border-right": "1.5px solid #B6B7B9"});
                $('#data_list tr td:nth-child(2)').css({"border-right": "1.5px solid #B6B7B9"});
                $('#data_list tr td:nth-child(3)').css({"border-right": "1.5px solid #B6B7B9"});
                $('#data_list tr td:nth-child(4)').css({"border-right": "1.5px solid #B6B7B9"});
                $('#data_list tr td:nth-child(5)').css({"border-right": "1.5px solid #B6B7B9"});
                $('#data_list tr td:nth-child(6)').css({"border-right": "1.5px solid #B6B7B9"});
                
                HoldOn.close();
            },
            beforeSend: function() {
                //顯示搜尋動畫
                HoldOn.open({
                    theme: 'sk-cube-grid',
                    message: "<h4>資料更新中，請稍候</h4>"
                });
            },
            error:function(xhr){
                HoldOn.close();
            }
          }); 
        }
        //.點擊手動更新
        
    });

    
</script>

@stop

