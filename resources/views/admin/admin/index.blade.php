@extends('layouts.admin') @section('head')
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" /> 
@stop 
@section('content-header',$page_title) 
@section('content')

<div class="box-header with-border">
    <ol class="breadcrumb">
        <li class="active">管理員列表</li>
    </ol>
    @if(Auth::guard('admin')->user()->hasRole('master-admin') || Auth::guard('admin')->user()->hasRole('super-admin'))
    <div class="text-right">
        <a href="{{ route('admin.admin.create') }}"><button class="btn btn-primary btn-sm" data-toggle="tooltip" title="新增"><i class="fa fa-fw fa-plus"></i></button></a>
    </div>
    @endif
</div>

<div class="box-body">
    <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>名字</th>
                    <th>帳號</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data) 
                    @if(!$data->hasRole('super-admin'))
                    <tr>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->username }}</td>
                        <td>
                          <a href="{{ route('admin.admin.edit',$data->id) }}"><button class="btn btn-primary btn-sm"  data-toggle="tooltip" title="編輯" ><i class="fa fa-pencil-square-o"></i></button></a>
                           
                          @if ( $data->type == 1)
                             <a href="{{ route('admin.admin.permission',$data->id) }}"><button class="btn btn-warning btn-sm"  data-toggle="tooltip" title="權限管理" ><i class="fa fa-cog"></i></button></a>
                            <button class="btn btn-danger btn-sm delete"  data-toggle="tooltip" title="刪除" data-id="{{ $data->id }}" data-name="{{ $data->name }}"><i class="fa fa-trash"></i></button>                                     
                        
                          @endif
                        </td>  
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">   
    </div>
			
@stop
@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-confirm/jquery.confirm.min.js') }}"></script>
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script>
  $(document).ready(function() {

    var token=$('input[name="_token"]').val();
    var table  = $("#example1"); 
    
    table.DataTable({
        "order": [[ 1, "desc" ]],
         "paging": true
      });
    
    table.on("click",".delete", function(e){
      e.preventDefault();  
      var id=$(this).data('id');
      var name=$(this).data('name');
      var tr=$(this).parent().parent();

      $.confirm({
        text: "確認刪除 "+name+" ?",
        confirm: function(button) {

          sendUri = APP_URL + "/system/{{ $route_code }}/"+id ;
          sendData = $('#Form').serialize()+'&_token='+token;
          system_ajax(sendUri,sendData,"DELETE",function(data){
              window.location.href = APP_URL+"/system/{{ $route_code }}";
          });
         
        },
        cancel: function(button) {
        },
        confirmButton: "確認",
        cancelButton: "取消"
      });//.confirm
    });//.delete       
  });
</script>
@stop