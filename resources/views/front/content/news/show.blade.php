@extends('layouts.front_blank')
@section('head')

@stop

@section('content')

<!--內容-->
<p>標題：{{ $data->title }}</p>
<p>發布日期：{{ $data->post_date }}</p>

內容：
{!! $data->content !!}

@stop

@section('footer-js')



@stop
