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
    <div class="box-body">
    <div class="tabbable-panel">
      <div class="tabbable-line">
        <ul class="nav nav-tabs ">
          <li class="active">
            <a href="#tab_show" data-toggle="tab">
            顯示中 </a>
          </li>
          <li>
            <a href="#tab_hidden" data-toggle="tab">
            已刪除隱藏 </a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_show">
            <div class="table-responsive">
                <table id="data_list_show" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>編號</th>
                            <th>帳號</th>
                            <th>名稱</th>
                            <th>手機</th>
                            <th>登入權限</th>
                            <th>加入日期</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas->where('show_status','1')->all() as $data)
                        <tr>
                            <td>#{{ $data->member_number }}</td>
                            <td>{{ $data->user->username }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->phone }} </td>
                            <td>
                                <div class="btn-group login_permission" data-toggle="buttons">
                                    <label class="btn @if($data->user->login_permission==0)  btn-primary @else btn-default @endif">
                                        <input type="radio" data-id="{{ $data->user_id }}" data-status="0" name="login_permission" data-name="{{ $data->name }}"@if($data->user->login_permission==0) checked @endif>關閉
                                    </label>
                                    <label class="btn @if($data->user->login_permission==1) btn-primary @else btn-default @endif"  >
                                        <input type="radio" data-id="{{ $data->user_id }}" data-status="1" name="login_permission" data-name="{{ $data->name }}" @if($data->user->login_permission==1) checked @endif>開啟
                                    </label>
                                </div>
                            </td>
                            <td>{{ $data->created_at }} </td>
                            <td>
                                <a href="{{ route('admin.'.$route_code.'.show',$data->user_id) }}" class="fancybox fancybox.iframe"><button class="btn btn-info btn-sm"  data-toggle="tooltip" title="瀏覽" ><i class="fa fa-eye"></i></button></a>
                                <a href="{{ route('admin.'.$route_code.'.tree',$data->user_id) }}" class="fancybox fancybox.iframe"><button class="btn btn-default btn-sm"  data-toggle="tooltip" title="社群" ><i class="fa fa-sitemap"></i></button></a>
                                <a href="{{ route('admin.'.$route_code.'.subs',$data->user_id) }}" ><button class="btn btn-success btn-sm"  data-toggle="tooltip" title="好友列表" ><i class="fa fa-users"></i></button></a>
                                
                                @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))
                                <a href="{{ route('admin.'.$route_code.'.edit',$data->user_id) }}" ><button class="btn btn-primary btn-sm"  data-toggle="tooltip" title="編輯" ><i class="fa fa-pencil"></i></button></a>
                                <a href="{{ route('admin.'.$route_code.'.reset_pwd',$data->user_id) }}"><button class="btn btn-warning btn-sm"  data-toggle="tooltip" title="重設密碼" ><i class="fa fa-lock"></i></button></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
          <div class="tab-pane" id="tab_hidden">
            <div class="table-responsive">
                <table id="data_list_hidden" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>編號</th>
                            <th>帳號</th>
                            <th>名稱</th>
                            <th>手機</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas->where('show_status','0')->all() as $data)
                        <tr>
                            <td>#{{ $data->member_number }}</td>
                            <td>{{ $data->user->username }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->phone }} </td>
                            <td>
                                <a href="{{ route('admin.'.$route_code.'.show',$data->user_id) }}" class="fancybox fancybox.iframe"><button class="btn btn-info btn-sm"  data-toggle="tooltip" title="瀏覽" ><i class="fa fa-eye"></i></button></a>
                                <!--<a href="{{ route('admin.'.$route_code.'.subs',$data->user_id) }}" ><button class="btn btn-success btn-sm"  data-toggle="tooltip" title="好友列表" ><i class="fa fa-users"></i></button></a>-->
                                
                                @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))
                               <!-- <a href="{{ route('admin.'.$route_code.'.edit',$data->user_id) }}" ><button class="btn btn-primary btn-sm"  data-toggle="tooltip" title="編輯" ><i class="fa fa-pencil"></i></button></a>
                                <a href="{{ route('admin.'.$route_code.'.reset_pwd',$data->user_id) }}"><button class="btn btn-warning btn-sm"  data-toggle="tooltip" title="重設密碼" ><i class="fa fa-lock"></i></button></a>-->
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">   
    </div>
        <!-- /.box-body -->     
    
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
        var table = $("#data_list_show");
        var previous;
         $(".fancybox").fancybox();

        $("#data_list_show").DataTable({
            "order": [
                [5, "desc"]
            ],
            "paging": true,
            "searching": true
        });

        $("#data_list_hidden").DataTable({
            "order": [
                [0, "desc"]
            ],
            "paging": true,
            "searching": true
        });


        //更新登入權限 
        table.on("change", ".login_permission :input", function(e) {

            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');
            var status = $(this).data('status');
            var label = $(this).parent()
  
            

            //確認訊息
            $.confirm({
                text: "確認改變「" + name + "」   帳號登入權限?",
                confirm: function(button) {
                    
                    sendUri = APP_URL + "/{{ $route_code }}/login-permission/" + id;
                    sendData = { '_token': token,'_method': 'PUT','login_permission':status};
                    system_ajax(sendUri,sendData,"PUT",function(data){
                        label.removeClass("btn-default");
                        label.addClass("btn-primary");
                        label.removeClass("active");
                        label.siblings().addClass("btn-default");
                        label.siblings().removeClass("btn-primary");
                    });
                    
                },
                cancel: function(button) {
                    label.removeClass("active");
                },
                confirmButton: "確認",
                cancelButton: "取消"
            }); //.確認訊息
        });//.更新登入權限



        
        
    });
</script>
@stop