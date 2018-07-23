@extends('layouts.main')
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
@stop 
@section('content')
<h1>{{ $page_title }} </h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">商城專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->

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
        <th>編號</th>
        <th>申請金額</th>
        <th>確認狀態</th>
        <th>申請日期</th>
    </thead>
    <tbody>
    @foreach($datas as $data)
    <tr>
        <td>#{{ $data->id }}</td>
        <td>{{ number_format($data->amount) }}</td>
        <td>{!! config('shop.withdrawal.confirm_status.'.$data->confirm_status) !!}
            @if($data->confirm_status == 1) 
            <br><small>時間：{{ $data->confirm_at }}</small>
            @endif

            @if($data->confirm_status == 2) 
            <br><small>時間：{{ $data->confirm_at }}</small>
            @endif
        </td>
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
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('front/js/recordcommon.js') }}"></script>
<script>
    $(document).ready(function() {
        
        $("#data_list").DataTable({
            "order": [
                [3, "desc"]
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
