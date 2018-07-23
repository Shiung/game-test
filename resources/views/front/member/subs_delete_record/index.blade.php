@extends('layouts.main')
@section('head')

<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@stop 

@section('content')

<h1>{{ $page_title }}</h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">會員專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->


<h3>申請紀錄</h3>

<a href="{{ route('front.member.subs_delete_record.create') }}" class="btn btn-md btn-info">申請刪除好友</a>
<!--列表-->
<table id="data_list" class="table table-bordered table-striped">
    <thead>
        <th>時間</th>
        <th class="no-sort">好友</th>
        <th class="no-sort">處理狀態</th>
    </thead>
    <tbody>
    @foreach($datas as $data)
    @if($data->status == '0')
    <tr>
        <td>{{ $data->created_at }}</td>
        <td>{{ $data->delete_user->username }}({{ $data->delete_user->member->name }})</td>
        <td>{{ config('member.transfer_ownership_record.status.'.$data->status) }}</td>
    </tr>
    @endif
    @endforeach
    </tbody>
</table>
<!--/.列表-->

@stop

@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var type = 'member';

    
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
