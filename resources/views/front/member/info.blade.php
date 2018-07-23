@extends('layouts.main')
@section('head')

@stop

@section('content')

<h1>{{ $page_title }}</h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">會員專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->

<hr>
<h4>基本資訊</h4>
<ul class="list-group">  
    <li class="list-group-item"><b>姓名：{{ $data->name }} </b></li>
    <li class="list-group-item"><b>帳號：{{ $data->user->username }} </b></li>
    <li class="list-group-item"><b>手機：{{ $data->phone }} </b></li>
    <li class="list-group-item"><b>推薦人： </b>@if($data->recommender){{ $data->recommender->name  }}@else 無 @endif</li>
    <li class="list-group-item"><b>會員等級： </b>{{ $level  }}  (到期時間：{{ $level_expire }})</li>
    
</ul>

@stop

@section('footer-js')

@stop

