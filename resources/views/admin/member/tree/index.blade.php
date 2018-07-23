@extends('layouts.blank')
@section('head')

<!--樹本身的樣式css-->
<link rel="stylesheet" href="{{ asset('front/css/tree.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<style>
    @include("front.member.tree.component.tree_css")
</style>
@stop

@section('content')

    
<h1>{{ $page_title }}</h1>
<p>連續點擊兩下節點，可收合節點</p>
 
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