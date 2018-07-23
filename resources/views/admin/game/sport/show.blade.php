@extends('layouts.blank') @section('head')

@stop 

@section('content') 
@inject('SportPresenter','App\Presenters\Game\SportPresenter')
<h3>#{{ $data->id }}</h3>
<hr>
<h4>基本資訊</h4>
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
	<li class="list-group-item"><b>賽程狀態： </b>{!! config('game.sport.status.'.$data->status) !!}</li>
    <li class="list-group-item"><b>比賽時間： </b>
        <br>{{ $data->start_datetime }}[當地]
        <br>{{ $data->taiwan_datetime }}[台灣]

    </li>
    <li class="list-group-item"><b>新增時間： </b>{{ $data->created_at }}</li>
</ul>

<h4>賭盤資訊</h4>
<table class="table">
	<thead>
        <tr>
            <th>賭盤類型</th>
            <th>內容</th>
            <th>新增時間</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data->games as $data)
        <tr>
            <td>{!! config('game.sport.game.type.'.$data->type) !!}</td>
            <td>
                {!! $SportPresenter->showGameSummary($data) !!}
            </td>
            <td>{{ $data->created_at }}</td>
            <td>
                <!--下注明細     
                <a href="{{ route('admin.game.'.$route_code.'.gamble.bet_record',$data->id) }}" class="btn btn-warning btn-sm" >下注明細</a>
                 -->  
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop 