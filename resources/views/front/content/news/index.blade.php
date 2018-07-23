@extends('layouts.main')
@section('head')
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script>
  $(function() {
    $(".fancybox").fancybox();  
  });
</script>
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
        <th>公告日期</th>
    </thead>
    <tbody>
    @foreach($datas as $data)
    <tr>
        <td><a href="{{ route('front.news.show',$data->id) }}" class="fancybox fancybox.iframe">{{ $data->title }}</a></td>
        <td>{{ $data->post_date }}</td>
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
