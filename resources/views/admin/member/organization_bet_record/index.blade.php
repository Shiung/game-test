@extends('layouts.admin') 
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<style>
    .sub_member{
        color:red;
        cursor: pointer;
    }
    .sub_member:hover { 
        color: green;
    }
</style>

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


    <!--列表-->
    <table id="data_list" class="table table-bordered table-striped">
        <thead>
            <th >會員</th>
            <th >筆數</th>
            <th >金額</th>
            <th >有效下注</th>
            <th >結果</th>
            <th >紅利總額</th>
        </thead>
        <tbody>
        @foreach($datas as $data)
        @if($data['count'] > 0)
        <tr>
            <td>{{ $data['username'] }}({{ $data['name'] }})</td>
            <td>{{ $data['count'] or 0}}</td>
            <td><div class="sub_member" data-userid="{{ $data['user_id'] }}">{{ $data['amount'] or 0}}</div></td>
            <td>{{ $data['real_bet_amount'] or 0 }}</td>
            <td>{{ $data['result_amount'] or 0}}</td>
            <td>{{ $data['sub_interest_total'] or 0}}</td>
        </tr>
        @endif
        @endforeach
        <tr>
            <td>總計</td>
            <td>{{ $total_data['count'] or 0}}</td>
            <td>{{ $total_data['amount'] or 0}}</td>
            <td>{{ $total_data['real_bet_amount'] or 0 }}</td>
            <td>{{ $total_data['result_amount'] or 0}}</td>
            <td>{{ $total_data['interest_total'] or 0}}</td>
        </tr>
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



        var table = $("#data_list");
 
        table.on("click", ".sub_member", function(e) {

            e.preventDefault();
            var user_id = $(this).data('userid');

            var form = document.createElement("form");
            form.setAttribute("method", "get");
            form.setAttribute("action", "{{ route('admin.member.organization_bet_record.index') }}");

            var hiddenField = document.createElement("input"); 
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "user_id");
            hiddenField.setAttribute("value", user_id);
            form.appendChild(hiddenField);

            document.body.appendChild(form);

            form.submit();


        });
        
        
    });
</script>
@stop