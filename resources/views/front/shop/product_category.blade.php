@extends('layouts.main')
@section('head')
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script>
  $(function() {
    $(".fancybox").fancybox();  
  });
</script>
<style>
    .menu_active{
        background-color: #DCDCDC;
    }
    
    .btn-red {
        background-color: #EA102F;
        color: white;
    }
    
    .btn-red:hover {
        background-color: #d0001e;
        color: white;
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
    
    
    .shop-title-area {
        position: relative;
        margin-top: 30px;
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
    
    
    /*娛樂幣餘額*/
    .amount-area {
        position: relative;
        width: 80%;
        margin-left: 20%;
    }
    
    .account-amount-icon-top {
        position: relative;
        width: 60%;
        margin-left: 10%;
        z-index: 2;
        margin-top: -15px;
    }
    
    .account-amount-icon-top img {
        width: 100%;
    }
    
    .account-amount-bg {
        position: absolute;
        width: 100%;
        left: 0;
        top: 64%;
        z-index: 1;
    }
    
    .account-amount-bg img {
        width: 100%;
    }
    
    .account-amount-font {
        position: relative;
        text-align: right;
        color: #191639;
        font-size: 18px;
        padding-right: 20%;
        z-index: 3;
        margin-top: -6%;
    }

    @media screen and (min-width: 992px) and (max-width: 1399px) {
        .account-amount-font {
            font-size: 14px;
            padding-right: 20%;
            margin-top: -6%;
        }
    }
    
    @media screen and (min-width: 768px) and (max-width: 991px) {
        .account-amount-font {
            font-size: 12px;
            padding-right: 20%;
            margin-top: -4%;
        }
    }
    
    @media screen and (max-width: 767px) {
    
        .amount-area {
            position: relative;
            width: 80%;
            margin-left: 13%;
        }

        .account-amount-icon-top {
            position: relative;
            width: 35%;
            margin-left: 0%;
            margin-top: 0;
            z-index: 2;
        }

        .account-amount-icon-top img {
            width: 100%;
        }

        .account-amount-bg {
            position: absolute;
            width: 100%;
            right: 0%;
            left: auto;
            top: 0;
            z-index: 1;
        }

        .account-amount-bg img {
            width: 100%;
        }

        .account-amount-font {
            position: absolute;
            text-align: right;
            right: 2%;
            top: 58%;
            color: #191639;
            font-size: 18px;
            z-index: 3;
        }
    
    }
    
    /*會員資訊*/
    
    @media screen and (max-width: 767px) {
        .col-table {
            margin-top:10px;
        }
    }
    
    @media screen and (min-width: 768px) {
        .title-row {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 0px 5%;
        }
    }
    
    
    .table-member {
        border-top: 2px solid #191639;
        border-bottom: 2px solid #191639;
    }
    
    @media screen and (min-width: 768px) {
        .table-member {
            margin-bottom: 0;
        }
    }
    
    
    .table-member > thead > tr > th, .table-member > tbody > tr > th, .table-member > tfoot > tr > th, .table-member > thead > tr > td, .table-member > tbody > tr > td, .table-member > tfoot > tr > td {
        border: 1px solid #191639;
        color: #191639;
        font-size: 20px;
        font-weight: bold;
        line-height: 250%;
    }
    
    .table-member tr {
	    background: linear-gradient(to right, rgba(214, 213, 213, 0) , #E5E5E5 , rgba(214, 213, 213, 0));
	}
    
    @media screen and (max-width: 767px) {
        .table-member tr {
            background-attachment:fixed;
        }
    }
    
    @media screen and (min-width: 992px) and (max-width: 1399px) {
        .table-member > thead > tr > th, .table-member > tbody > tr > th, .table-member > tfoot > tr > th, .table-member > thead > tr > td, .table-member > tbody > tr > td, .table-member > tfoot > tr > td {
            font-size: 16px;
            line-height: 200%;
        }
    }
    
    @media screen and (min-width: 768px) and (max-width: 991px) {
        .table-member > thead > tr > th, .table-member > tbody > tr > th, .table-member > tfoot > tr > th, .table-member > thead > tr > td, .table-member > tbody > tr > td, .table-member > tfoot > tr > td {
            font-size: 14px;
            line-height: 180%;
        }
    }
    
    @media screen and (max-width: 767px) {
        .table-member > thead > tr > th, .table-member > tbody > tr > th, .table-member > tfoot > tr > th, .table-member > thead > tr > td, .table-member > tbody > tr > td, .table-member > tfoot > tr > td {
            font-size: 16px;
            line-height: 200%;
        }
    }

    /*娛樂幣及專屬娛樂幣餘額*/
    
    .shop-account-area {
        position: relative;
        width: 90%;
        margin-top: -5px;
    }
    
    .shop-amount-icon {
        position: relative;
        width: 100%;
        margin-left: 0%;
        z-index: 2;
    }
    
    .shop-amount-icon img {
        width: 100%;
    }
    
    .shop-amount-font {
        position: absolute;
        text-align: right;
        right: 12%;
        top: 36%;
        color: white;
        font-size: 18px;
        z-index: 3;
    }
    
    .xs-coin-show {
        margin-top:-30px;
    }
    
    @media screen and (min-width: 768px) and (max-width: 991px) {
        .shop-amount-font {
            top: 26%;
            font-size: 14px;
        }
    }
    
    @media screen and (max-width: 767px) {
        .shop-account-area {
            position: relative;
            width: 100%;
            margin-top: -10px;
        }
    }
    
    .share-title-area {
        padding-bottom:20px;
    }
    
    /*商品類別*/
    
    .accordion-heading {
        position: relative;
        width: 100%;
        height: 80px;
        line-height: 80px;
        padding: 0px 20px;
        font-size: 24px;
        font-weight: bold;
        color: #191639;
        border-top: 2px solid #191639;
    }
    
    .accordion-heading-envelope {
        border-bottom: 2px solid #191639; 
    }
    
    @media screen and (min-width: 768px) {
        .accordion-heading-pro {
            border-bottom: 2px solid #191639; 
        }
    }
    
    .accordion-heading:hover {
        background: linear-gradient(to right, rgba(214, 213, 213, 0) , #E5E5E5 , rgba(214, 213, 213, 0));
    }
    
    .accordion-heading-focus {
        background: linear-gradient(to right, rgba(214, 213, 213, 0) , #E5E5E5 , rgba(214, 213, 213, 0));
    }
    
    .shop-category-icon {
        position: relative;
        width: 60px;
        height: 70px;
        float: left;
    }
    
    .shop-category-icon img {
        position: absolute;
        width: 55px;
        top: 12.5px;
        left: 0;
    }
    
    .shop-toggle-icon {
        position: absolute;
        height: 80px;
        line-height: 80px;
        top: 0;
        right: 40px;
    }
    
    .glyphicon-triangle-bottom {
        color: #0071BC;
    }
    
    @media screen and (max-width: 767px) {
        .accordion-heading {
            height: 60px;
            line-height: 60px;
            font-size: 20px;
        }  
        .shop-category-icon {
            width: 60px;
            height: 55px;
            float: left;
        }

        .shop-category-icon img {
            width: 50px;
            top: 5px;
        }

        .shop-toggle-icon {
            height: 60px;
            line-height: 60px;
        }
    }
    
    /*商品列表*/
    .table-buy {
        text-align: center;
        margin-bottom: 0 !important;
    }
    
    .table-buy > thead > tr > th, .table-buy > tbody > tr > th, .table-buy > tfoot > tr > th, .table-buy > thead > tr > td, .table-buy > tbody > tr > td, .table-buy > tfoot > tr > td {
        border: 1px solid #191639;
        color: #191639;
        font-size: 20px;
        font-weight: bold;
        vertical-align: middle;
    }
    
    @media screen and (max-width: 767px) {
        .table-buy > thead > tr > th, .table-buy > tbody > tr > th, .table-buy > tfoot > tr > th, .table-buy > thead > tr > td, .table-buy > tbody > tr > td, .table-buy > tfoot > tr > td {
            font-size: 16px;
        }    
    }
    
    .tr-top {
        border-top: 2px solid #191639;
    }
    
    .tr-bottom {
        border-bottom: 2px solid #191639;
    }
    
    .table-buy tr a {
        color: #191639;
    }
    
    .td-left {
        border-left: 0 !important;
    }
    
    .td-right {
        border-right: 0 !important;
    }
    
    .form-amount-input {
        border-radius: 30px;
        width: 200px;
    }
    
    @media screen and (max-width: 767px) {
        .form-amount-input {
            width: 120px;
        }
    }
    
    .btn-buy {
        width: 60px;
        height: 39px;
        background: url("{{ asset('front/img/icon/button/btn_buy_off.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    .btn-buy:hover , .btn-buy:focus {
        width: 60px;
        height: 39px;
        background: url("{{ asset('front/img/icon/button/btn_buy_on.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
     @media screen and (max-width: 767px) {
        .btn-buy {
            width: 46px;
            height: 30px;
        }

        .btn-buy:hover , .btn-buy:focus {
            width: 46px;
            height: 30px;
        }
    }
    
    .buy {
        background-color: rgba(0,0,0,0) !important;
        border: 0 !important;
    }
    
    .go_ULG {
        width: 100%;
        border-top: 2px solid #191639;
        padding: 5px 0px;
    }
    
    .go_ULG img {
        width: 70%;
        margin-left: 15%;
    }
    
</style>
@stop 

@section('full-size-content')
@inject('ProductPresenter','App\Presenters\Shop\ProductPresenter')

<!--背景-->
<div class="game-home-bg hidden-xs"></div>
<div class="m-game-home-bg hidden-sm hidden-md hidden-lg"></div>

<!--上方資訊顯示區-->
<div class="share-title-area">
    
    <div class="container">
        <div class="row">
            
            <!--左方牌價-->
            <div class="col-sm-6" style="padding-top:20px;">
                <div class="share-title-left">  
                    <!--牌價-->
                    <div class="share-title-left-info">
                        <div class="share-title-left-info-new-title">
                            最新售價
                        </div>
                        <div class="share-title-left-info-new">
                            {{  $share_product->price }}
                        </div>
                        <div class="share-title-left-info-amount-title">商城娛樂幣餘額</div>
                        <div class="share-title-left-info-amount">{{  number_format($share['now']) }}</div>
                    </div>
                    
                    <!--幣icon-->
                    <div class="share-title-left-icon">
                        <img src="{{ asset('front/img/share/table_icon_01_white.png') }}">
                    </div>
                </div>
            </div>
            
            <!--右方餘額-->
            <div class="col-sm-5">
                <div class="row">
                    <div class="col-xs-12 col-table" style="margin-bottom:10px; padding-left:0; padding-right:0;">
                        <table class="table table-member">
                            <tr>
                                <td style="border-left:0; width:15%; text-align:center;">姓名</td>
                                <td style="width:35%;">{{ $member->name }}</td>
                                <td style="width:15%; text-align:center;">級別</td>
                                <td style="border-right:0; width:35%;">{{ $level  }}<!--(到期時間：{{ $level_expire }})--></td>
                            </tr>
                            <tr>
                                <td style="border-left:0; text-align:center;">帳號</td>
                                <td>{{ $user->username }}</td>
                                <td style="text-align: center;">ID</td>
                                <td style="border-right:0;">{{ $member->member_number }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-6 hidden-xs" style="padding-left:0;padding-right:0;">
                        <div class="coin-account-area">
                            <div class="coin-amount-icon">
                                <img src="{{ asset('front/img/icon/usercoin/user_bg_gold_01.png') }}"/>
                            </div>
                            <div class="coin-amount-font">
                                {{ number_format($cash_account) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 hidden-xs" style="padding-left:0;padding-right:0;">
                        <div class="coin-account-area">
                            <div class="coin-amount-icon">
                                <img src="{{ asset('front/img/icon/usercoin/user_bg_pro_01.png') }}"/>
                            </div>
                            <div class="coin-amount-font">
                                {{ number_format($own_share_amount) }}
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
                    <img src="{{ asset('front/img/icon/usercoin/user_bg_pro_01.png') }}"/>
                </div>
                <div class="coin-amount-font">
                    {{ number_format($own_share_amount) }}
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">
<!--商品列表-->
<div class="accordion" id="product_list" style="position:relative;">
    
    <div class="row">
        <!--娛樂幣/專屬娛樂幣-->
        <div class="col-sm-6">
            
            <!--娛樂幣-->
            <div class="accordion-group">
                
                <!--商品標題-->
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_{{ $category_items[0]->id }}">
                    <div class="accordion-heading">
                        <div class="shop-category-icon">
                            <img src="{{ asset('front/img/icon/currency/currency_ulg_02.png') }}"/>
                        </div>
                        {{ $category_items[0]->name }}
                        <div class="shop-toggle-icon">
                            <span class="glyphicon glyphicon-triangle-right"></span>
                        </div>
                    </div>
                </a>
                
                <!--展開內容-->
                <div id="collapse_{{ $category_items[0]->id }}" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <div class="go_ULG">
                            <a href="{{ route('front.shop.share_transaction.current_price') }}">
                                <img src="{{ asset('front/img/icon/button/go_Ulg_table_icon.png') }}"/>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--專屬娛樂幣-->
            <div class="accordion-group">
                
                <!--商品標題-->
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_{{ $category_items[1]->id }}">
                    <div class="accordion-heading">
                        <div class="shop-category-icon">
                            <img src="{{ asset('front/img/icon/currency/currency_pro_02.png') }}"/>
                        </div>
                        {{ $category_items[1]->name }}
                        <div class="shop-toggle-icon">
                            <span class="glyphicon glyphicon-triangle-right"></span>
                        </div>
                    </div>
                </a>
                
                <!--展開內容-->
                <div id="collapse_{{ $category_items[1]->id }}" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <table class="table table-buy" id="data_list">
                            <tbody>
                            @foreach($category_items[1]->products as $data)
                                @if($data->status == 1)
                                <tr class="tr-top">
                                    <td class="td-left" colspan="2">剩餘數量</td>
                                    <td class="td-right" style="width:30%;">金額</td>
                                </tr>
                                <tr>
                                    <td class="td-left" colspan="2">
                                        依顯示餘額為主
                                    </td>
                                    <td class="td-right">
                                        {{ number_format($data->price) }}
                                    </td>
                                </tr>
                                <tr class="tr-bottom">
                                    <td class="td-left" style="width:30%;">購買數量</td>
                                    <td style="width:40%;">
                                        <input type="number" class="form-control form-amount-input" id="quantity_{{ $data->id }}" min="1" max="{{ $ProductPresenter->showQuantity($data,['share' => $share['now'], 'own_share' => $own_share_amount]) }}"  placeholder="購買數量" >
                                    </td>
                                    <td class="td-right">
                                        <button class="buy" data-id="{{ $data->id }}" data-name="{{ $data->name }}" data-min="1"><div class="btn-buy"></div></button>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!--拍賣卡-->
            <div class="accordion-group">
                
                <!--商品標題-->
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_{{ $category_items[5]->id }}">
                    <div class="accordion-heading accordion-heading-pro">
                        <div class="shop-category-icon">
                            <img src="{{ asset('front/img/icon/card/card_sale_01.png') }}"/>
                        </div>
                        {{ $category_items[5]->name }}
                        <div class="shop-toggle-icon">
                            <span class="glyphicon glyphicon-triangle-right"></span>
                        </div>
                    </div>
                </a>
                
                <!--展開內容-->
                <div id="collapse_{{ $category_items[5]->id }}" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <table class="table table-buy" id="data_list">
                            <tbody>
                            @foreach($category_items[5]->products as $data)
                                @if($data->status == 1)
                                <tr class="tr-top">
                                    <td class="td-left" colspan="2">剩餘數量</td>
                                    <td class="td-right" style="width:30%;">金額</td>
                                </tr>
                                <tr>
                                    <td class="td-left" colspan="2">
                                        {{ $ProductPresenter->showQuantity($data,['share' => $share['now'], 'own_share' => $own_share_amount]) }}
                                    </td>
                                    <td class="td-right">
                                        {{ number_format($data->price) }}
                                    </td>
                                </tr>
                                <tr class="tr-bottom">
                                    <td class="td-left" style="width:30%;">購買數量</td>
                                    <td style="width:40%;">
                                        <input type="number" class="form-control form-amount-input" id="quantity_{{ $data->id }}" min="1" max="{{ $ProductPresenter->showQuantity($data,['share' => $share['now'], 'own_share' => $own_share_amount]) }}"  placeholder="購買數量" >
                                    </td>
                                    <td class="td-right">
                                        <button class="buy" data-id="{{ $data->id }}" data-name="{{ $data->name }}" data-min="1"><div class="btn-buy"></div></button>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
 
        </div>


        
        <!--其他項目-->
        <div class="col-sm-6">
           
            <!--VIP-->
            <div class="accordion-group">
                
                <!--商品標題-->
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_{{ $category_items[2]->id }}">
                    <div class="accordion-heading">
                        <div class="shop-category-icon">
                            <img src="{{ asset('front/img/icon/card/card_vip_01.png') }}"/>
                        </div>
                        {{ $category_items[2]->name }}
                        <div class="shop-toggle-icon">
                            <span class="glyphicon glyphicon-triangle-right"></span>
                        </div>
                    </div>
                </a>
                
                <!--展開內容-->
                <div id="collapse_{{ $category_items[2]->id }}" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <table class="table table-buy" id="data_list">
                            <tbody>
                            @foreach($category_items[2]->products as $data)
                                @if($data->status == 1)
                                <tr class="tr-top">
                                    <td class="td-left" style="width:30%;">品名</td>
                                    <td style="width:40%;">價格</td>
                                    <td class="td-right" style="width:30%;">剩餘數量</td>
                                </tr>
                                <tr>
                                    <td class="td-left">
                                        @if($data->product_category_id == 1 || $data->product_category_id == 4 || $data->product_category_id == 5)
                                        <a href="{{ route('front.shop.product.show',[$data->id,1]) }}" class="fancybox fancybox.iframe">
                                            @if($data->icon != '' && $data->icon !=' ')
                                            <img src="{{ asset($data->icon) }}" width="50px">
                                            @endif
                                            {{ $data->name }}
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        {{ number_format($data->price) }}
                                    </td>
                                    <td class="td-right">
                                        {{ $ProductPresenter->showQuantity($data,['share' => $share['now'], 'own_share' => $own_share_amount]) }}
                                    </td>
                                </tr>
                                <tr class="tr-bottom">
                                    <td class="td-left">購買數量</td>
                                    <td>
                                        <input type="number" class="form-control form-amount-input" id="quantity_{{ $data->id }}" min="1" max="{{ $ProductPresenter->showQuantity($data,['share' => $share['now'], 'own_share' => $own_share_amount]) }}"  placeholder="購買數量" value="1">
                                    </td>
                                    <td class="td-right">
                                        <button class="buy" data-id="{{ $data->id }}" data-name="{{ $data->name }}" data-min="1"><div class="btn-buy"></div></button>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!--推薦卡-->
            <div class="accordion-group">
                
                <!--商品標題-->
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_{{ $category_items[3]->id }}">
                    <div class="accordion-heading">
                        <div class="shop-category-icon">
                            <img src="{{ asset('front/img/icon/card/card_invite_01.png') }}"/>
                        </div>
                        {{ $category_items[3]->name }}
                        <div class="shop-toggle-icon">
                            <span class="glyphicon glyphicon-triangle-right"></span>
                        </div>
                    </div>
                </a>
                
                <!--展開內容-->
                <div id="collapse_{{ $category_items[3]->id }}" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <table class="table table-buy" id="data_list">
                            <tbody>
                            @foreach($category_items[3]->products as $data)
                                @if($data->status == 1)
                                <tr class="tr-top">
                                    <td class="td-left" style="width:30%;">品名</td>
                                    <td style="width:40%;">價格</td>
                                    <td class="td-right" style="width:30%;">剩餘數量</td>
                                </tr>
                                <tr>
                                    <td class="td-left">
                                        @if($data->product_category_id == 1 || $data->product_category_id == 4 || $data->product_category_id == 5)
                                        <a href="{{ route('front.shop.product.show',[$data->id,1]) }}" class="fancybox fancybox.iframe">
                                            @if($data->icon != '' && $data->icon !=' ')
                                            <img src="{{ asset($data->icon) }}" width="50px">
                                            @endif
                                            {{ $data->name }}
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        {{ number_format($data->price) }}
                                    </td>
                                    <td class="td-right">
                                        {{ $ProductPresenter->showQuantity($data,['share' => $share['now'], 'own_share' => $own_share_amount]) }}
                                    </td>
                                </tr>
                                <tr class="tr-bottom">
                                    <td class="td-left">購買數量</td>
                                    <td>
                                        <input type="number" class="form-control form-amount-input" id="quantity_{{ $data->id }}" min="1" max="{{ $ProductPresenter->showQuantity($data,['share' => $share['now'], 'own_share' => $own_share_amount]) }}"  placeholder="購買數量" value="1">
                                    </td>
                                    <td class="td-right">
                                        <button class="buy" data-id="{{ $data->id }}" data-name="{{ $data->name }}" data-min="1"><div class="btn-buy"></div></button>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            
            <!--紅包卡-->
            <div class="accordion-group">
                
                <!--商品標題-->
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_{{ $category_items[4]->id }}">
                    <div class="accordion-heading accordion-heading-envelope">
                        <div class="shop-category-icon">
                            <img src="{{ asset('front/img/icon/card/card_envelope_01.png') }}"/>
                        </div>
                        {{ $category_items[4]->name }}
                        <div class="shop-toggle-icon">
                            <span class="glyphicon glyphicon-triangle-right"></span>
                        </div>
                    </div>
                </a>
                
                <!--展開內容-->
                <div id="collapse_{{ $category_items[4]->id }}" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <table class="table table-buy" id="data_list">
                            <tbody>
                            @foreach($category_items[4]->products as $data)
                                @if($data->status == 1)
                                <tr class="tr-top">
                                    <td class="td-left" style="width:30%;">品名</td>
                                    <td style="width:40%;">價格</td>
                                    <td class="td-right" style="width:30%;">剩餘數量</td>
                                </tr>
                                <tr>
                                    <td class="td-left">
                                        @if($data->product_category_id == 1 || $data->product_category_id == 4 || $data->product_category_id == 5)
                                        <a href="{{ route('front.shop.product.show',[$data->id,1]) }}" class="fancybox fancybox.iframe">
                                            {{ $data->name }}
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        {{ number_format($data->price) }}
                                    </td>
                                    <td class="td-right">
                                        {{ $ProductPresenter->showQuantity($data,['share' => $share['now'], 'own_share' => $own_share_amount]) }}
                                    </td>
                                </tr>
                                <tr class="tr-bottom">
                                    <td class="td-left">購買數量</td>
                                    <td>
                                        <input type="number" class="form-control form-amount-input" id="quantity_{{ $data->id }}" min="1" max="{{ $ProductPresenter->showQuantity($data,['share' => $share['now'], 'own_share' => $own_share_amount]) }}"  placeholder="購買數量" value="1">
                                    </td>
                                    <td class="td-right">
                                        <button class="buy" data-id="{{ $data->id }}" data-name="{{ $data->name }}" data-min="1"><div class="btn-buy"></div></button>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            
            
            
            
        </div>
    </div>

    
</div>
    <!--/.商品列表-->
    
</div><!--/container-->





@stop

@section('footer-js')

<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="{{ asset('plugins/js-webshim/minified/polyfiller.js') }}"></script>
<script>
    $(document).ready(function() {
   
        var table = $("#product_list");
        //千分位
        webshims.setOptions('forms-ext', {
            replaceUI: 'true',
            types: 'number'
        });
        webshims.polyfill('forms forms-ext');
        //購買
        table.on("click", ".buy", function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');
            var quantity = $('#quantity_'+id).val();
            var min = $(this).data('min');
            if(parseInt(quantity) <= 0 || !$('#quantity_'+id).val()){
                swal("Failed", "請重新確認購買數量",'error');
                return false;
            }
            swal({
                title: '操作確認',
                text: '確認購買 '+name+' *'+numeral(quantity*min).format('0,0')+'?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '確認',
                cancelButtonText: '取消'
            },function(){
                sendUri = APP_URL + "/shop/product/buy" ;
                sendData = {'id' : id ,"quantity":(quantity*min)};
                system_ajax(sendUri,sendData,"POST",function(data){
                    window.location.href=APP_URL+"/shop/my_product";
                },function(data){});
            });

        });//.購買
        
    });


    $('.collapse').on('shown.bs.collapse', function(){
    $(this).parent().find(".glyphicon-triangle-right").removeClass("glyphicon-triangle-right").addClass("glyphicon-triangle-bottom");
    $(this).parent().find(".accordion-heading").addClass("accordion-heading-focus");
    }).on('hidden.bs.collapse', function(){
    $(this).parent().find(".glyphicon-triangle-bottom").removeClass("glyphicon-triangle-bottom").addClass("glyphicon-triangle-right");
    $(this).parent().find(".accordion-heading").removeClass("accordion-heading-focus");
    });
    
</script>

@stop
