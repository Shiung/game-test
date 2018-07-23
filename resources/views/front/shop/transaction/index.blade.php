@extends('layouts.main')
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
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
    <li class="breadcrumb-item">會員專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->

<hr>

<!--時間區間-->
<form id="Form" style="margin-bottom:20px;">
    <div class="input-group">
        <input type="text" class="form-control" name="start" id="start" value="{{ $start }}" placeholder="ex 2017-01-01">
        <span class="input-group-addon">~</span>
        <input type="text" class="form-control" name="end" id="end" value="{{ $end }}" placeholder="ex 2017-02-01">
        <span class="input-group-btn">
            <input type="button" class="btn btn-info" id="search" value="查詢" >
        </span>
    </div>
</form>
<!--/.時間區間-->

<!--列表-->
<table id="data_list" class="table table-bordered table-striped">
    <thead>
        <th>商品名稱</th>
        <th>取得方式</th>
        <th>數量</th>
        <th>備註</th>
        <th>取得日期</th>
    </thead>
    <tbody>
    @foreach($datas as $data)
    <tr>
        <td><a href="{{ route('front.shop.product.show',[$data->product->id,0]) }}" class="fancybox fancybox.iframe">{{ $data->product->name }}</a></td>
        <td>{{ config('shop.transaction.type.'.$data->type)  }} </td>
        <td>{{ number_format($data->quantity) }}</td>
        <td>{{ $data->description }}</td>
        <td>{{ $data->created_at }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
<!--/.列表-->

@stop

@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>

<script src="{{ asset('front/js/recordcommon.js') }}"></script>
<script>
    $(document).ready(function() {


        $("#data_list").DataTable({
            "order": [
                [4, "desc"]
            ],
            "paging": true,
            "searching": true
        });

        //搜尋區間範圍
        $("#search").click(function(){
            searchDateRange($('#start').val(),$('#end').val(),"/shop/{{ $route_code }}/")
        });
        
    });
</script>

@stop
