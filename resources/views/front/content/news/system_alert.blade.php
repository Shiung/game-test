@extends('layouts.front_blank')
@section('head')

@stop

@section('content')

<center><h2>重要公告 </h2></center>

<!--內容-->
<h3>{{ $data->title }}</h3>
<p>{{ $data->updated_at }}</p>

{!! $data->content !!}

@stop

@section('footer-js')



@stop
