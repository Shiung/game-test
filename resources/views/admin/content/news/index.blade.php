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
    @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))
    <div class="text-right">
        <a href="{{ route('admin.'.$route_code.'.create') }}"><button class="btn btn-primary btn-sm" data-toggle="tooltip" title="新增"><i class="fa fa-fw fa-plus"></i></button></a>
    </div>
    @endif
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
                    <th>標題</th>
                    <th>發布日期</th>
                    <th>狀態</th>
                    <th>新增日期</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{ $data->title }}</td>
                    <td>{{ $data->post_date }}</td>
                    <td>{!! config('content.news.status.'.$data->status) !!}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>
                        <a href="{{ route('admin.'.$route_code.'.edit',$data->id) }}"><button class="btn btn-primary btn-sm"  data-toggle="tooltip" title="編輯" ><i class="fa fa-pencil-square-o"></i></button></a>
                        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))
                        <button class="btn btn-danger btn-sm delete" data-toggle="tooltip" title="刪除" data-id="{{ $data->id }}" data-name="{{ $data->title }}"><i class="fa fa-trash"></i></button>
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

        //刪除   
        table.on("click", ".delete", function(e) {

            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');

            //確認訊息
            $.confirm({
                text: "確認刪除 " + name + " ?",
                confirm: function(button) {
                    
                    sendUri = APP_URL + "/content/{{ $route_code }}/" + id;
                    sendData = { '_token': token,'_method': 'DELETE'};
                    system_ajax(sendUri,sendData,"DELETE",function(data){
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


          window.location.href = APP_URL+"/content/{{ $route_code }}/"+start+'/'+end;
      });
        
    });
</script>
@stop