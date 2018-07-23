@inject('chessService', 'App\Services\Game\SSE\ChessService')
@extends('layouts.cn_chess_main')
@section('head')
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<!--象棋相關-->
<link rel="stylesheet" href="{{ asset('front/css/cn_chess/main.css') }}?v=20180302"> 
<link rel="stylesheet" href="{{ asset('front/css/cn_chess/web.css') }}?v=20180302"> 
<link rel="stylesheet" href="{{ asset('front/css/cn_chess/mcount.css') }}?v=20180302"> 
<style>

    .sweet-alert {
        background: url("{{ asset('front/img/chess/phone/popup_bet_bg_01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        padding: 0px 35px;
        width: 384px;
        height: 500px;
        margin-left: -187px;
    }
    
    .sweet-alert .sa-icon {
        position: fixed;
        left: 50%;
        margin: 12px auto;
        margin-left: -38px;
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
        width: 50px;
        height: 50px;
        background: url("{{ asset('front/img/chess/phone/bet_icon/currency1.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    .check_2 {
        width: 50px;
        height: 50px;
        background: url("{{ asset('front/img/chess/phone/bet_icon/currency2.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    .check_3 {
        width: 50px;
        height: 50px;
        background: url("{{ asset('front/img/chess/phone/bet_icon/currency3.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    .check_4 {
        width: 50px;
        height: 50px;
        background: url("{{ asset('front/img/chess/phone/bet_icon/currency4.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    
    
    .check_chess {
        width: 50px;
        height: 50px;
        background: url("{{ asset('front/img/chess/phone/bet_icon/currency4.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    .chess_king {
        width: 100px;
        height: 50px;
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
    
    @media screen and (min-width: 768px) {
        
        .sweet-alert p {
            padding-right: 15px;
        }

        .sweet-alert p::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0);
            border-radius: 10px;
            background-color: rgba(0,0,0,0);
        }

        .sweet-alert p::-webkit-scrollbar
        {
            width: 10px;
            background-color: #3C0000;
            border-left: 3px solid #f6d3b0;
            border-right: 3px solid #f6d3b0;
        }

        .sweet-alert p::-webkit-scrollbar-thumb
        {
            border-radius: 10px;
            background-color: #3C0000;
        }
    
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
</style>
<script>
        var page_mode = 'web';
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

<h4 class="hidden-sm hidden-md hidden-lg" style="color:white; text-align:center; line-height:180%;">使用行動裝置瀏覽？<br>請重新進入遊戲以載入行動版頁面</h4>
<center><a class="btn btn-md btn-primary hidden-sm hidden-md hidden-lg" href="{{ route('front.game.category.index','cn_chess') }}">重新載入</a></center>


<div class="row hidden-xs">
    <!--期別、開獎、倒數-->
    <div id="header_part">
        @include('front.game.cn_chess.web.header')
    </div>
</div>

<div class="row hidden-xs">
    <div class="col-sm-2">
        <!--目前餘額-->
		<div id="amount_detail_part">
			@include('front.game.cn_chess.web.amount_detail')
		</div>
    </div>
    <div class="col-sm-6">
        <!--棋盤-->
		<div id="checkerboard_part">
			@include('front.game.cn_chess.web.checkerboard')
		</div>
    </div>
    <div class="col-sm-2">
        <!--下注-->
		<div id="bet_part">
			@include('front.game.cn_chess.web.bet')
		</div>
    </div>
</div>

<!--下注紀錄-->
<div id="bet_record_part" class="hiddex-xs">
    @include('front.game.cn_chess.web.bet_record')
</div>
<div id="bet_record_part_animate" class="hiddex-xs"></div>

<!--歷史開獎-->
<div id="history_lottery_part" class="hiddex-xs">
    @include('front.game.cn_chess.web.history_lottery')
</div>
<div id="history_lottery_close_animate" class="hiddex-xs"></div>

<!--結算小計-->
<div id="latest_count">
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
<!--象棋相關-->
<script src="{{ asset('front/js/cn_chess/main.js') }}?v=20180302"></script>
<script src="{{ asset('front/js/cn_chess/web.js') }}?v=20180302"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="{{ asset('plugins/js-webshim/minified/polyfiller.js') }}"></script>
<script>
	

    $(document).ready(function() {
    	//千分位
        webshims.setOptions('forms-ext', {
            replaceUI: 'auto',
            types: 'number'
        });
        webshims.polyfill('forms forms-ext');
        //refreshToken('/member-token');

    });



</script>
<script>
//下注紀錄
function bet_latest_show(){
    document.getElementById("bet_record_part").style.display = "block";
    document.getElementById("info_bg").style.display = "block";
}
    
function bet_record_content_show(){
    document.getElementById("bet_record_content").style.display = "block";
}
    
function bet_record_close(){
    document.getElementById("bet_record_part").style.display = "none";
    document.getElementById("bet_record_content").style.display = "none";
    document.getElementById("bet_record_part_animate").style.display = "block";
    document.getElementById("info_bg").style.display = "none";
}
 
        
function bet_record_close_animate_end(){
    document.getElementById("bet_record_part_animate").style.display = "none";
}
  
function bet_result_close(){
    result_status = 1;
    $('#latest_count').css('display','none'); 
    $('#count_bg').css('display','none');
}
 
//歷史開獎
function bet_history_show(){
    document.getElementById("history_lottery_part").style.display = "block";
    document.getElementById("info_bg").style.display = "block";
}
    
function bet_history_content_show(){
    document.getElementById("history_lottery_content").style.display = "block";
}
    
function bet_history_close(){
    document.getElementById("history_lottery_part").style.display = "none";
    document.getElementById("history_lottery_content").style.display = "none";
    document.getElementById("history_lottery_close_animate").style.display = "block";
    document.getElementById("info_bg").style.display = "none";
}
 
        
function bet_history_close_animate_end(){
    document.getElementById("history_lottery_close_animate").style.display = "none";
}
    
</script>
@stop
