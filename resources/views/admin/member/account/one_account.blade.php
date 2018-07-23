@extends('layouts.admin') 
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">


@stop 
@section('content-header',$page_title) 
@section('content')
@inject('AccountRecordPresenter','App\Presenters\AccountRecordPresenter')
<div class="box-header with-border">
    <ol class="breadcrumb">
        <li class="active">{{ $page_title }}</li>
    </ol>

</div>

<div class="box-body" >

    <a href="{{ route('admin.member.account.search') }}" class="btn btn-info ">重新搜尋</a>

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
                    搜尋區間：
                    @if($range == 'all')
                    全部
                    @else
                    {{ config('member.range.'.$range) }}
                    @endif
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
                    目前餘額：{{ $own_amount }}
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
            <td data-sort="{{ $data->id }}">{{ $data->created_at }}</td>
            <td>@if($data->amount < 0){{ abs($data->amount) }}@endif</td>
            <td>@if($data->amount >= 0){{ $data->amount }}@endif</td>
            <td>{{ $data->total }}</td>
            <td>{{ config('member.account.transfer_type.'.$data->type) }}</td>
            <td>{{ $AccountRecordPresenter->showDescription($data)   }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <!--/.列表-->
    @else 
        <h3>找不到此帳戶，請重新搜尋</h3>
    @endif
</div>
<!-- /.box-body -->
<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
@stop 
@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<script>
    $(document).ready(function() {

        $("#data_list").DataTable({
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [[10, 25, 50,100,200, -1], [10, 25, 50,100,200, "All"]],
            "paging": true,
            "sDom": '<"datasearch"f>rt<"datapage"p><"clear">', 
            "searching": true,
            "columnDefs": [{
              "orderable": false,
              "targets": "no-sort"
            }]
        });
        
        
    });
</script>
@stop