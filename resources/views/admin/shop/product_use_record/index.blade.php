@extends('layouts.admin') 
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">

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
            <div class="col-sm-10">
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
    <div class="table-responsive">
        <table id="data_list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>會員</th>
                    <th>商品</th>
                    <th>數量</th>
                    <th>日期</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td><a href="{{ route('admin.member.show',$data->member->user_id) }}" class="fancybox fancybox.iframe">{{ $data->member->name }} </a></td>
                    <td><a href="{{ route('admin.product.show',$data->product->id) }}" class="fancybox fancybox.iframe">{{ $data->product->name }}</a></td>
                    <td>{{ $data->quantity }}</td>
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

<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var table = $("#data_list");
        $(".fancybox").fancybox();
         $("#data_list").DataTable({
            "order": [
                [3, "desc"]
            ],
            "paging": true,
            "searching": true
        });
       
        //搜尋區間範圍
        $("#search").click(function(){
            start = $('#start').val();
            end = $('#end').val();

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
            window.location.href = APP_URL+"/shop/{{ $route_code }}/"+start+'/'+end;
      });
        
    });
</script>
@stop