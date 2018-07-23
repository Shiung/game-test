@extends('layouts.main')
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

<a href="{{ route('front.organization_bet_record.search') }}" class="btn btn-info ">重新搜尋</a>

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
        <th >好友名稱</th>
        <th >筆數</th>
        <th >金額</th>
        <th >有效下注</th>
        <th >結果</th>
        <th >紅利點數總額</th>
    </thead>
    <tbody>
    @foreach($datas as $data)
    @if($data['count'] > 0)
    <tr>
        <td>{{ $data['username'] }}({{ $data['name'] }})</td>
        <td>{{ $data['count'] or 0}}</td>
        <td>
            <div class="sub_member" data-userid="{{ $data['user_id'] }}">
                {{ thousandsFormat($data['amount'],0) }}
            </div>
        </td>
        <td>
            {{ thousandsFormat($data['real_bet_amount'],0) }}
        </td>
        <td>
            {{ thousandsFormat($data['result_amount'],0) }}
        </td>
        <td>
            {{ thousandsFormat($data['sub_interest_total'],0 ) }}
        </td>
    </tr>
    @endif
    @endforeach
    <tr>
        <td>總計</td>
        <td>{{ $total_data['count'] or 0}}</td>
        <td>
            {{ thousandsFormat($total_data['amount'],0) }}
        </td>
        <td>
            {{ thousandsFormat($total_data['real_bet_amount'],0) }}
        </td>
        <td>
            {{ thousandsFormat($total_data['result_amount'],0) }}
        </td>
        <td>
            {{ thousandsFormat($total_data['interest_total'],0) }}
        </td>
    </tr>
    </tbody>
</table>
<!--/.列表-->
@else 
    <h3>找不到此帳戶，請重新搜尋</h3>

    <p>找不到帳戶原因可能為：</p>
    <ul>
        <li>此帳號不存在</li>
        <li>此帳號不存在於您的安置樹下</li>
        <li>此帳號超過可查詢代數限制</li>
    </ul>
@endif


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
            form.setAttribute("action", "{{ route('front.organization_bet_record.index') }}");

            var hiddenField = document.createElement("input"); 
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "user_id");
            hiddenField.setAttribute("value", user_id);
            form.appendChild(hiddenField);

            var hiddenField_branch = document.createElement("input"); 
            hiddenField_branch.setAttribute("type", "hidden");
            hiddenField_branch.setAttribute("name", "user_type");
            hiddenField_branch.setAttribute("value", 'sub');
            form.appendChild(hiddenField_branch);

            document.body.appendChild(form);

            form.submit();


        });



        
    });
</script>

@stop
