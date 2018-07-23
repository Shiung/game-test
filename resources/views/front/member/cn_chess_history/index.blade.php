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
    <li class="breadcrumb-item">會員專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->

<hr>

<div class="input-group">
    <input type="date" class="form-control" name="date" id="date" value="{{ $date }}">
    <span class="input-group-btn">
        <button class="btn btn-info" type="button" id="search">查詢</button>
    </span>
</div>


<p style="color:red;">僅供查詢過去7日內的開獎結果</p>
<!--列表-->
<table id="data_list" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>期別</th>
            <th>開獎結果</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datas as $data)
        @if(count($data->teams) == 5)
        <tr>
            <td>{{ $data->sport_number}}</td>
            <td>
                @foreach($data->teams as $key =>  $item)
                @if($key != 0)
                    、
                @endif
                <span style="color:{{ config('cn_chess.number_to_chess.'.$item->number.'.color') }}">{{ config('cn_chess.number_to_chess.'.$item->number.'.chess') }}</span>
                @endforeach
            </td>
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
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
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

        //搜尋區間範圍
        $("#search").click(function(){
            date = $('#date').val();

            if (!$('#date').val() ) {
                swal("注意", "請輸入查詢日期", 'warning');
                return false;
            }

            //計算相差天數是否七日內
            var d1=new Date(date);
            var d2=new Date();
            var days=(d2-d1)/86400000;
            if(days > 7){
                swal("注意", "僅供查詢過去7日內的開獎結果", 'warning');
                return false;
            }
            window.location.href = APP_URL+"/cn_chess_history/"+date;
        });


        
    });
</script>

@stop
