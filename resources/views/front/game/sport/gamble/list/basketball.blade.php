@extends('layouts.main')
@section('head')
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
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
</style>
@stop 

@section('content')
@inject('SportPresenter','App\Presenters\Game\SportPresenter')

<h1>{{ $home_team->name }} [主] vs {{ $away_team->name }}</h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">遊戲大廳</li>
    <!--<li class="breadcrumb-item"><a href="{{ route('front.game.category.index',$category->type) }}">{{ config('game.category.'.$category->type.'.name') }}-{{  $category->name }}</a></li>-->
    
    <li class="breadcrumb-item">{{ config('game.category.'.$category->type.'.name') }}-{{  $category->name }}</li>
    <li class="breadcrumb-item active">{{ $home_team->name }} [主] vs {{ $away_team->name }}</li>
</ol>
<!--/.路徑-->

<hr>

<!--餘額-->
@include('front.game.amount_detail')
<!--/.餘額-->

<div class="mod">
    <p>資料更新倒數 <em id="sec">30</em> 秒</p>
</div>
<table class="table" id="game_table">
    <thead >
        <th style="text-align:center;width:20%;"></th>
        <th style="text-align:center;width:40%;">{{ $home_team->name }}<b> [主] </b></th>
        <th style="text-align:center;width:40%;">{{ $away_team->name }}</th>
    </thead>
    <tbody style="text-align:center;" id="game_body">
        
    <tbody>
</table>



<!-- betModal -->
<div class="modal fade" id="betModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="Form_bet">
                <div class="modal-header">
                    <h5 class="modal-title" id="bet_title"></h5>
                </div>
                <div class="modal-body">
                    <div id="bet_info">
                    </div>
                    <fieldset class="form-group" >
                        <label for="win_amount">可贏金額</label>
                        <input type="number" class="form-control" readonly value="0" id="win_amount">
                    </fieldset>
                    <h4>投注金額</h4>
                    <fieldset class="form-group" >
                        <label for="cash_amount">金幣*  （餘額：{{  $account_amount['cash']  }}）</label>
                        <input type="number" class="form-control amount"  value="0" name="virtual_cash_amount" id="virtual_cash_amount" required min="0">
                    </fieldset>
                    <fieldset class="form-group" >
                        <label for="run_amount">禮券*  （餘額：{{  $account_amount['run'] }}）</label>
                        <input type="number" class="form-control amount"  value="0" name="manage_amount" id="manage_amount" required min="0">
                    </fieldset>
                    <fieldset class="form-group" >
                        <label for="interest_amount">紅利點數* （餘額： {{ $account_amount['interest'] }}） </label>
                        <input type="number" class="form-control amount"  value="0" name="interest_amount" id="interest_amount" required min="0">
                    </fieldset>
                    <fieldset class="form-group" >
                        <label for="right_amount">娛樂幣*  （餘額： {{ $account_amount['right'] }}）</label>
                        <input type="number" class="form-control amount"  value="0" name="share_amount" id="share_amount" required min="0">
                    </fieldset>
                    <input type="hidden" name="game_id" id="game_id" >
                    <input type="hidden" name="gamble" id="gamble" >
                    <input type="hidden" name="line" id="line" >
                    <input type="hidden" name="home_line" id="home_line" >
                    <input type="hidden" name="away_line" id="away_line" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">確定</button>
                </div>
            </form>
        </div>
    </div>
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
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var table = $('#game_table')
        var tbody = $('#game_body')
        var category_name = "{{ config('game.category.'.$category->type.'.name') }}";
        var category_detail = "{{ $category->name }}";
        var home_team = '{{ $home_team->name }} [主]';
        var away_team = '{{ $away_team->name }}';
        var home_team_id = '{{ $home_team->id }}';
        var away_team_id = '{{ $away_team->id }}';
        var line,game_id,gamble,point;
        var sport_id = "{{ $sport->id }}";
        
        $(".fancybox").fancybox();
        refreshGames(sport_id,tbody)

        //30秒call一次資料更新
        setInterval(function () {
            refreshGames(sport_id,tbody)
        }, refresh_second*1000);

        //點擊下注
        table.on("click", ".bet", function(e) {

            e.preventDefault();
            clickBet($(this))

        });//.下注

        
    });
</script>

@stop
