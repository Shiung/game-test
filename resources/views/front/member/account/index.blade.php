@extends('layouts.main')
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
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

<a href="{{ route('front.account.search') }}" class="btn btn-info ">重新搜尋</a>

<hr>
@if($search_result == 'Y')

<h3>搜尋結果</h3>
<div class="row">
    <div class="col-md-3">
        <ul class="list-group">
            <li class="list-group-item">
                搜尋帳戶：{{ $user->username }}({{ $user->member->name }})
            </li>
        </ul>
    </div>
    <div class="col-md-3">
        <ul class="list-group">
            <li class="list-group-item">
                搜尋區間：{{ config('member.range.'.$range) }}
            </li>
        </ul>
    </div>
    <div class="col-md-3">
        <ul class="list-group">
            <li class="list-group-item">
                類型：{{ config('member.account.type.'.$account_type) }}
            </li>
        </ul>
    </div>
    <div class="col-md-3">
        <ul class="list-group">
            <li class="list-group-item">
                目前餘額：{{ number_format($own_amount) }}
            </li>
        </ul>
    </div>
</div>

<!--列表-->
<table id="data_list" class="table table-bordered table-striped">
    <thead>
        <th>時間</th>
        <th class="no-sort">轉出</th>
        <th class="no-sort">轉入</th>
        <th class="no-sort">餘額</th>
        <th class="no-sort">類型</th>
        <th class="no-sort">說明</th>
    </thead>
    <tbody>
    @foreach($datas as $data)
    <tr>
        <td>{{ $data->created_at }}</td>
        <td>@if($data->amount < 0){{ number_format(abs($data->amount) ) }}@endif</td>
        <td>@if($data->amount >= 0){{ number_format($data->amount) }}@endif</td>
        <td>{{ number_format($data->total) }}</td>
        <td>{{ config('member.account.transfer_type.'.$data->type) }}</td>
        <td>{{ $data->description }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
<!--/.列表-->
@else 
    <h3>查無資訊，請重新搜尋</h3>
@endif


@stop

@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<script>
    $(document).ready(function() {

        var table = $("#data_list");

        $("#data_list").DataTable({
            "order": [
                [0, "desc"]
            ],
            "paging": true,
            "searching": true,
            "columnDefs": [{
              "orderable": false,
              "targets": "no-sort"
            }]
        });


        
    });
</script>

@stop
