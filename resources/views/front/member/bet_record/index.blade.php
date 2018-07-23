@extends('layouts.main')
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@stop 

@section('content')
@inject('BetPresenter','App\Presenters\Game\BetPresenter')
<h1>{{ $page_title }} </h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">會員專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->

<hr>

<a href="{{ route('front.bet_record.search') }}" class="btn btn-info ">重新搜尋</a>

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
                搜尋區間：{{ $range }}
            </li>
        </ul>
    </div>
    
</div>
<div class="row">
    <div class="col-md-3">
        <ul class="list-group">
            <li class="list-group-item">
                帳戶類型：{{ $account_type }}
            </li>
        </ul>
    </div>
    <div class="col-md-3">
        <ul class="list-group">
            <li class="list-group-item">
                遊戲類型：{{ $sport_type }}
            </li>
        </ul>
    </div>
</div>

<ul class="list-group">
    <li class="list-group-item">
        下注總額：{{ number_format($record_total['amount']) }}
    </li>
    <li class="list-group-item">
        有效下注總額：{{ number_format($record_total['real_bet_amount']) }}
    </li>
    <li class="list-group-item">
        結果總額：{{ number_format($record_total['result_amount']) }}
    </li>
</ul>

<p>有效下注、結果若無數字，表示該下注尚未計算結果</p>
<!--列表-->
<table id="data_list" class="table table-bordered table-striped">
    <thead>
        <th>時間</th>
        <th class="no-sort">單號</th>
        <th class="no-sort">幣別</th>
        <th class="no-sort">球賽種類</th>
        <th class="no-sort">內容</th>
        <th class="no-sort">金額</th>
        <th class="no-sort">有效下注</th>
        <th class="no-sort">結果</th>
    </thead>
    <tbody>
    @foreach($datas as $data)
    <tr>
        <td>{{ $data['created_at'] }}</td>
        <td>{{ $data['bet_number'] }}</td>
        <td>{{ config('member.account.type.'.$data['account_type']) }}</td>
        <td>{{ config('game.category.category_id_to_name.'.$data['sport_type']) }}  <span style="color:red;">{{ config('game.sport.game.type.'.$data['bet_type']) }}</span></td>
        <td>{!! $BetPresenter->showBetSummary($data['bet_type'],$data['bet_id']) !!}</td>
        <td>{{ thousandsFormat($data['amount']) }}</td>
        <td>{{ thousandsFormat($data['real_bet_amount']) }}</td>
        <td>{{ thousandsFormat($data['result_amount']) }}</td>
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
