@extends('layouts.admin') 
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">


@stop 
@section('content-header',$page_title) 
@inject('BetPresenter','App\Presenters\Game\BetPresenter')
@section('content')

<div class="box-header with-border">
    <ol class="breadcrumb">
        <li class="active">{{ $page_title }}</li>
    </ol>

</div>

<div class="box-body" >

    <a href="{{ route('admin.member.organization_bet_record.search') }}" class="btn btn-info ">重新搜尋</a>

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
            下注總額：{{ $record_total['amount'] }}
        </li>
        <li class="list-group-item">
            有效下注總額：{{ $record_total['real_bet_amount'] }}
        </li>
        <li class="list-group-item">
            結果總額：{{ $record_total['result_amount'] }}
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
            <td>{{ $data['amount'] }}</td>
            <td>{{ $data['real_bet_amount'] }}</td>
            <td>{{ $data['result_amount'] }}</td>
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
            "searching": true,
            "columnDefs": [{
              "orderable": false,
              "targets": "no-sort"
            }]
        });
        
        
    });
</script>
@stop