@extends('layouts.main')
@section('head')
<!--象棋相關-->
<link rel="stylesheet" href="{{ asset('front/css/cn_chess/main.css') }}"> 
<style>
    
    html,body {
        width: 100%;
    }
    
    .menu_active{
        background-color: #DCDCDC;
    }
    
    .m-chess-home-bg { 
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: url("{{ asset('front/img/chess/phone/back_01.png') }}") no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        z-index: 0;
    }
    
    .chess-home-bg {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: url("{{ asset('front/img/chess/web/back_01.png') }}") no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        z-index: 0;
    }
    
    .chess-back-logo {
        position: relative;
        width: 40%;
        margin-left: 30%;
    }
    
    .chess-back-logo img {
        width: 100%;
    }
    
    .chess-banner {
        position: relative;
        width: 90%;
        margin-left: 5%;
        margin-top: -8%;
    }
    
    .chess-banner img {
        width: 100%;
    }
    
    .m-banner {
        position: relative;
        width: 100%;
        margin-left: 0%;
        margin-top: -12%;
    }
    
    .m-banner img {
        width: 100%;
    }
    
    .chess-btn-area {
        position: relative;
        width: 76%;
        margin-left: 12%;
        margin-top: -3%;
    }
    
    .chess-btn-img {
        width: 100%;
        cursor: pointer;
    }
    
    @media screen and (min-width: 992px) and (max-width: 1399px) {

        .chess-back-logo {
            width: 30%;
            margin-left: 35%;
        }
        
        .chess-banner {
            width: 70%;
            margin-left: 15%;
            margin-top: -6%;
        }
        
        .chess-btn-area {
            width: 56%;
            margin-left: 22%;
            margin-top: -2%;
        }

    }
    
    @media screen and (max-width: 767px) {
        
        .chess-back-logo {
            width: 80%;
            margin-left: 10%;
            margin-top: 5%;
        }
        
        .chess-btn-area {
            position: relative;
            width: 80%;
            margin-left: 10%;
        }

        .chess-btn-img {
            width: 100%;
        }
        
    }
    
    .btn-rule {
        position: fixed;
        width: 120px;
        bottom: 0;
        left: 50%;
        margin-left: -60px;
    }
    
    #rule-click {
        width: 100%;
        cursor: pointer;
    }
    
    #rule-open {
        display: none;
        position: absolute;
        width: 100%;
        bottom: -100px;
        cursor: pointer;
    }
    

    
    @keyframes open {
      0% {
        bottom: -100px;
      }
      100% {
        bottom: 0px;
      }
    }
    
    @media screen and (max-width: 767px) {
        
        @keyframes open {
          0% {
            bottom: -80px;
          }
          100% {
            bottom: 0px;
          }
        }
        
        .btn-rule {
            width: 100px;
            margin-left: -50px;
        }
        
    }
    
    .rule-open-animate {
        animation: open 0.5s steps(100) 1;
        animation-fill-mode: forwards;
    }
    
    #info_bg {
        display: none;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 98;
        background-color: rgba(25, 22, 57, 0.5);
    }
    
    #rule {
        display: none;
        position: fixed;
        width: 650px;
        height: 550px;
        top: 30.5%;
        left: 50%;
        margin-left: -325px;
        background: url("{{ asset('front/img/chess/phone/chess-open-cross_01.gif') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        z-index: 99;
        padding: 30px 4%;

    }

    #rule_content {
        display: none;
    }

    #rule_close_animate {
        display: none;
        position: fixed;
        width: 650px;
        height: 550px;
        top: 30.5%;
        left: 50%;
        margin-left: -325px;
        background: url("{{ asset('front/img/chess/phone/chess-close-cross_01.gif') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        z-index: 99;
        padding: 50px 50px;
    }
    
    .rule-close {
        position: absolute;
        width: 35px;
        top: 40px;
        right: 60px;
        cursor: pointer;
    }

    .rule-close img {
        width: 100%;
    }
    
    
    @media screen and (min-width: 1200px) and (max-width: 1399px) {

        #rule {
            width: 550px;
            height: 450px;
            margin-left: -275px;
            padding: 25px 4%;
        } 
        
        #rule_close_animate {
            width: 550px;
            height: 450px;
            margin-left: -275px;
            padding: 25px 4%;
        }

        .rule-close {
            width: 30px;
            top: 32px;
            right: 50px;
        }

    }

    @media screen and (min-width: 992px) and (max-width: 1199px) {

        #rule {
            width: 470px;
            height: 380px;
            margin-left: -235px;
            padding: 15px 4%;
            top: 26%;
        } 

        #rule_close_animate {
            width: 470px;
            height: 380px;
            margin-left: -235px;
            padding: 15px 4%;
            top: 26%;
        }

        .rule-close {
            width: 25px;
            top: 22px;
            right: 40px;
        }

    }


    @media screen and (min-width: 768px) and (max-width: 991px) {

        #rule {
            width: 400px;
            height: 320px;
            margin-left: -200px;
            padding: 5px 4%;
            top: 20%;
        } 

        #rule_close_animate {
            width: 400px;
            height: 320px;
            margin-left: -200px;
            padding: 5px 4%;
            top: 20%;
        }

        .rule-close {
            width: 18px;
            top: 16px;
            right: 32px;
        }

    }

    @media screen and (min-width: 414px) and (max-width: 767px) {

        #rule {
            width: 98%;
            height: 330px;
            margin-left: 0;
            top: 30.5%;
            left: 1%;
            padding: 5px 40px;
        } 

        #rule_close_animate {
            width: 98%;
            height: 330px;
            margin-left: 0;
            top: 30.5%;
            left: 1%;
        }

        .rule-close {
            width: 25px;
            top: 25px;
            right: 45px;
        }

    }  

    @media screen and (min-width: 375px) and (max-width: 413px) {

        #rule {
            width: 98%;
            height: 330px;
            margin-left: 0;
            top: 30.5%;
            left: 1%;
            padding: 5px 40px;
        } 

        #rule_close_animate {
            width: 98%;
            height: 330px;
            margin-left: 0;
            top: 30.5%;
            left: 1%;
        }

        .rule-close {
            width: 22px;
            top: 22px;
            right: 45px;
        }

    }  

    @media screen and (min-width: 360px) and (max-width: 374px) {

        #rule {
            width: 98%;
            height: 330px;
            margin-left: 0;
            top: 30.5%;
            left: 1%;
            padding: 5px 40px;
        } 

        #rule_close_animate {
            width: 98%;
            height: 330px;
            margin-left: 0;
            top: 30.5%;
            left: 1%;
        }

        .rule-close {
            width: 22px;
            top: 20px;
            right: 40px;
        }

    }  

    @media screen and (max-width: 359px) {

        #rule {
            width: 98%;
            height: 330px;
            margin-left: 0;
            top: 30.5%;
            left: 1%;
            padding: 5px 40px;
        } 

        #rule_close_animate {
            width: 98%;
            height: 330px;
            margin-left: 0;
            top: 30.5%;
            left: 1%;
        }

        .rule-close {
            width: 20px;
            top: 15px;
            right: 40px;
        }

    }  
    
    
    /*遊戲規則標題*/
    .reel-title {
        width: 100%;
        padding-top: 15px;
        padding-bottom: 15px;
        text-align: center;
    }

    .reel-title img {
        height: 26px;
    }
    
    .rule-area {
        width: 100%;
        height: 420px;
        padding-right: 10px;
        overflow-y: scroll;
        color: #191639;
        font-size: 20px;
        line-height: 120%;
    }
    
    .rule-area::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0);
        border-radius: 10px;
        background-color: rgba(0,0,0,0);
    }

    .rule-area::-webkit-scrollbar
    {
        width: 10px;
        background-color: #3C0000;
        border-left: 3px solid #E7B652;
        border-right: 3px solid #E7B652;
    }

    .rule-area::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        background-color: #3C0000;
    }
    
    @media screen and (min-width: 1200px) and (max-width: 1399px) {
    
        .reel-title {
            padding-top: 15px;
            padding-bottom: 10px;
        }

        .reel-title img {
            height: 26px;
        }
        
        .rule-area {
            height: 340px;
        }

    }

    @media screen and (min-width: 992px) and (max-width: 1199px) {

        .reel-title {
            padding-top: 12px;
            padding-bottom: 10px;
        }

        .reel-title img {
            height: 20px;
        }

        .rule-area {
            height: 300px;
            font-size: 18px;
        }
    }


    @media screen and (min-width: 768px) and (max-width: 991px) {

        .reel-title {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .reel-title img {
            height: 18px;
        }

        .rule-area {
            height: 270px;
            font-size: 18px;
        }
    }

    @media screen and (min-width: 414px) and (max-width: 767px) {

        .reel-title {
            width: 100%;
            padding-top: 25px;
            padding-bottom: 5px;
            text-align: center;
        }

        .reel-title img {
            height: 18px;
        }

        .rule-area {
            height: 250px;
            font-size: 16px;
        }
    }  

    @media screen and (min-width: 375px) and (max-width: 413px) {

        .reel-title {
            padding-top: 22px;
            padding-bottom: 3px;
        }

        .reel-title img {
            height: 15px;
        }

        .rule-area {
            height: 230px;
            font-size: 16px;
        }
    }  

    @media screen and (min-width: 360px) and (max-width: 374px) {
 
        .reel-title {
            padding-top: 18px;
            padding-bottom: 2px;
        }

        .reel-title img {
            height: 15px;
        }

        .rule-area {
            height: 230px;
            font-size: 16px;
        }
    }  

    @media screen and (max-width: 359px) {

        .reel-title {
            padding-top: 10px;
            padding-bottom: 2px;
        }

        .reel-title img {
            height: 12px;
        }
        
        .rule-area {
            height: 210px;
            font-size: 16px;
        }
    } 
    
</style>
@stop 

@section('content')
<!--路徑
<h1>{{ $page_title }}</h1>


<ol class="breadcrumb">
    <li class="breadcrumb-item">遊戲大廳</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>-->

<!--背景-->
<div class="chess-home-bg hidden-xs"></div>
<div class="m-chess-home-bg hidden-sm hidden-md hidden-lg"></div>

<!--猜象棋logo-->
<div class="chess-back-logo">
    <img src="{{ asset('front/img/chess/web/back_logo.png') }}">
</div>

<!--banner-->
<div class="chess-banner hidden-xs">
    <img src="{{ asset('front/img/chess/web/banner_01.png') }}"/>
</div>
<div class="m-banner hidden-sm hidden-md hidden-lg">
    <img src="{{ asset('front/img/chess/phone/banner_01.png') }}"/>
</div>



<!--籌碼-->
<div class="chess-btn-area">
    <div class="row" style="margin-top:-5%;">
        <div class="col-xs-6 col-sm-3">
            <img class="chess-btn-img enter" data-number="1" src="{{ asset('front/img/chess/phone/coin_bet_'.$chip_settings[1] .'_03.png') }}" >
        </div>
        <div class="col-xs-6 col-sm-3">
            <img class="chess-btn-img enter" data-number="2" src="{{ asset('front/img/chess/phone/coin_bet_'.$chip_settings[2] .'_03.png') }}" >
        </div>
        <div class="col-xs-6 col-sm-3">
            <img class="chess-btn-img enter" data-number="3" src="{{ asset('front/img/chess/phone/coin_bet_'.$chip_settings[3] .'_03.png') }}" >
        </div>
        <div class="col-xs-6 col-sm-3">
            <img class="chess-btn-img enter" data-number="4" src="{{ asset('front/img/chess/phone/coin_bet_'.$chip_settings[4] .'_03.png') }}" >
        </div>
    </div>

</div>

<div class="btn-rule">
    <img id="rule-click" onclick="rule_open(); setTimeout(rule_open_animate, 100);" src="{{ asset('front/img/chess/web/rules_icon_02.png') }}">
    <img id="rule-open" onclick="rule_show();setTimeout(rule_content_show, 1000);" src="{{ asset('front/img/chess/web/rules_icon_01.png') }}">
</div>

<div id="rule">
    <div id="rule_content">
        <a class="rule-close" onclick="rule_close();setTimeout(rule_close_animate_end, 1000);">
            <img src="{{ asset('front/img/chess/phone/icon_close.png') }}"/>
        </a>
        <!--規則標題-->
        <div class="reel-title">
            <img src="{{ asset('front/img/chess/phone/title_03.png') }}"/>
        </div>

        <div class="rule-area">
            <p>象棋</p>
            <p>遊戲時間為每5分鐘一局</p>
            <p>從每日下午4點5分至隔天下午2點55分</p>
            <p>玩法:</p>
            <p>總共有11個選擇，22顆棋子</p>
            <p>棋子選擇如下:</p>
            <p>將<span style="color: #E3000D;">帥</span>各一(將帥為同一格)士、<span style="color: #E3000D;">仕</span>、象、<span style="color: #E3000D;">相</span>、車、<span style="color: #E3000D;">俥</span>、馬、<span style="color: #E3000D;">傌</span>、包、<span style="color: #E3000D;">炮</span>各兩支</p>
            <p>賠率都以壓1賠1為基準</p>
            <p>若開到相同的棋子兩支則賠2倍</p>
            <p>舉例:</p>
            <p>押”士”1000分，開出來的棋子為士、<span style="color: #E3000D;">仕</span>、象、<span style="color: #E3000D;">相</span>、車，因押中士則贏1000分</p>
            <p>若開出來的棋子為士、士、<span style="color: #E3000D;">仕</span>、象、<span style="color: #E3000D;">相</span>，因押中兩支士則贏2000分</p>
            <p>押”將”1000分，開出來的棋子為<span style="color: #E3000D;">帥</span>、<span style="color: #E3000D;">相</span>、車、<span style="color: #E3000D;">俥</span>、馬，因將帥同格則贏1000分</p>
            <p>押”將”1000分，開出來的棋子為<span style="color: #E3000D;">帥</span>、將、馬、<span style="color: #E3000D;">傌</span>、包，因將帥同格則贏2000分</p>
            <p>紅黑玩法如下:</p>
            <p>以開出來的5支棋子為基準，看紅色的棋子跟黑色的棋子哪種顏色佔多數則勝</p>
            <p>賠率以壓1賠0.9為基準</p>
            <p>舉例:</p>
            <p>壓1000分黑，開出來的五支棋子黑色佔3支以上則勝，賠900分</p>

        </div>
    </div>    
</div>
<div id="rule_close_animate"></div>

@stop

@section('outer-area')
<div id="info_bg"></div>
@stop

@section('footer-js')
<script>
    $(document).ready(function() {
    	$( ".enter" ).click(function() {
            
            


        var URL = document.location.toString();
        var useragent = navigator.userAgent;
        useragent = useragent.toLowerCase();

        if( useragent.indexOf('iphone') != -1 ) device = 'm';
        else if( useragent.indexOf('android') != -1 ) {
            if( ConsiderLimits() )
            {
                device = 'w'; // android pad
            }else{
                device = 'm'; // android phone
            }
        }else{
            device = 'w';
        }

        function ConsiderLimits() {
        if( screen.width >= 1024 && screen.height >= 600 )
        return 1;
        return 0;
        }
            
            //請判斷是手機裝置還是電腦 手機是m  電腦為w
		  	window.location.href = "{{ route('front.game.cn_chess.index') }}?type="+device+'&chip='+$(this).data('number');

		});
        
    });
</script>

<script>
    
//遊戲規則
function rule_open(){
    document.getElementById("rule-open").style.display = "block";
    document.getElementById("rule-click").style.display = "none";
} 
    
function rule_open_animate(){
    document.getElementById("rule-open").classList.add('rule-open-animate');
} 
    
function rule_show(){
    document.getElementById("rule").style.display = "block";
    document.getElementById("info_bg").style.display = "block";
    //將按鈕調回無文字的狀態
    document.getElementById("rule-open").classList.remove('rule-open-animate');
    document.getElementById("rule-open").style.display = "none";
    document.getElementById("rule-click").style.display = "block";
}
    
function rule_content_show(){
    document.getElementById("rule_content").style.display = "block";
}
    
function rule_close(){
    document.getElementById("rule").style.display = "none";
    document.getElementById("rule_content").style.display = "none";
    document.getElementById("rule_close_animate").style.display = "block";
    document.getElementById("info_bg").style.display = "none";
}
 
        
function rule_close_animate_end(){
    document.getElementById("rule_close_animate").style.display = "none";
}

</script>

@stop
