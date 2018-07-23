@extends('layouts.main')
@section('head')

@stop

@section('content')

<h1>{{ $data->title }} </h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">首頁</li>
    <li class="breadcrumb-item active">{{ $data->title }}</li>
</ol>
<!--/.路徑-->

<!--內容-->

{!! $data->content !!}

@stop

@section('footer-js')



@stop
