@extends('layouts.admin') 
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 

@stop 
@section('content-header',$page_title) 
@section('content')

<div class="box-header with-border">
    <ol class="breadcrumb">
        <li class="active">{{ $page_title }}</li>
    </ol>
</div>
<form id="Form" style="margin-bottom:20px;padding-right:20px;">
    <div class="row">
        <div class="col-sm-3">
            <select class="form-control" id="record_name" name="record_name">
                <option value="%" @if($record_name == '%') selected @endif>全部</option>
                @foreach($name_datas as $name_data)
                <option value="{{ $name_data->name }}" @if($record_name == $name_data->name) selected @endif>{{ $name_data->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-7">
            <div class="input-group">
                <input type="date" class="form-control" name="start" id="start" value="{{ $start }}">
                <span class="input-group-addon">~</span>
                <input type="date" class="form-control" name="end" id="end" value="{{ $end }}">
            </div>
        </div>
        <div class="col-sm-2">
            <input type="button" class="btn btn-info btn-block" id="search" value="查詢" >
        </div>
    </div>
    
</form>
<div class="box-body" >
    
    <div class="table-responsive">
        <table id="data_list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>排程名稱</th>
                    <th>執行開始時間</th>
                    <th>執行結束時間</th>
                    <th>執行結果</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{ $data->name }} </td>
                    <td>{{ $data->start_datetime }} </td>
                    <td>{{ $data->end_datetime }}</td>
                    <td>@if(json_decode($data->result, true)['result'] == 1)
                        <span style="color:green;">成功</span>
                        @else 
                        <span style="color:red;">失敗</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop 
@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-confirm/jquery.confirm.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>

<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var table = $("#data_list");


        $("#data_list").DataTable({
            "order": [
                [2, "desc"]
            ],
            "paging": true,
            "searching": true
        });

       
        //搜尋區間範圍
        $("#search").click(function(){
            start = $('#start').val();
            end = $('#end').val();
            name = $('#record_name').val();

            if (Date.parse(start) > Date.parse(end) ) {
                swal("Error", "日期範圍有誤，請重新輸入!", 'error');
                return false;
            }

            if (!$('#start').val() || !$('#end').val()) {
                swal("Error", "請輸入完整搜尋日期!", 'error');
                return false;
            }

           if(!dateValidationCheck(start) ||  !dateValidationCheck(end)){
                swal("Failed", "日期格式有誤",'error');
                return false;
            }
            window.location.href = APP_URL+"/system/{{ $route_code }}/"+start+'/'+end+'/'+name;
      });
        
    });
</script>
@stop