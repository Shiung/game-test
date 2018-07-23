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

<h1>最新彩球539</h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">遊戲大廳</li>
    <li class="breadcrumb-item ">彩球539</li>
    <li class="breadcrumb-item active">最新</li>
</ol>
<!--/.路徑-->


<!--餘額-->

<div class="row">
    <div class="col-md-3">
        <ul class="list-group">
            <li class="list-group-item">
                {!! config('member.account.type_icon.1') !!}{{ config('member.account.type.1') }}可用餘額：{{ number_format($account_amount['cash']) }}
            </li>
        </ul>
    </div>
    <div class="col-md-3">
        <ul class="list-group">
            <li class="list-group-item">
                {!! config('member.account.type_icon.4') !!}{{ config('member.account.type.4') }}可用餘額：{{ number_format($account_amount['interest']) }}
            </li>
        </ul>
    </div>
    <div class="col-md-3">
        <ul class="list-group">
            <li class="list-group-item">
                {!! config('member.account.type_icon.3') !!}{{ config('member.account.type.3') }}可用餘額：{{ number_format($account_amount['right']) }}
            </li>
        </ul>
    </div>
    <div class="col-md-3">
        <ul class="list-group">
            <li class="list-group-item">
                {!! config('member.account.type_icon.2') !!}{{ config('member.account.type.2') }}可用餘額：{{ number_format($account_amount['run']) }}
            </li>
        </ul>
    </div>
</div>
<!--/.餘額-->

<hr>
<a href="{{ route('front.game.category.history',['lottery539',date('Y-m-d')]) }}" class="btn btn-primary">歷史紀錄</a>

<table class="table" id="game_table">
    <tbody style="text-align:center;" id="game_body">
        @foreach($games as $game)
        <tr>
            <td>{{ config('game.sport.game.type.'.$game['type']) }}</td>
            <td>
                <div class="bet" data-gameid="{{ $game['id'] }}" data-betstatus="{{ $game['bet_status'] }}" > 
                    {!! $SportPresenter->showGameRule($game) !!}
                </div>
            </td>
        </tr>
        @endforeach
    <tbody>
</table>


@stop

@section('footer-js')

<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script>
    $(document).ready(function() {
        var table = $('#game_table')
        $(".fancybox").fancybox();
        //點擊下注
        table.on("click", ".bet", function(e) {

            e.preventDefault();

            //取得主要文字參數
            game_id = $(this).data('gameid');//玩法id
            betstatus = $(this).data('betstatus');//下注狀態

            if(betstatus == '1'){
                $.fancybox.open({
                    padding : 0,
                    href:APP_URL+"/game/{{ $route_code }}/gamble/"+game_id+"/bet",
                    type: 'iframe'
                });
            }

        });//.下注
        
    });
</script>

@stop
