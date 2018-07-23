@extends('layouts.front_blank')
@section('head')
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<style>
.bet{
    width:100%;
    height:100px;
    background-color: #FFC627;
    line-height: 100px;
    text-align:center;

}
.point{
    height:20px;
    padding-bottom: 10px;
}
.line{
    color:red;
}
.circle {
    display:table;
    width: 2em;
    height:2em;
    border-radius: 50%;
    overflow: hidden;
    background: transparent;
    box-shadow: 0 0 3px gray;
    cursor: pointer;
}

.c_click {

    background-color: yellow;


}

.circle div {
    display:table-cell;
    width:100%;
    height:100%;
    line-height:1em;
    text-align:center;
    vertical-align:middle;
    font-size: 7px;
    font-family:'Raleway', sans-serif;
    color:black;
    width: 13em;
}

#circles {
    margin: 0;
    padding: 0;
    list-style: none;
}
#circles li {
    float: left;
    margin:1.25%;
}
#lottery_part {

    width:100%;
    min-height: 200px;
    margin-top: 10px;
    margin-bottom: 10px;
    padding: 0 5%;
}
</style>
@stop 

@section('content')
@inject('SportPresenter','App\Presenters\Game\SportPresenter')

<h1>選三球</h1>

<h4>賠率</h4>
一顆球：<span style="color:red;">{{ $parameters["one_ratio"] }}</span>
兩顆球：<span style="color:red;">{{ $parameters["two_ratio"] }}</span>
三顆球：<span style="color:red;">{{ $parameters["three_ratio"] }}</span>
<!-- 號碼清單 -->
<div id="lottery_part">
    <ul id="circles">
        @for($i=1;$i<40;$i++)
        <li>
            <div class="circle" data-id="{{ $i }}">
                <div>{{ $i }}</div>
            </div>
        </li>
        @endfor 
    </ul>
</div>
<!-- /.號碼清單 -->

<form id="Form_bet">
    <h4>可贏金額</h4>
    <div class="row">
        <div class="col-sm-4">
            <fieldset class="form-group" >
                <label for="win_one_amount">中一球</label>
                <input type="number" class="form-control" readonly value="0" id="win_one_amount">
            </fieldset>
        </div>
        <div class="col-sm-4">
            <fieldset class="form-group" >
                <label for="win_two_amount">中兩球</label>
                <input type="number" class="form-control" readonly value="0" id="win_two_amount">
            </fieldset>
        </div>
        <div class="col-sm-4">
            <fieldset class="form-group" >
                <label for="win_three_amount">中三球</label>
                <input type="number" class="form-control" readonly value="0" id="win_three_amount">
            </fieldset>
        </div>
        
    </div>
    <h4>投注金額</h4>
    <p style="color:red;">注意：一種幣別一注最高限制10位數</p>
    <div class="row">
        <div class="col-sm-6">
            <fieldset class="form-group" >
                <label for="cash_amount">{!! config('member.account.type_icon.1') !!}{{ config('member.account.type.1') }}  （餘額：{{  number_format($account_amount['cash'])  }}）</label>
                <input type="number" class="form-control amount"  name="virtual_cash_amount" id="virtual_cash_amount" min="0" max="{{  getBetMaxAmount($account_amount['cash'])  }}" >
            </fieldset>
        </div>
        <div class="col-sm-6">
            <fieldset class="form-group" >
                <label for="interest_amount">{!! config('member.account.type_icon.4') !!}{{ config('member.account.type.4') }}（餘額： {{ number_format($account_amount['interest']) }}） </label>
                <input type="number" class="form-control amount"  name="interest_amount" id="interest_amount"  min="0" max="{{  getBetMaxAmount($account_amount['interest'])  }}" >
            </fieldset>
        </div>
        
     </div>
     <div class="row">
        <div class="col-sm-6">
            <fieldset class="form-group" >
                <label for="right_amount">{!! config('member.account.type_icon.3') !!}{{ config('member.account.type.3') }} （餘額： {{ number_format($account_amount['right']) }}）</label>
                <input type="number" class="form-control amount"  name="share_amount" id="share_amount" min="0" max="{{  getBetMaxAmount($account_amount['right'])  }}" >
            </fieldset>
        </div>
        <div class="col-sm-6">
            <fieldset class="form-group" >
                <label for="run_amount">{!! config('member.account.type_icon.2') !!}{{ config('member.account.type.2') }}  （餘額：{{  number_format($account_amount['run']) }}）</label>
                <input type="number" class="form-control amount" name="manage_amount" id="manage_amount"  min="0" max="{{  getBetMaxAmount($account_amount['run'])  }}" >
            </fieldset>
        </div>
    </div>
    
    <input type="hidden" name="game_id" id="game_id" value="{{ $data->id }}" >
    <input type="hidden" name="one_ratio"  value="{{ $parameters['one_ratio'] }}" >
    <input type="hidden" name="two_ratio"  value="{{ $parameters['two_ratio'] }}" >
    <input type="hidden" name="three_ratio"  value="{{ $parameters['three_ratio'] }}" >


    <center><button type="submit" class="btn btn-primary">確定</button></center>

</form>
@stop

@section('footer-js')

<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script src="{{ asset('front/js/lottery539/bet.js?v=1.1') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="{{ asset('plugins/js-webshim/minified/polyfiller.js') }}"></script>
<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var win_one_amount = $('#win_one_amount');
        var win_two_amount = $('#win_two_amount');
        var win_three_amount = $('#win_three_amount');
        var game_id,type,type_name;
        var number_arr = [];
        var lottery_part = $('#lottery_part')
        var lottery_numbers = [];
        var one_ratio = '{{ $parameters["one_ratio"] }}';
        var two_ratio = '{{ $parameters["two_ratio"] }}';
        var three_ratio = '{{ $parameters["three_ratio"] }}';
        var account_data = {
            '1':{'icon':"{!! config('member.account.type_icon.1') !!}",'name':"{{ config('member.account.type.1') }}",'amount':"{{ $account_amount['cash'] }}"},
            '2':{'icon':"{!! config('member.account.type_icon.2') !!}",'name':"{{ config('member.account.type.2') }}",'amount':"{{ $account_amount['run'] }}"},
            '3':{'icon':"{!! config('member.account.type_icon.3') !!}",'name':"{{ config('member.account.type.3') }}",'amount':"{{ $account_amount['right'] }}"},
            '4':{'icon':"{!! config('member.account.type_icon.4') !!}",'name':"{{ config('member.account.type.4') }}",'amount':"{{ $account_amount['interest'] }}"},
        };
        //千分位
        webshims.setOptions('forms-ext', {
            replaceUI: 'true',
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

            total = (cash+run+right+interest);
            win_one_amount.val(Math.floor(total*one_ratio))
            win_two_amount.val(Math.floor(total*two_ratio))
            win_three_amount.val(Math.floor(total*three_ratio))

        }

        //點擊數字
        lottery_part.on("click", ".circle", function(e) {
            e.preventDefault();
            number = $(this).data('id');
            //檢查群組裡是否已經存在
            if (checkElementInArray(lottery_numbers, number) ) {
                //從一般陣列裡移除
                if(checkElementInArray(lottery_numbers,number)) {
                    lottery_numbers.splice(index, 1);
                }
                $(this).removeClass('c_click')
            } else {
                if(lottery_numbers.length < 3){
                    lottery_numbers.push(number);
                    $(this).addClass('c_click')
                }       
            }

        });//.點擊數字

        //清空彩球數字選擇
        function resetLotteryNumbers(){
            lottery_numbers = [];
            $(".c_click").each(function(){
                $(this).removeClass('c_click')
            });
        }
        

        //確認下注
        $("#Form_bet").validate({
            ignore: [],
            rules: {
            },
            messages: {
                virtual_cash_amount:{max:'輸入金額有誤，請重新確認'},
                interest_amount:{max:'輸入金額有誤，請重新確認'},
                share_amount:{max:'輸入金額有誤，請重新確認'},
                manage_amount:{max:'輸入金額有誤，請重新確認'},
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");

                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element);
                } else if (element.attr("name") == "date") {
                    error.insertAfter(".input-group");
                } else {
                    error.insertAfter(element);
                }

            },
            submitHandler: function(form) {
                
                //檢查號碼
                if(lottery_numbers.length != 3){
                    swal("下注單不完整", '請選擇三個號碼', 'error');
                    return false;
                }

                //檢查金額
                if(!checkBetAmount($('#virtual_cash_amount').val(),$('#manage_amount').val(),$('#interest_amount').val(),$('#share_amount').val())){
                    swal("下注單不完整", '請輸入下注金額', 'error');
                    return false;
                }
                swal({
                    title: '下注確認',
                    text: '您選擇的號碼為：'+JSON.stringify(lottery_numbers)+'<br><h4>下注額</h4>'+getBetAmount($('#virtual_cash_amount').val(),$('#manage_amount').val(),$('#interest_amount').val(),$('#share_amount').val(),account_data),
                    type: 'warning',
                    html:true,
                    showCancelButton: true,
                    confirmButtonText: '確認',
                    cancelButtonText: '取消'
                },function(){
                    sendUri = APP_URL + "/game/{{ $route_code }}/gamble/bet";
                    sendData = $('#Form_bet').serialize()+'&numbers='+JSON.stringify(lottery_numbers);
                    goBet(sendUri,sendData);
                });
                
            }
        }); //submit

        
    });
</script>

@stop
