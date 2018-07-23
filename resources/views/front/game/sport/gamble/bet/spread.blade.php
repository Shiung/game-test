@extends('layouts.front_blank')
@section('head')
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('front/css/bet.css') }}"> 
<style>
    html,body {
        background-color: #FE7064;
        height: 500;
        overflow: hidden;
    }
    
    .container {
        padding-left: 25px;
        padding-right: 25px;
    }
    
    .bet-page {
        position: relative;
        width: 100%;
        height: 450px;
        background-color: rgba(255,255,255,0.9);
        margin-top: 25px;
        border-radius: 10px;
        padding: 10px;
    }
    
    .modal-body {
        padding: 0px 15px;
    }
    
    .form-control {
        background-color: #A6A8AA;
        color: #170a36;
        border-radius: 15px;
        text-align: center;
        font-weight: bold;
        font-stretch: condensed;
    }
    
    .form-control:enabled {
        background-color: #A6A8AA;
        color: #170a36;
        border-radius: 15px;
    }
    
    .bet-gold {
        width: 100%;
        height: 0;
        padding-bottom: 33%;
        background: url("{{ asset('front/img/icon/usercoin/user_bg_gold_01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        text-align: right;
        line-height: 50px;
        padding-right: 15px;
        color: white;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
    }
    
    .bet-red {
        width: 100%;
        height: 0;
        padding-bottom: 33%;
        background: url("{{ asset('front/img/icon/usercoin/user_bg_bonus_01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        text-align: right;
        line-height: 50px;
        padding-right: 15px;
        color: white;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
    }
    
    .bet-ulg {
        width: 100%;
        height: 0;
        padding-bottom: 33%;
        background: url("{{ asset('front/img/icon/usercoin/user_bg_ulg_01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        text-align: right;
        line-height: 50px;
        padding-right: 15px;
        color: white;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
    }
    
    .bet-gift {
        width: 100%;
        height: 0;
        padding-bottom: 33%;
        background: url("{{ asset('front/img/icon/usercoin/user_bg_gift_01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        text-align: right;
        line-height: 50px;
        padding-right: 15px;
        color: white;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
    }
    
    .sweet-gold {
        width: 100%;
        height: 0;
        padding-bottom: 35%;
        background: url("{{ asset('front/img/chess/phone/alert/gold01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        text-align: right;
        line-height: 50px;
        padding-right: 15px;
        color: white;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
    }
    
    .sweet-red {
        width: 100%;
        height: 0;
        padding-bottom: 35%;
        background: url("{{ asset('front/img/chess/phone/alert/red01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        text-align: right;
        line-height: 50px;
        padding-right: 15px;
        color: white;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
    }
    
    .sweet-ulg {
        width: 100%;
        height: 0;
        padding-bottom: 35%;
        background: url("{{ asset('front/img/chess/phone/alert/ulg01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        text-align: right;
        line-height: 50px;
        padding-right: 15px;
        color: white;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
    }
    
    .sweet-gift {
        width: 100%;
        height: 0;
        padding-bottom: 35%;
        background: url("{{ asset('front/img/chess/phone/alert/gift01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        text-align: right;
        line-height: 50px;
        padding-right: 15px;
        color: white;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
    }
    
    .btn-gray {
        color: #fff;
        background-color: #58595B;
        border: 1px solid #58595B;
        padding: 2px 18px;
    }
    
    .btn-gray:hover , .btn-gray:focus {
        color: #fff;
        background-color: #58595B;
        border: 1px solid #58595B;
        padding: 2px 18px;
    }
    
    .btn-red {
        color: #fff;
        background-color: #E4002B;
        border: 1px solid #E4002B;
        padding: 2px 18px;
    }
    
    .btn-red:hover , .btn-red:focus {
        color: #fff;
        background-color: #58595B;
        border: 1px solid #58595B;
        padding: 2px 18px;
    }
    
    .btn-blue {
        color: #fff;
        background-color: #00A3E0;
        border: 1px solid #00A3E0;
        padding: 2px 18px;
    }
    
    .btn-blue:hover , .btn-blue:focus {
        color: #fff;
        background-color: #58595B;
        border: 1px solid #58595B;
        padding: 2px 18px;
    }
    
    .sweet-alert {
        background: url("{{ asset('front/img/ball/common/popup_bet_bg_00.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        padding: 0px 35px;
        width: 360px;
        height: 500px;
        margin-left: 0;
    }
    
    
    .sweet-alert .sa-icon {
        position: fixed;
        left: 50%;
        margin-left: -40px;
    }
    
    .sweet-alert h2 {
        margin-top: 100px;
        margin-bottom: 0px;
        color: #3C0000;
    }
    
    .sweet-alert p {
        max-height: 220px;
        overflow-y: scroll;
    }
    
    .sweet-alert p::-webkit-scrollbar
    {
        width: 0px;
    }
    
    .sweet-alert button {
        margin-top: 10px;
        background-color: #58595B !important;
        padding: 5px 15px;
    }
    
    .sweet-alert button:hover {
        background-color: #de0033 !important;
    }
    
    .sweet-alert .sa-icon.sa-warning {
        background: url("{{ asset('front/img/chess/phone/popup_bet_bg_icon_01.gif') }}");
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
    
</style>
@stop 

@section('content')
@inject('SportPresenter','App\Presenters\Game\SportPresenter')

<div class="bet-page">

<form id="Form_bet">
    <div class="modal-body">
        
        <div id="bet_info">
            
            <div classs="row">
                <div class="col-xs-6" style="text-align:right; height:50px; line-height:50px;">下注 <span style="color:#e10031 ; font-size:28px; line-height:50px; font-weight:bold;" class="bet_name">{{  $gamblename  }}</span></div>
                <div class="col-xs-6" style="height:50px; line-height:50px;">賠率 <span style="color:#e10031 ; font-size:28px; line-height:50px; font-weight:bold;">{{  $line }}</span></div>
            </div>
            <div class="row">
                <label for="win_amount" class="col-xs-3 control-label" style="padding-right:0; padding-left:0; line-height:35px; text-align:right; color:#58595B;">可贏金額</label>
                <div class="col-xs-9">
                  <input type="number" class="form-control" readonly value="0" id="win_amount">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12" style="text-align:center; color:#58595B; border-top:2px solid #58595B; border-bottom:2px solid #58595B; padding:5px 0px; margin-top:5px;">
                    
                    @if($parameters['headteam'] == $home_team->id)
                        <div style="font-size:16px;"> {{ $away_team->name }}</div>
                        <div style="font-size:16px;"> {{ $home_team->name }} [主]<span style="color:blue;"> {{ $parameters['point'] }}</span> </div>
                    @else 
                        <div style="font-size:16px;">  {{ $away_team->name }}  <span style="color:blue;"> {{ $parameters['point'] }}</span></div>
                        <div style="font-size:16px;"> {{ $home_team->name }} [主]</div>
                    @endif
                    
                </div>
            </div>
            
        </div>
        
        <div class="row" style="margin-top:5px;">
            <div class="col-xs-6" style="padding-left:0; padding-right:0; height:115px;">
                <div class="bet-input-area">
                    <div class="bet-gold">{{  number_format($account_amount['cash'])  }}</div>
                    <input type="number" class="form-control amount"   name="virtual_cash_amount" id="virtual_cash_amount"   min="0" max="{{  getBetMaxAmount($account_amount['cash'])  }}" >
                </div>
            </div>
            <div class="col-xs-6" style="padding-left:0; padding-right:0; height:115px;">
                <div class="bet-input-area">
                    <div class="bet-ulg">{{ number_format($account_amount['right']) }}</div>
                    <input type="number" class="form-control amount"   name="share_amount" id="share_amount"  min="0" max="{{ getBetMaxAmount($account_amount['right']) }}" >
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-6" style="padding-left:0; padding-right:0; height:115px;">
                <div class="bet-input-area">
                    <div class="bet-red">{{ number_format($account_amount['interest']) }}</div>
                    <input type="number" class="form-control amount"   name="interest_amount" id="interest_amount"    min="0" max="{{ getBetMaxAmount($account_amount['interest']) }}" >
                </div>
            </div>
            <div class="col-xs-6" style="padding-left:0; padding-right:0; height:115px;">
                <div class="bet-input-area">
                    <div class="bet-gift">{{  number_format($account_amount['run']) }}</div>
                    <input type="number" class="form-control amount"  name="manage_amount" id="manage_amount"   min="0" max="{{  getBetMaxAmount($account_amount['run']) }}" >
                </div>
            </div>
        </div>
        
        
        <!--
        <h4>投注金額</h4>
        <p style="color:red;">注意：一種幣別一注最高限制10位數</p>
        <fieldset class="form-group" >
            <label for="cash_amount">{!! config('member.account.type_icon.1') !!}{{ config('member.account.type.1') }}  （餘額：{{  number_format($account_amount['cash'])  }}）</label>
            <input type="number" class="form-control amount"   name="virtual_cash_amount" id="virtual_cash_amount"   min="0" max="{{  getBetMaxAmount($account_amount['cash'])  }}" >
        </fieldset>
        <fieldset class="form-group" >
            <label for="interest_amount">{!! config('member.account.type_icon.4') !!}{{ config('member.account.type.4') }} （餘額： {{ number_format($account_amount['interest']) }}） </label>
            <input type="number" class="form-control amount"   name="interest_amount" id="interest_amount"    min="0" max=" {{ getBetMaxAmount($account_amount['interest']) }}" >
        </fieldset>
        <fieldset class="form-group" >
            <label for="right_amount">{!! config('member.account.type_icon.3') !!}{{ config('member.account.type.3') }}  （餘額： {{ number_format($account_amount['right']) }}）</label>
            <input type="number" class="form-control amount"   name="share_amount" id="share_amount"  min="0" max="{{ getBetMaxAmount($account_amount['right']) }}" >
        </fieldset>
        <fieldset class="form-group" >
            <label for="run_amount">{!! config('member.account.type_icon.2') !!}{{ config('member.account.type.2') }}  （餘額：{{  number_format($account_amount['run']) }}）</label>
            <input type="number" class="form-control amount"  name="manage_amount" id="manage_amount"   min="0" max="{{  getBetMaxAmount($account_amount['run']) }}" >
        </fieldset>
-->
        
        <input type="hidden" name="game_id" id="game_id" value="{{ $data->id }}" >
        <input type="hidden" name="gamble" id="gamble" value="{{ $gamble }}" >
        <input type="hidden" name="line" id="line" value="{{ $line }}" >

    </div>
    <center><a class="btn btn-blue" href="javascript:parent.jQuery.fancybox.close();" style="margin-right:10px;">取 消</a> <button type="submit" class="btn btn-red">確 認</button></center>
        
</form>
    
</div>




@stop

@section('footer-js')

<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script src="{{ asset('front/js/sport/bet.js') }}?v=20180302"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="{{ asset('plugins/js-webshim/minified/polyfiller.js') }}"></script>
<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var win_amount = $('#win_amount');
        var line = $('#line').val();
        var gamblename = '{{ $gamblename }}';
        var home_team = '{{ $home_team->name }} [主]';
        var away_team = '{{ $away_team->name }}';
        var account_data = {
            '1':{'icon':"{!! config('member.account.type_icon.1') !!}",'name':"{{ config('member.account.type.1') }}",'amount':"{{ $account_amount['cash'] }}"},
            '2':{'icon':"{!! config('member.account.type_icon.2') !!}",'name':"{{ config('member.account.type.2') }}",'amount':"{{ $account_amount['run'] }}"},
            '3':{'icon':"{!! config('member.account.type_icon.3') !!}",'name':"{{ config('member.account.type.3') }}",'amount':"{{ $account_amount['right'] }}"},
            '4':{'icon':"{!! config('member.account.type_icon.4') !!}",'name':"{{ config('member.account.type.4') }}",'amount':"{{ $account_amount['interest'] }}"},
        };

        //千分位
        webshims.setOptions('forms-ext', {
            replaceUI: true,
            types: 'number'
        });
        webshims.polyfill('forms forms-ext');

        //改變賠率調整參數
        $(".amount").change(function(){
            countWinAmount($('#virtual_cash_amount').val(),$('#manage_amount').val(),$('#share_amount').val(),$('#interest_amount').val())    
        });

        //計算可贏金額
        function countWinAmount(t_cash,t_run,t_right,t_interest){
            cash = getRealBetAmount(t_cash);
            run = getRealBetAmount(t_run);
            interest = getRealBetAmount(t_interest);
            right = getRealBetAmount(t_right);

            total = cash+run+right+interest;
            win_amount.val(Math.floor(total*line));
        }

        //確認下注
        $("#Form_bet").validate({
            ignore: [],
            rules: {
            },
            messages: {
                virtual_cash_amount:{max:'金額有誤，重新輸入'},
                interest_amount:{max:'金額有誤，重新輸入'},
                share_amount:{max:'金額有誤，重新輸入'},
                manage_amount:{max:'金額有誤，重新輸入'},
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element);
                } else if (element.attr("name") == "date") {
                    error.insertAfter(".input-group");
                } else {
                    error.insertAfter(element.closest(".bet-input-area"));
                }

            },
            submitHandler: function(form) {
                //檢查金額
                if(!checkBetAmount($('#virtual_cash_amount').val(),$('#manage_amount').val(),$('#interest_amount').val(),$('#share_amount').val())){
                    swal("下注單不完整", '請輸入下注金額', 'error');
                    return false;
                }
                
                //下注成功表頭資訊（隊伍資料等等）
                game_info = '<div class="row" style="width:90%; margin-left:5%; border-top:1px solid #58595B; border-bottom:1px solid #58595B;"><div class="col-xs-12" style="text-align:center; border-top:1px solid #58595B; padding-top:5px;">'+away_team+'</div><div class="col-xs-12" style="text-align:center; padding-bottom:5px;">'+home_team+'</div></div>';
                swal({
                    title: '下注確認',
                    text:'<div class="row" style="width:90%; margin-left:5%; border-top:1px solid #58595B; border-bottom:1px solid #58595B;"><div class="col-xs-6" style="text-align:right; height:50px; line-height:50px;">下注 <span style="color:#e10031 ; font-size:28px; line-height:50px; font-weight:bold;" class="bet_name" id="bet_name">{{  $gamblename  }} </span></div><div class="col-xs-6" style="height:50px; line-height:50px; text-align:left; ">賠率 <span style="color:#e10031 ; font-size:28px; line-height:50px; font-weight:bold;">{{  $line }}</span></div><div class="col-xs-12" style="text-align:center; border-top:1px solid #58595B; padding-top:5px;">'+away_team+'</div><div class="col-xs-12" style="text-align:center; padding-bottom:5px;">'+home_team+'</div></div>'+'<table style="width:90%; margin-left:5%; margin-top:10px;"><tr><td style="width:50%;"><div class="sweet-gold" style="line-height: 45px;">'+numeral($('#virtual_cash_amount').val()).format('0,0')+'</div></td><td style="width:50%;"><div class="sweet-ulg" style="line-height: 45px;">'+numeral($('#share_amount').val()).format('0,0')+'</div></td></tr><tr><td style="width:50%;"><div class="sweet-red" style="line-height: 45px;">'+numeral($('#interest_amount').val()).format('0,0')+'</div></td><td style="width:50%;"><div class="sweet-gift" style="line-height: 45px;">'+numeral($('#manage_amount').val()).format('0,0')+'</div></td></tr></table>',
                    type: 'warning',
                    html:true,
                    showCancelButton: true,
                    confirmButtonText: '確認下注',
                    cancelButtonText: '取消下注'
                },function(){
                    sendUri = APP_URL + "/game/{{ $route_code }}/gamble/bet";
                    sendData = $('#Form_bet').serialize();
                    goBet(sendUri,sendData,game_info);
                });
                
                var len = 3;
                $("#bet_name").each(function(i){
                    if($(this).text().length>len){
                        $(this).attr("title",$(this).text());
                        var text=$(this).text().substring(0,len);
                        $(this).text(text);
                    }
                });
                
            }
        }); //確認下注

        
        
        
    });
    
    $(function(){
        var len = 3; // 超過50個字以"..."取代
        $(".bet_name").each(function(i){
            if($(this).text().length>len){
                $(this).attr("title",$(this).text());
                var text=$(this).text().substring(0,len);
                $(this).text(text);
            }
        });
    });
</script>

@stop
