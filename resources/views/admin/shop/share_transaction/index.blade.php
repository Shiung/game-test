@extends('layouts.admin') 
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
@stop 
@section('content-header',$page_title) 
@section('content')

<div class="box-header with-border">
    <ol class="breadcrumb">
        <li class="active">{{ $page_title }}</li>
    </ol>
</div>

<div class="box-body" >
    <form id="Form" style="margin-bottom:20px;">
        <div class="row">
            <div class="col-sm-4">
                <select class="form-control" id="status">
                    <option value="N">請選擇掛單狀態</option>
                    <option value="0" @if($status == '0') selected @endif>上架中</option>
                    <option value="1" @if($status == '1') selected @endif>已成交</option>
                    <option value="2" @if($status == '2') selected @endif>已過期</option>
                    <option value="3" @if($status == '3') selected @endif>已取消</option>
                </select>
            </div>
            <div class="col-sm-6">
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
    <div class="row">
        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item">娛樂幣數量：@if(count($datas)>0) {{ $datas->sum('quantity') }} @endif</li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item">金幣總金額：@if(count($datas)>0) {{ $datas->sum('amount') }}@endif</li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item">手續費總金額：@if(count($datas)>0) {{ $datas->sum('fee') }}@endif</li>
            </ul>
        </div>
    </div>
    <div class="table-responsive">
        <table id="data_list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>單號</th>
                    <th>賣方</th>
                    <th>買方</th>
                    <th>價格</th>
                    <th>數量</th>
                    <th>總額</th>
                    <th>手續費</th>
                    <th>建立時間</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>#{{ $data->transaction_number  }} </td>
                    <td><a href="{{ route('admin.member.show',$data->seller_id) }}" class="fancybox fancybox.iframe">{{ $data->seller->name }} </a></td>
                    <td>
                        @if($data->buyer)
                        <a href="{{ route('admin.member.show',$data->buyer_id) }}" class="fancybox fancybox.iframe">{{ $data->buyer->name }}</a>
                        @endif
                    </td>
                    <td>{{ $data->price  }} </td>
                    <td>{{ $data->quantity }}</td>
                    <td>{{ $data->amount }}</td>
                    <td>{{ $data->fee }}</td>
                    <td>{{ $data->created_at }}</td>
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
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var table = $("#data_list");
        $(".fancybox").fancybox();

        $("#data_list").DataTable({
            "order": [
                [7, "desc"]
            ],
            "paging": true,
            "searching": true
        });

       
        //搜尋區間範圍
        $("#search").click(function(){
            start = $('#start').val();
            end = $('#end').val();
            status = $('#status').val();

            if(status == 'N'){
                swal("Error", "請選擇掛單狀態", 'error');
                return false;
            }

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
            window.location.href = APP_URL+"/shop/{{ $route_code }}/"+status+'/'+start+'/'+end;
      });
        
    });
</script>
@stop