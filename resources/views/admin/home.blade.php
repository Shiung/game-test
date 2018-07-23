@extends('layouts.admin')
@section('head')

@stop
@section('content')


<div class="box-body" style="min-height:900px;">
	@if($web_status == '0')
	<div class="alert alert-danger" role="alert">
	注意：前台網站目前關閉維修中
	</div>
	@endif
	<h3>歡迎來到後台管理系統</h3>
</div>

@stop
@section('footer-js')


@stop