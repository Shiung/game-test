@extends('layouts.main')
@section('head')

<!--樹本身的樣式css-->
<link rel="stylesheet" href="{{ asset('front/css/tree.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">

@stop
@section('content')

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">會員專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->
    
<h1 >{{ $page_title }}</h1>
<p>連續點擊兩下節點，可收合節點</p>
<!--樹-->   
@include("front.member.tree.component.structure")
<div style="height:200px;">
</div>

@stop
@section('footer-js')
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script src="{{ asset('front/js/tree.js?v=1.0') }}"></script>
@stop