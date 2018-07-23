@extends('layouts.blank')
@section('head')

@stop

@section('content')

<h3>{{ $data->name }}</h3>
<ul class="list-group">  
    <li class="list-group-item"><b>帳號：{{ $data->user->username }} </b></li>
    <li class="list-group-item"><b>手機：{{ $data->phone }} </b></li>
    <li class="list-group-item"><b>會員等級： </b></li>

</ul>

@stop

@section('footer-js')

@stop

