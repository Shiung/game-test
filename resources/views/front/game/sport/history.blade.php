@extends('layouts.main')
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 

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
        width: 12%;
        top: -60px;
        left: -6%;
    }
    
    
    @media screen and (min-width: 1200px) and (max-width: 1399px) {
        .game-icon {
            left: -3%;
        }
    }


    @media screen and (min-width: 992px) and (max-width: 1199px) {
        .game-icon {
            top: -40px;
            left: -8%;
        }
    }
    
    @media screen and (min-width: 768px) and (max-width: 991px) {
        .game-icon {
            top: -30px;
            left: -8%;
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
    
    /*開始下注及歷史紀錄按鈕*/
    
    .game-top-btn-area {
        position: relative;
        width: 100%;
        border-bottom: 3px solid #191639;
        margin-top: 30px;
        
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
        z-index: 0;
    }
    
    .game-btn img {
        width: 100%;
    }
      
    .history-btn {
        position: absolute;
        width: 16%;
        left: 49%;
        top: 0;
        z-index: 1;
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
            z-index: 0;
        }

        .game-btn img {
            width: 100%;
        }

        .history-btn {
            position: absolute;
            width: 36%;
            left: 47%;
            top: 0;
            z-index: 1;
        }

        .history-btn img {
            width: 100%;
        }
    }
    
    /*搜尋區域*/
    #Form {
        position: relative;
        border-bottom: 3px solid #191639;
    }
    
    .game-history-search {
        position: relative;
        width: 80%;
    }
    
    .history-search {
        width: 100%;
        height: 55px;
        line-height: 55px;
        font-size: 20px;
        background-color: rgba(255, 255, 255, 0.6);
        color: #191639;
        padding: 0 30px;
        border: 0;
        border-right: 3px solid #191639;
        -webkit-appearance: none;
        border-radius: 0;
    }
    
    .game-history-search-btn {
        position: absolute;
        width: 20%;
        top: 0;
        right: 0;
    }
    
    .history-search-btn {
        width: 100%;
        height: 55px;
        line-height: 55px;
        font-size: 20px;
        font-weight: bold;
        background-color: rgba(255, 255, 255, 0.6);
        color: #191639;
        padding: 0 20px;
        border: 0;
        text-align: left;
    }
    
    @media screen and (max-width: 767px) {
        .history-search {
            height: 35px;
            line-height: 35px;
            font-size: 14px;
            padding: 0 10px;
        }
        
        .history-search-btn {
            width: 100%;
            height: 35px;
            line-height: 35px;
            font-size: 14px;
            padding: 0 10px;
        }
    }
    
    /*歷史紀錄顯示區*/
    
    .history-area {
        position: relative;
        margin-top: 20px;
    }
    
    .table-history {
        border-top: 3px solid #191639;
        border-bottom: 3px solid #191639;
    }
    
    .table-history > thead > tr > th, .table-history > tbody > tr > th, .table-history > tfoot > tr > th, .table-history > thead > tr > td, .table-history > tbody > tr > td, .table-history > tfoot > tr > td {
        border-top: 1px solid #191639;
        border-bottom: 1px solid #191639;
        color: #191639;
        font-size: 20px;
        font-weight: bold;
    }
    
    .table-history > thead > tr > th {
        border-top: 3px solid #191639;
        border-bottom: 3px solid #191639;
    }
    
    .table-history-left {
        width: 80%;
        border-right: 1px solid #191639;
        padding-left: 10px !important;
    }
    
    .table-history-right {
        width: 20%;
    }
    
    .history-last-tr {
        border-bottom: 3px solid #191639;
    }
    
    tr:nth-child(6n+4) , tr:nth-child(6n+5) , tr:nth-child(6n+6) {
	    background-color: rgba(255, 255, 255, 0.6);
	}
    
</style>
@stop 

@section('content')
@inject('SportPresenter','App\Presenters\Game\SportPresenter')

<!--背景-->
<div class="game-home-bg hidden-xs"></div>
<div class="m-game-home-bg hidden-sm hidden-md hidden-lg"></div>

<!--game icon-->
<div class="game-icon">
    <div class="game-icon-{{ $type }}"></div>
</div>

<div class="game-top-btn-area">
    
    <div class="game-time-info">
        <small>比賽時間以台灣時間顯示 </small>
    </div>
    <a href="{{ route('front.game.category.index',$type) }}">
        <div class="game-btn">
            <img src="{{ asset('front/img/ball/phone/tab_01_off.png') }}"/>
        </div>
    </a>
    <div class="history-btn">
        <img src="{{ asset('front/img/ball/phone/tab_02_off.png') }}"/>
    </div>
    
</div>


<form id="Form" style="margin-bottom:10px;">
    <div class="game-history-search">
        <input type="date" class="history-search" name="date" id="date" value="{{ $date }}">
    </div>
    <div class="game-history-search-btn">
        <button type="button" class="history-search-btn" id="search"><span class="glyphicon glyphicon-search"></span> 查詢 </button>
    </div>
</form>

<div class="history-area">
    @foreach($datas as $category_name => $item)
        
        <h4 style="color:#191639; padding-left:12px;">{{ $category_name }}</h4>

        <!--賽程-->
        <table class="table table-history" id="data_list">
            <thead>
                <tr>
                    <th class="table-history-left">時間/隊伍</th>
                    <th class="table-history-right">分數</th>
                </tr>
            </thead>
            <tbody>
                @foreach($item['sports'] as $data)
                <tr>
                    <td class="table-history-left" style="color:#0073C5;">{{ $data['taiwan_datetime'] }}</td>
                    <td class="table-history-right"></td>
                </tr>
                <tr>
                    <td class="table-history-left">{{ $data['teams']['away']['name'] }}</td>
                    <td class="table-history-right">{{ $data['teams']['away']['score'] }}</td>
                </tr>
                <tr class="history-last-tr">
                    <td class="table-history-left">{{ $data['teams']['home']['name'] }} [主]</td>
                    <td class="table-history-right">{{ $data['teams']['home']['score'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!--/.賽程-->


    @endforeach    
</div>

<input type="hidden" value="{{ $type }}" id="type">


@stop

@section('footer-js')

<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>

<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var type = $('#type').val()
        //搜尋區間範圍
        $("#search").click(function(){
            date = $('#date').val();

            if (!$('#date').val() ) {
                swal("Error", "請輸入完整搜尋日期!", 'error');
                return false;
            }

            window.location.href = APP_URL+"/game/category/"+type+"/history/"+date;
        });
        
    });
</script>

@stop
