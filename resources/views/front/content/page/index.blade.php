@extends('layouts.main')
@section('head')

@stop

@section('content')

<h1>{{ $page_title }} </h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">{{ $page_title }}</li>
</ol>
<!--/.路徑-->

<!--列表-->
<table class="table">
    <thead>
        <th>標題</th>
        <th>日期</th>
    </thead>
    <tbody>
    @foreach($datas as $data)
    <tr>
        <td><a href="{{ route('front.page.show',$data->code) }}">{{ $data->title }}</a></td>
        <td>{{ $data->created_at }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
<!--/.列表-->

<!--分頁-->
<div class="page-area">{!! $datas->render() !!}</div>

@stop

@section('footer-js')



@stop
