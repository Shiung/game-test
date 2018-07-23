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
                    <th>金額</th>
                    <th>確認狀態</th>
                    <th>申請日期</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td><a href="{{ route('admin.member.show',$data->member_id) }}" class="fancybox fancybox.iframe">{{ $data->member->name }} <small>({{ $data->member->member_number }})</small></a></td>
                    <td>{{ $data->amount }}</td>
                    <td>{!! config('shop.charge.confirm_status.'.$data->confirm_status) !!}
                        @if($data->confirm_status == 1 || $data->confirm_status == 2) 
                        <br><p style="font-size:10px">確認時間：{{ $data->confirm_at }}</p>
                        @endif
                    </td>
                    <td>{{ $data->created_at }}</td>
                    <td>
                        @if($data->confirm_status == 0)
                         <button type="button" class="btn btn-success btn-sm confirm" data-id="{{ $data->id }}" data-name="{{ $data->member->name }}" data-amount="{{ $data->amount }}" data-status="1">確認發放</button>
                         <button type="button" class="btn btn-danger btn-sm confirm" data-id="{{ $data->id }}" data-name="{{ $data->member->name }}" data-amount="{{ $data->amount }}" data-status="2">拒絕發放</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- /.box-body -->
<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
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
                [3, "desc"]
            ],
            "paging": true,
            "searching": true
        });

        //刪除   
        table.on("click", ".confirm", function(e) {

            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');
            var amount = $(this).data('amount');
            var status = $(this).data('status');
            if(status == 1){
                status_text = '發放';
            } else {
                status_text = '拒絕發放';
            }
            //確認訊息
            $.confirm({
                text: "確認 "+status_text+""+amount+" 給 " + name + " ?",
                confirm: function(button) {
                    
                    sendUri = APP_URL + "/shop/{{ $route_code }}/" + id;
                    sendData = { '_token': token,'_method': 'PUT','status':status};
                    system_ajax(sendUri,sendData,"PUT",function(data){
                        window.location.reload();
                    });
                    
                },
                cancel: function(button) {},
                confirmButton: "確認",
                cancelButton: "取消"
            }); //.確認訊息
        });//.刪除

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