@extends('layouts.blank') 
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">


@stop 
@section('content-header',$page_title) 
@inject('BetPresenter','App\Presenters\Game\BetPresenter')
@section('content')


<div class="box-body" >
    <h3>賭盤類型：{{ config('game.sport.game.type.'.$data->type) }}</h3>
    <hr>
    <h4>賽程資訊</h4>
    <div class="row">
        <div class="col-sm-6">
            <h5>主隊</h5>
            <ul class="list-group">  
                <li class="list-group-item"><b>隊伍名稱： </b>{{ $home_team->name }}</li>
                <li class="list-group-item"><b>分數： </b>{{ $home_team->score }}</li>
            </ul>
        </div>
        <div class="col-sm-6">
            <h5>客隊</h5>
            <ul class="list-group">  
                <li class="list-group-item"><b>隊伍名稱： </b>{{ $away_team->name }}</li>
                <li class="list-group-item"><b>分數： </b>{{ $away_team->score }}</li>
            </ul>
        </div>
    </div>
    <div class="row">
      <div class="col-sm-3">
        <ul class="list-group">
            <li class="list-group-item">
                下注總額：{{ $datas->sum('amount') }}
            </li>
        </ul>
      </div>
    </div>

    <!--列表-->
    <table id="data_list" class="table table-bordered table-striped">
        <thead>
            <th>時間</th>
            <th class="no-sort">單號</th>
            <th class="no-sort">會員</th>
            <th class="no-sort">內容</th>
            <th class="no-sort">金額</th>
        </thead>
        <tbody>
        @foreach($datas as $data)
        <tr>
            <td>{{ $data->created_at }}</td>
            <td>{{ $data->bet_number }}</td>
            <td>{{ $data->member->name }}</td>
            <td>{!! $BetPresenter->showBetSummary($data->type,$data->id) !!}</td>
            <td>{{ $data->amount }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <!--/.列表-->
</div>
<!-- /.box-body -->

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