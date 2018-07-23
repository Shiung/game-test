@inject('chessService', 'App\Services\Game\SSE\ChessService')
@extends('layouts.cn_chess_main')
@section('head')
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />

<!--象棋相關-->
<link rel="stylesheet" href="{{ asset('front/css/cn_chess/main.css') }}?v=20180302"> 
<link rel="stylesheet" href="{{ asset('front/css/cn_chess/mobile.css') }}?v=20180302"> 
<link rel="stylesheet" href="{{ asset('front/css/cn_chess/mcount.css') }}?v=20180302"> 
<style>

    .sweet-alert {
        background: url("{{ asset('front/img/chess/phone/popup_bet_bg_01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        padding: 0px 35px;
        height: 510px;
    }
    
    .sweet-alert .sa-icon {
        position: fixed;
        left: 50%;
        margin: 12px auto;
        margin-left: -43px;
    }
    
    .sweet-alert h2 {
        margin-top: 100px;
        margin-bottom: 10px;
        color: #3C0000;
    }
    
    .sweet-alert p {
        height: 250px;
        overflow-y: scroll;
        color: #3C0000;
    }
    
    /*i7大小～plus以下*/
    @media screen and (min-width: 375px) and (max-width: 413px) {

        .sweet-alert {
            height: 450px;
        }
        
        .sweet-alert p {
            height: 200px;
            overflow-y: scroll;
            color: #3C0000;
        }

    }

    /*i5大小～i7以下*/
    @media screen and (max-width: 374px) {

        .sweet-alert {
            height: 400px;
        }
        
        .sweet-alert p {
            height: 150px;
            overflow-y: scroll;
            color: #3C0000;
        }

    }

    
    .sweet-alert button {
        margin-top: 10px;
        
        padding: 8px 25px;
    }
    
    .confirm {
        background-color: #E4002B !important;
    }
    
    .cancel {
        background-color: #00A3E0 !important;
    }
    
    .sweet-alert button:hover {
        background-color: #58595B !important;
    }
    
    .sweet-alert .sa-icon.sa-warning {
        background: url("{{ asset('front/img/chess/phone/popup_bet_bg_icon_03.gif') }}");
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
    
    .sweet-alert .sa-icon.sa-error {
        background: url("{{ asset('front/img/chess/phone/popup_bet_bg_icon_02.gif') }}");
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
    
    
    
    .sweet-alert .sa-icon.sa-success {
        background: url("{{ asset('front/img/chess/phone/popup_bet_bg_icon_01.gif') }}");
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
    
    
    
    .sweet-gold {
        width: 100%;
        height: 0;
        padding-bottom: 35%;
        background: url("{{ asset('front/img/icon/usercoin/user_bg_gold_01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        text-align: right;
        line-height: 55px;
        padding-right: 15px;
        color: white;
    }
    
    .sweet-red {
        width: 100%;
        height: 0;
        padding-bottom: 35%;
        background: url("{{ asset('front/img/icon/usercoin/user_bg_bonus_01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        text-align: right;
        line-height: 55px;
        padding-right: 15px;
        color: white;
    }
    
    .sweet-ulg {
        width: 100%;
        height: 0;
        padding-bottom: 35%;
        background: url("{{ asset('front/img/icon/usercoin/user_bg_ulg_01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        text-align: right;
        line-height: 55px;
        padding-right: 15px;
        color: white;
    }
    
    .sweet-gift {
        width: 100%;
        height: 0;
        padding-bottom: 35%;
        background: url("{{ asset('front/img/icon/usercoin/user_bg_gift_01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        text-align: right;
        line-height: 55px;
        padding-right: 15px;
        color: white;
    }
    
    .金幣 {
        width: 50px;
        height: 50px;
        background: url("{{ asset('front/img/chess/phone/bet_icon/currency1.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    .娛樂幣 {
        width: 50px;
        height: 50px;
        background: url("{{ asset('front/img/chess/phone/bet_icon/currency3.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    .禮券 {
        width: 50px;
        height: 50px;
        background: url("{{ asset('front/img/chess/phone/bet_icon/currency2.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    .紅利點數 {
        width: 50px;
        height: 50px;
        background: url("{{ asset('front/img/chess/phone/bet_icon/currency4.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    
    .check_1 {
        width: 40px;
        height: 40px;
        background: url("{{ asset('front/img/chess/phone/bet_icon/currency1.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    .check_2 {
        width: 40px;
        height: 40px;
        background: url("{{ asset('front/img/chess/phone/bet_icon/currency2.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    .check_3 {
        width: 40px;
        height: 40px;
        background: url("{{ asset('front/img/chess/phone/bet_icon/currency3.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    .check_4 {
        width: 40px;
        height: 40px;
        background: url("{{ asset('front/img/chess/phone/bet_icon/currency4.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    
    
    .check_chess {
        width: 40px;
        height: 40px;
        background: url("{{ asset('front/img/chess/phone/bet_icon/currency4.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    .chess_king {
        width: 80px;
        height: 40px;
        background: url("{{ asset('front/img/chess/phone/chess/12.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .chess_guard {
        background: url("{{ asset('front/img/chess/phone/chess/35.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .chess_advisor {
        background: url("{{ asset('front/img/chess/phone/chess/46.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .chess_elephant {
        background: url("{{ asset('front/img/chess/phone/chess/79.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .chess_minister {
        background: url("{{ asset('front/img/chess/phone/chess/810.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .chess_car {
        background: url("{{ asset('front/img/chess/phone/chess/1113.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .chess_rook {
        background: url("{{ asset('front/img/chess/phone/chess/1214.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .chess_horse {
        background: url("{{ asset('front/img/chess/phone/chess/1517.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .chess_knight {
        background: url("{{ asset('front/img/chess/phone/chess/1618.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .chess_bag {
        background: url("{{ asset('front/img/chess/phone/chess/1921.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .chess_canoon {
        background: url("{{ asset('front/img/chess/phone/chess/2022.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .chess_black {
        background: url("{{ asset('front/img/chess/phone/chess/B.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .chess_red {
        background: url("{{ asset('front/img/chess/phone/chess/R.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .deposit-link {
        position: relative;
        width: 60%;
        height: 0;
        margin-top: 5px;
        margin-left: 20%;
        padding-bottom: 30%;
        background: url("{{ asset('front/img/chess/phone/overage_icon_04.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        
    }
    
    #amount_detail_part {
        margin-top: 6px;
    }
    
    
    .m-amount-detail-area {
        position: relative;
        width: 100%;
    }
    
    .m-amount-detail-area img {
        width: 100%;
    }
    
    .m-amount-detail {
        position: absolute;
        color: white;
        font-size: 14px;
        right: 15%;
        top: 33%;
        font-weight: bold;
    }
    
    /*i7大小～plus以下*/
    @media screen and (min-width: 375px) and (max-width: 413px) {

        .m-amount-detail {
            font-size: 12px;
            top: 34%;
        }

    }

    /*i5大小～i7以下*/
    @media screen and (max-width: 374px) {

        .m-amount-detail {
            font-size: 12px;
        }

    }
    
</style>
<script>
    var page_mode = 'mobile';
</script>
@stop 

@section('content')

<!-- SSE -->
@include('front.game.cn_chess.server-sent')

<!--
<h1>{{ $page_title }}</h1>
-->

<!--路徑
<ol class="breadcrumb">
    <li class="breadcrumb-item">遊戲大廳</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>-->
<!--/.路徑-->

<h4 class="hidden-xs" style="color:white; text-align:center; line-height:180%;">使用電腦瀏覽？<br>請重新進入遊戲以載入電腦版頁面</h4>
<center><a class="btn btn-md btn-primary hidden-xs" href="{{ route('front.game.category.index','cn_chess') }}">重新載入</a></center>

<!--最新開獎-->
<div id="latest_lottery_part" class="hidden-sm hidden-md hidden-lg">
	@include('front.game.cn_chess.mobile.latest_lottery')
</div>
<div style="clear:both;"></div>

<!--期別倒數-->
<div id="header_part" class="hidden-sm hidden-md hidden-lg">
	@include('front.game.cn_chess.mobile.header')
</div>

<!--棋盤-->
<div id="checkerboard_part" class="hidden-sm hidden-md hidden-lg">
	@include('front.game.cn_chess.mobile.checkerboard')
</div>

<!--目前餘額-->
<div id="amount_detail_part" class="hidden-sm hidden-md hidden-lg">
    @include('front.game.cn_chess.mobile.amount_detail')
</div>

@include('front.game.cn_chess.mobile.bet')

<!--下注紀錄-->
<div id="bet_record_part" class="hidden-sm hidden-md hidden-lg">
	@include('front.game.cn_chess.mobile.bet_record')
</div>
<div id="bet_record_part_animate" class="hidden-sm hidden-md hidden-lg"></div>

<!--歷史開獎-->
<div id="history_lottery_part" class="hidden-sm hidden-md hidden-lg">
	@include('front.game.cn_chess.mobile.history_lottery')
</div>
<div id="history_lottery_close_animate" class="hidden-sm hidden-md hidden-lg">
    
</div>

<!--結算小計-->
<div id="latest_count" class="hidden-sm hidden-md hidden-lg">
    @include('front.game.cn_chess.web.bet_result')
</div>



@stop

@section('outer-area')
<div id="info_bg" class="hiddex-xs"></div>
<div id="count_bg" class="hiddex-xs"></div>
<div id="countdown">
    <div class="dimmed"></div>
    <div class="bg"></div>
    <div class="count-wrap">
        <div class="circle"></div>
        <div class="count">
            <span class="number-1"></span>
            <span class="number-2"></span>
            <span class="number-3"></span>
            <span class="number-4"></span>
            <span class="number-5"></span>
        </div>
    </div>
</div>
@stop

@section('footer-js')



<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script>
  $(function() {
    $(".fancybox").fancybox();  
  });
</script>


<!--象棋相關-->
<script src="{{ asset('front/js/cn_chess/main.js') }}?v=20180302"></script>
<script src="{{ asset('front/js/cn_chess/mobile.js') }}?v=20180302"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="{{ asset('plugins/js-webshim/minified/polyfiller.js') }}"></script>

<script>
//下注紀錄
function m_bet_latest_open(){
    document.getElementById("bet-latest-btn-open").style.display = "block";
    document.getElementById("bet-latest-btn-open").classList.add('bet-latest-btn-open');
    document.getElementById("bet-latest-btn-close").style.display = "none";
    document.getElementById("bet-latest-btn-back").style.display = "block";
}
function m_bet_latest_open_animate(){
    document.getElementById("bet-latest-btn-open").classList.add('bet-latest-btn-open-animate');
    document.getElementById("bet-latest-btn-back").classList.add('bet-latest-btn-back-animate');
}    
    
function m_bet_latest_back(){
    document.getElementById("bet-latest-btn-open").classList.remove('bet-latest-btn-open-animate');
    document.getElementById("bet-latest-btn-back").classList.remove('bet-latest-btn-back-animate');
    document.getElementById("bet-latest-btn-close").style.display = "block";
    document.getElementById("bet-latest-btn-open").style.display = "none";
    document.getElementById("bet-latest-btn-back").style.display = "none";
}
   
function m_bet_latest_show(){
    document.getElementById("bet-latest-btn-open").classList.remove('bet-latest-btn-open-animate');
    document.getElementById("bet-latest-btn-back").classList.remove('bet-latest-btn-back-animate');
    document.getElementById("bet-latest-btn-close").style.display = "block";
    document.getElementById("bet-latest-btn-open").style.display = "none";
    document.getElementById("bet-latest-btn-back").style.display = "none";
    document.getElementById("bet_record_part").style.display = "block";
}
    
function m_bet_record_content_show(){
    document.getElementById("bet_record_content").style.display = "block";
}
    
function m_bet_record_close(){
    document.getElementById("bet_record_part").style.display = "none";
    document.getElementById("bet_record_content").style.display = "none";
    document.getElementById("bet_record_part_animate").style.display = "block";
}
 
        
function m_bet_record_close_animate_end(){
    document.getElementById("bet_record_part_animate").style.display = "none";
}
    
//歷史開獎
function m_bet_history_open(){
    document.getElementById("bet-history-btn-open").style.display = "block";
    document.getElementById("bet-history-btn-open").classList.add('bet-history-btn-open');
    document.getElementById("bet-history-btn-close").style.display = "none";
    document.getElementById("bet-history-btn-back").style.display = "block";
}
function m_bet_history_open_animate(){
    document.getElementById("bet-history-btn-open").classList.add('bet-history-btn-open-animate');
    document.getElementById("bet-history-btn-back").classList.add('bet-history-btn-back-animate');
} 
    
function m_bet_history_back(){
    document.getElementById("bet-history-btn-open").classList.remove('bet-history-btn-open-animate');
    document.getElementById("bet-history-btn-back").classList.remove('bet-history-btn-back-animate');
    document.getElementById("bet-history-btn-close").style.display = "block";
    document.getElementById("bet-history-btn-open").style.display = "none";
    document.getElementById("bet-history-btn-back").style.display = "none";
}
   
function m_bet_history_show(){
    document.getElementById("bet-history-btn-open").classList.remove('bet-history-btn-open-animate');
    document.getElementById("bet-history-btn-back").classList.remove('bet-history-btn-back-animate');
    document.getElementById("bet-history-btn-close").style.display = "block";
    document.getElementById("bet-history-btn-open").style.display = "none";
    document.getElementById("bet-history-btn-back").style.display = "none";
    document.getElementById("history_lottery_part").style.display = "block";
}
    
function m_bet_history_content_show(){
    document.getElementById("history_lottery_content").style.display = "block";
}
    
function m_bet_history_close(){
    document.getElementById("history_lottery_part").style.display = "none";
    document.getElementById("history_lottery_content").style.display = "none";
    document.getElementById("history_lottery_close_animate").style.display = "block";
}
 
        
function m_bet_history_close_animate_end(){
    document.getElementById("history_lottery_close_animate").style.display = "none";
}
    
function bet_result_close(){
    result_status = 1;
    $('#latest_count').css('display','none'); 
    $('#count_bg').css('display','none');
}
    
function go_to_deposit(){
    window.open("{{  route('front.shop.charge.index')  }}","_self");
}
    
   
$(document).ready(function() {
    //refreshToken('/member-token');

    //千分位
    webshims.setOptions('forms-ext', {
        replaceUI: 'auto',
        types: 'number'
    });
    webshims.polyfill('forms forms-ext');

});
    
</script>

@stop
