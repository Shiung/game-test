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

<h4>開獎結果</h4>
<ul class="list-group">  
    <li class="list-group-item">
        @foreach($data->teams as $key =>  $item)
        @if($key != 0)
            、
        @endif
        <span style="color:{{ config('cn_chess.number_to_chess.'.$item->number.'.color') }}">{{ config('cn_chess.number_to_chess.'.$item->number.'.chess') }}</span>
        @endforeach
    </li>
</ul>

<h4>賭盤資訊</h4>
<table class="table">
	<thead>
        <tr>
            <th>賭盤類型</th>
            <th>內容</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data->games as $data)
        <tr>
            <td>{!! config('game.sport.game.type.'.$data->type) !!}</td>
            <td>
                {!! $SportPresenter->showGameSummary($data) !!}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop 