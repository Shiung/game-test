@extends('layouts.blank') @section('head')

@stop 

@section('content') 
@inject('SportPresenter','App\Presenters\Game\SportPresenter')
<h3>賭盤類型：{{ config('game.sport.game.type.'.$data->type) }}</h3>
<hr>
<h4>賽程資訊</h4>
<div class="row">
	<div class="col-sm-6">
		<h5>主隊</h5>
		<ul class="list-group">  
			<li class="list-group-item"><b>隊伍名稱： </b>{{ $home_team->name }}</li>
		    <li class="list-group-item"><b>分數： </b>{{ $home_team->score }}</li>
		</ul>
	</div>
	<div class="col-sm-6">
		<h5>客隊</h5>
		<ul class="list-group">  
			<li class="list-group-item"><b>隊伍名稱： </b>{{ $away_team->name }}</li>
		    <li class="list-group-item"><b>分數： </b>{{ $away_team->score }}</li>
		</ul>
	</div>
</div>
<ul class="list-group">  
	<li class="list-group-item"><b>賽程狀態： </b>{!! config('game.sport.status.'.$sport->status) !!}</li>
    <li class="list-group-item"><b>比賽時間： </b>
    	<br>{{ $sport->start_datetime }}[當地]
        <br>{{ $sport->taiwan_datetime }}[台灣]
    </li>
    <li class="list-group-item"><b>新增時間： </b>{{ $sport->created_at }}</li>
</ul>

<h4>賭盤參數資訊</h4>
<ul class="list-group">
    <li class="list-group-item"><b>賭盤狀態： </b>{!! config('game.sport.game.bet_status.'.$data->bet_status) !!}</li>  
    <li class="list-group-item"><b>平局點： </b>{{ $detail->dead_heat_point or '未設定' }}</li>
    <li class="list-group-item"><b>有效下注額： </b>{{ $detail->real_bet_ratio or '未設定' }}</li>
    <li class="list-group-item"><b>讓分單邊下注值： </b> {{ $detail->spread_one_side_bet or '未設定' }}</li>
    <li class="list-group-item"><b>原始賠率： </b>[大]{{ $detail->home_line or '未設定' }}／ [小]{{ $detail->away_line or '未設定' }}</li>
    <li class="list-group-item"><b>賠率調整參數： </b>{{ $detail->adjust_line  }}</li>
    <li class="list-group-item"><b>網站顯示賠率： </b>
        @if($detail->home_line && $detail->away_line)
        [大]{{ $detail->home_line + $detail->adjust_line }}／ [小]{{ $detail->away_line + $detail->adjust_line }}
        @else 
        未設定原始賠率
        @endif
    </li>
    <li class="list-group-item"><b>賭盤新增時間： </b>{{ $detail->created_at }}</li>

</ul>
@stop 