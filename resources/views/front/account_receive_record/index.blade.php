@extends('layouts.main')
@section('head')
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
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
        background: url("{{ asset('front/img/icon/button/btn_receive_off.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
    }
    
    .btn-use:hover , .btn-use:focus {
        width: 60px;
        height: 39px;
        background: url("{{ asset('front/img/icon/button/btn_receive_on.png') }}");
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
    
    .receive {
        background-color: rgba(0,0,0,0) !important;
        border: 0 !important;
    }
    
</style>
@stop

@section('content')

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
            <th style="width:18%;">類別<div class="table-title-border"></div></th>
            <th style="width:32%;">金額<div class="table-title-border"></div></th>
            <th style="width:32%;">到期時間<div class="table-title-border"></div></th>
            <th style="width:18%;">領取</th>
        </thead>
    </table>
</div>

<!--列表-->
<div class="check-in-table-area">
    <table class="table table-checkin" id="data_list">
        <tbody>
        @foreach($datas as $data)

            @if(  strtotime(date('Y-m-d H:i:s')) < strtotime($data->expire_time) || $data->expire_time == '無限期')
            <tr class="tr1">
                <td rowspan="2" style="border-left:0; width:18%;">{!! config('member.account.type_icon.'.$data->account->type) !!}{{ config('member.account.type.'.$data->account->type) }}</td>
                <td style="width:32%;">{{ $data->amount }}</td>
                
                <td style="width:32%;">{{ $data->expire_time }}</td>
                <td rowspan="2" style=" width:18%; border-right:0; padding:8px 0px;"><button class="receive" data-amount="{{ $data->amount }}" data-id="{{ $data->id }}"><div class="btn-use"></div></button></td>
            </tr>
            <tr class="tr2">
                <td colspan="2" style="text-align:left;">{{ $data->description }}</td>
            </tr>
            @endif
                  
        @endforeach
        </tbody>
    </table>
</div>

<!--/.列表-->

<!--分頁-->
<div class="page-area">{!! $datas->render() !!}</div>

@stop

@section('footer-js')
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var right_amount = "{{ $account_amount['right'] }}";
        var table = $('#data_list');
        var alert = 0;


        //點擊
        table.on("click", ".receive", function(e) {

            e.preventDefault();
            var id = $(this).data('id');
            var amount = $(this).data('amount');
            if(right_amount < amount){
             
                swal({
                    title: '領取金額高於娛樂幣餘額',
                    text: '您的娛樂幣帳戶餘額目前只有 '+right_amount+'<br><span style="color:red;font-weight:bold;">最多僅能領取'+right_amount+'</span>',
                    type: 'warning',
                    html:true,
                    closeOnConfirm: false ,
                    confirmButtonText: '我知道了',
                },function(isConfirm){
                    if (isConfirm) {
                        doubleCheckAlert(id)
                    } 
                    
            
                });


                
                
            } else {
                recieveAmount(id)
            }
        });

        //跳第二個確認筐
        function doubleCheckAlert(id){
           
            swal({
                title: '領取金額高於娛樂幣餘額',
                text: '您的娛樂幣帳戶餘額目前只有 '+right_amount+'<br><span style="color:red;font-weight:bold;">最多僅能領取'+right_amount+' 確認馬上領取 ?</span>',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#FF0000',
                html:true,
                confirmButtonText: '確認領取',
                cancelButtonText: '取消'
            },function(){
                recieveAmount(id)
            });
        }

        //領取
        function recieveAmount(id){
            sendUri = APP_URL + "/checkin" ;
            sendData = {'id' : id };
            system_ajax(sendUri,sendData,"POST",function(data){
                window.location.reload();
            },function(data){});     
        }

    });
</script>
@stop
