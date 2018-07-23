@extends('layouts.main')
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
<link rel="stylesheet" href="{{ asset('front/css/bet.css') }}"> 
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<style>
    
.menu_active{
    background-color: #DCDCDC;
}    
        
    .container {
        position: relative;
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
    
    .game-icon {
        position: absolute;
        width: 15%;
        top: -20px;
        left: -8%;
    }
    
    
    @media screen and (min-width: 1200px) and (max-width: 1399px) {
        .game-icon {
            left: 0%;
        }
    }


    @media screen and (min-width: 992px) and (max-width: 1399px) {
        .game-icon {
            left: -8%;
        }
    }
    
    @media screen and (min-width: 768px) and (max-width: 991px) {
        .game-icon {
            left: -10%;
        }
    }
    
    @media screen and (max-width: 767px) {
        .game-icon {
            display: none;
        }
    }
    
    .game-icon-basketball {
        width: 100%;
        height: 0;
        padding-bottom: 110%;
        background: url("{{ asset('front/img/gameicon/basketball.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .game-icon-baseball , .game-icon-usa_baseball , .game-icon-jp_baseball , .game-icon-tw_baseball {
        width: 100%;
        height: 0;
        padding-bottom: 110%;
        background: url("{{ asset('front/img/gameicon/baseball.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }

    .game-icon-football {
        width: 100%;
        height: 0;
        padding-bottom: 110%;
        background: url("{{ asset('front/img/gameicon/football.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    
    
    /*上方餘額*/
    
    .col-account {
        position: relative;
        padding-bottom: 15px;
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
    
    /*開始下注及歷史紀錄按鈕*/
    
    .game-top-btn-area {
        position: relative;
        width: 100%;
    }
    
    .game-time-info {
        position: absolute;
        left: 10%;
        bottom: 1%;
        font-weight: bold;
        color: #191639;
    }
    
    .game-btn {
        position: relative;
        width: 16%;
        margin-left: 35%;
        z-index: 1;
    }
    
    .game-btn img {
        width: 100%;
    }
      
    .history-btn {
        position: absolute;
        width: 16%;
        left: 49%;
        top: 0;
        z-index: 0;
    }
    
    .history-btn img {
        width: 100%;
    }
    
    @media screen and (max-width: 767px) {
        .game-top-btn-area {
            position: relative;
            width: 100%;
            margin-top: 12%;
        }

        .game-time-info {
            display: none;
        }

        .game-btn {
            position: relative;
            width: 36%;
            margin-left: 17%;
            z-index: 1;
        }

        .game-btn img {
            width: 100%;
        }

        .history-btn {
            position: absolute;
            width: 36%;
            left: 47%;
            top: 0;
            z-index: 0;
        }

        .history-btn img {
            width: 100%;
        }
    }

    /*賽程列表*/
    .game-list {
        position: relative;
        width: 100%;
    }
    
    .table-game > thead > tr > th, .table-game > tbody > tr > th, .table-game > tfoot > tr > th, .table-game > thead > tr > td, .table-game > tbody > tr > td, .table-game > tfoot > tr > td {
        border: 1px solid #191639;
        color: #191639;
        font-size: 20px;
        font-weight: bold;
    }
    
    table.table-game th:last-child, table.table-game td:last-child {
        border-right-width: 1px;
    }
    
    .m-game-tr1 , .w-game-tr1 , .tr-height {
        border-top: 3px solid #191639;
    }
    
    .tr-height {
        border-left:0;
        border-right:0;
        border-bottom: 0;
        height:30px;
    }
    
    @media screen and (max-width: 767px) {
        .table-game > thead > tr > th, .table-game > tbody > tr > th, .table-game > tfoot > tr > th, .table-game > thead > tr > td, .table-game > tbody > tr > td, .table-game > tfoot > tr > td {
            font-size: 16px;
        }
        
        .tr-height {
            height:15px;
        }    
    }
    
    tr td:first-child {
        border-left: 0 !important;
    }
    
    @media screen and (max-width: 767px) {
        .td-mteam-first {
            border-left: 0 !important;
        }
    }
    
    tr td:last-child {
        border-right: 0 !important;
    }
    
    .fancybox-close {
        display: none;
    }
    
</style>
@stop 

@section('content')

<!--背景-->
<div class="game-home-bg hidden-xs"></div>
<div class="m-game-home-bg hidden-sm hidden-md hidden-lg"></div>

<!--game icon-->
<div class="game-icon">
    <div class="game-icon-{{ $type }}"></div>
</div>

<!--餘額-->
@include('front.game.amount_detail')
<!--/.餘額-->

<div class="game-top-btn-area">
    
    <div class="game-time-info">
        <small>比賽時間以台灣時間顯示 </small>
    </div>
    
    <div class="game-btn">
        <img src="{{ asset('front/img/ball/phone/tab_01_on.png') }}"/>
    </div>
    <a href="{{ route('front.game.category.history',[$type,date('Y-m-d')]) }}">
        <div class="history-btn">
            <img src="{{ asset('front/img/ball/phone/tab_02_on.png') }}"/>
        </div>
    </a>
    
</div>

<div class="game-list">
@foreach($datas as $category_name => $item)
    
    <!--賽程-->
    <table class="table table-game" id="data_list_test" style="text-align:center;">
        <tbody>
        @foreach($item['sports'] as $data)
        <!--賽程-->
        <!--手機第一列-->
        <tr class="m-game-tr1 hidden-sm hidden-md hidden-lg">
            <td style="color:#EB0C26;">讓分</td>
            <td colspan="4">{{ $data['taiwan_datetime'] }}</td>
            <td style="color:#0052A3;">大小</td>
        </tr>
        <!--電腦第一列-->
        <tr class="w-game-tr1 hidden-xs">
            <td colspan="2">{{ $data['taiwan_datetime'] }}</td>
            <td colspan="2" style="color:#EB0C26;">讓球</td>
            <td colspan="2" style="color:#0052A3;">大小</td>
            <td></td>
        </tr>
        
        <!--手機客隊名稱-->
        <tr class="m-game-tr-team hidden-sm hidden-md hidden-lg">
            <td colspan="6">{{ $data['teams']['away']['name'] }}</td>
        </tr>
        
        <!--客隊-->
        <tr class="tr-team">
            <td class="hidden-xs">{{ $data['teams']['away']['name'] }}</td>
            <td class="td-mteam-first">客</td>
            <!--客隊讓球-->
            <td>
            @if(array_key_exists(2,$data['games']))
               {{ $data['games'][2]['away_data']['show_point'] }}
            @endif 
            </td>
            @if(array_key_exists(2,$data['games']))
            <td class="bg-red">
               <div data-type="spread" 
                    data-typename="讓分" 
                    data-gameid="{{ $data['games'][2]['gameid'] }}" 
                    data-betstatus="{{ $data['games'][2]['betstatus'] }}" 
                    data-gamble="{{ $data['games'][2]['away_data']['gamble'] }}" 
                    data-line="{{ $data['games'][2]['away_data']['line'] }}" 
                    data-homeline="{{ $data['games'][2]['home_data']['line'] }}" 
                    data-awayline="{{ $data['games'][2]['away_data']['line'] }}" 
                    data-point="{{ $data['games'][2]['point'] }}" 
                    data-gamblename="{{ $data['games'][2]['away_data']['gamblename'] }}" 
                    data-headteam="{{ $data['games'][2]['headteam'] }}" 
                    class="bet">
                    <span class="line-red">{{ $data['games'][2]['away_data']['line'] }}</span>
                </div>
            
            </td>
            @else
            <td></td>
            @endif 
            <!--客隊大小-->
            <td>
            @if(array_key_exists(1,$data['games']))
                {{ $data['games'][1]['away_data']['show_point'] }}
            @endif 
            </td>
            @if(array_key_exists(1,$data['games']))
            <td class="bg-blue">
            
                <div data-type="overunder" 
                    data-typename="大小" 
                    data-gameid="{{ $data['games'][1]['gameid'] }}" 
                    data-betstatus="{{ $data['games'][1]['betstatus'] }}" 
                    data-gamble="0" 
                    data-line="{{ $data['games'][1]['away_data']['line'] }}" 
                    data-homeline="{{ $data['games'][1]['home_data']['line'] }}" 
                    data-awayline="{{ $data['games'][1]['away_data']['line'] }}" 
                    data-point="{{ $data['games'][1]['point'] }}"
                    data-gamblename="{{ $data['games'][1]['away_data']['gamblename'] }}" 
                    class="bet">
                    <span class="line-blue">{{ $data['games'][1]['away_data']['line'] }}</span>
                </div>    
            </td>
            @else
            <td></td>
            @endif 
            <td>
            @if(array_key_exists(1,$data['games']))
                {{ $data['games'][1]['away_data']['gamblename'] }}
            @endif     
            </td>
        </tr>
        
        <!--主隊-->
        <tr class="tr-team">
            <td class="hidden-xs">{{ $data['teams']['home']['name'] }}[主]</td>
            <td class="td-mteam-first">主</td>
            <!--主隊讓球-->
            <td>
            @if(array_key_exists(2,$data['games']))
               {{ $data['games'][2]['home_data']['show_point'] }}
            @endif 
            </td>
            
            @if(array_key_exists(2,$data['games']))
            <td class="bg-red">
               <div data-type="spread" 
                    data-typename="讓分" 
                    data-gameid="{{ $data['games'][2]['gameid'] }}" 
                    data-betstatus="{{ $data['games'][2]['betstatus'] }}" 
                    data-gamble="{{ $data['games'][2]['home_data']['gamble'] }}" 
                    data-line="{{ $data['games'][2]['home_data']['line'] }}" 
                    data-homeline="{{ $data['games'][2]['home_data']['line'] }}" 
                    data-awayline="{{ $data['games'][2]['away_data']['line'] }}" 
                    data-point="{{ $data['games'][2]['point'] }}" 
                    data-gamblename="{{ $data['games'][2]['home_data']['gamblename'] }}" 
                    data-headteam="{{ $data['games'][2]['headteam'] }}" 
                    class="bet">
                    <span class="line-red">{{ $data['games'][2]['home_data']['line'] }}</span>
                </div>
            </td>
            @else
            <td></td>
            @endif 
            
            <!--主隊大小-->
            <td>
            @if(array_key_exists(1,$data['games']))
                {{ $data['games'][1]['home_data']['show_point'] }}
            @endif 
            </td>
            
            @if(array_key_exists(1,$data['games']))
            <td class="bg-blue">
                <div data-type="overunder" 
                    data-typename="大小" 
                    data-gameid="{{ $data['games'][1]['gameid'] }}" 
                    data-betstatus="{{ $data['games'][1]['betstatus'] }}" 
                    data-gamble="1" 
                    data-line="{{ $data['games'][1]['home_data']['line'] }}" 
                    data-homeline="{{ $data['games'][1]['home_data']['line'] }}" 
                    data-awayline="{{ $data['games'][1]['away_data']['line'] }}" 
                    data-point="{{ $data['games'][1]['point'] }}" 
                    data-gamblename="{{ $data['games'][1]['home_data']['gamblename'] }}" 
                    class="bet">
                    <span class="line-blue">{{ $data['games'][1]['home_data']['line'] }}</span>
                </div>
            </td>
            @else
            <td></td>
            @endif     
            
            <td>
            @if(array_key_exists(1,$data['games']))
                {{ $data['games'][1]['home_data']['gamblename'] }}
            @endif     
            </td>
        </tr>
        
        <!--手機主隊名稱-->
        <tr class="m-game-tr-team hidden-sm hidden-md hidden-lg">
            <td colspan="6">{{ $data['teams']['home']['name'] }}[主]</td>
        </tr>
        
        <tr class="tr-height">
            <td class="hidden-sm hidden-md hidden-lg" colspan="6" style="border-left:0; border-right:0; border-bottom: 0;"></td>
            <td class="hidden-xs" colspan="7" style="border-left:0; border-right:0; border-bottom: 0;"></td>
        </tr>
        @endforeach 
        
        </tbody>
    </table>
    <!--/.賽程-->

@endforeach
</div>




@stop

@section('footer-js')

<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script src="{{ asset('front/js/gamble-refresh-common.js') }}"></script>

<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        
        var table = $("#data_list_test");
        $(".fancybox").fancybox({
            'width': 384,
            'height': 500,
            'autoScale'         : false,
            'autoDimensions'    : false,
            'scrolling'         : 'no',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'type'              : 'iframe'  
        });

        //點擊下注
        table.on("click", ".bet", function(e) {

            e.preventDefault();
            clickBet($(this))

        });//.下注

        

        
    });
</script>

@stop
