@extends('layouts.blank') @section('head')

@stop 

@section('content') 
@inject('SportPresenter','App\Presenters\Game\SportPresenter')
<hr>
<h4>基本資訊</h4>
<ul class="list-group">  
    <li class="list-group-item"><b>期別號碼： </b>{{ $data->sport_number }}</li>
    <li class="list-group-item"><b>新增時間： </b>{{ $data->created_at }}</li>
</ul>

<h4>開獎號碼</h4>
<ul class="list-group">  
    <li class="list-group-item">
        @foreach($data->teams as $key =>  $item)
        @if($key != 0)
            、
        @endif
        {{ $item->number }}
        @endforeach
    </li>
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