@extends('layouts.dashboard')
@section('head')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables/dataTables.bootstrap.css') }}">
  <!-- 打開外部視窗 fancy -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
  <!-- Alert -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert/sweetalert.css') }}">

  <link rel="stylesheet" href="{{ asset('admin/plugins/HoldOn/HoldOn.min.css') }}">
  <style>
  .tab-part {
    margin-top:20px;
  }
  .datatable{
    margin-top:20px;
  }
  </style>
@stop

@section('content')

<!--備份-->
<div class="box-body" style="min-height:900px;">
  <div class="box-header with-border">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">@lang('default-admin.index')</li>
      <li class="breadcrumb-item active">@lang('default-admin.sidemenu.data_backup')</li>
    </ol>  
  </div>

  <div class="tabbable-panel">
    <div class="tabbable-line">
      <ul class="nav nav-tabs ">
        <li class="active">
          <a href="#tab_default_1" data-toggle="tab">手動</a>
        </li>
        <li>
          <a href="#tab_default_2" data-toggle="tab">自動</a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_default_1">
          <div class="tab-part">
            <div class="text-center">
              <button class="btn btn-primary " id="backup" >手動備份</button>                                                                      
            </div>

            <div class="table-responsive datatable">
              <table id="data_list" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>時間</th>  
                    <th>@lang('default-admin.action.action')</th>                         
                  </tr>
                </thead>
                <tbody>
                @foreach($manuals as $manual)
                <tr>   
                  <td>{{ $manual->created_at }}</td>
                  <td>
                    <a href="{{ route('dashboard.backup.download',$manual->id) }}" target="_blank" class="btn btn-success btn-sm">下載</a>
                    <button class="btn btn-danger btn-sm delete"  data-toggle="tooltip" title="@lang('default-admin.action.delete')" data-id="{{ $manual->id }}" data-name="{{ $manual->created_at }}"><i class="fa fa-trash"></i></button>
                  </td>
   
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="tab_default_2">
          <div class="tab-part">
            <h4 style="color:red;">注意：自動備份資料只保留30天</h4>
            <div class="table-responsive datatable">
              <table id="data_list_2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>時間</th>  
                    <th>@lang('default-admin.action.action')</th>                         
                  </tr>
                </thead>
                <tbody>
                @foreach($autos as $auto)
                <tr>   
                  <td>{{ $auto->created_at }}</td>
                  <td>
                    <a href="{{ route('dashboard.backup.download',$auto->id) }}" target="_blank" class="btn btn-success btn-sm">下載</a>
                    <button class="btn btn-danger btn-sm delete"  data-toggle="tooltip" title="@lang('default-admin.action.delete')" data-id="{{ $auto->id }}" data-name="{{ $auto->created_at }}"><i class="fa fa-trash"></i></button>
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
  </div>


    <form id="Form">
      <!-- 額外資訊 -->
      <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">   
    </form>

</div><!-- /.box-body -->
@stop
@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<script src="{{ asset('admin/plugins/HoldOn/HoldOn.min.js') }}"></script>
<script src="{{ asset('admin/plugins/jquery-confirm/jquery.confirm.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('admin/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script>
  $(document).ready(function() {

      var token=$('input[name="_token"]').val();
      var table  = $("#data_list"); 
      var table_auto  = $("#data_list_2"); 


      $("#data_list").DataTable({
         "order": [[ 0, "desc" ]],
         "paging": true,
         "searching":true
      });
      $("#data_list_2").DataTable({
         "order": [[ 0, "desc" ]],
         "paging": true,
         "searching":true
      });


      //刪除   
      table.on("click",".delete", function(e){

        e.preventDefault();  
        var id=$(this).data('id');
        var name=$(this).data('name');
        var tr=$(this).parent().parent();

        $.confirm({
          text: "确认删除 "+name+" ?",
          confirm: function(button) {
            $.ajax({
              url:APP_URL+"/dashboard/backup/"+id,
              data:{'_token':token,'method':'DELETE'},
              type : "DELETE",
              success:function(msg){  
 
                HoldOn.close();

                var data=JSON.parse(msg);     
                if(data.result==1)
                {  

                  swal({   
                      title: "Success!",   
                      text: data.text,   
                      type: "success",    
                      confirmButtonText: "确认",   
                    }, 
                    function(){
                      window.location.reload();
                  });
                  
                }
                else
                {
                  swal("Failed", data.text,'error');
                }                           
              },
              beforeSend:function(){
                //顯示搜尋動畫
                HoldOn.open({
                    theme:'sk-cube-grid',
                    message:"<h4>系统处理中，请勿关闭视窗</h4>"
                });
              },
              error:function(xhr){
                HoldOn.close(); 
                swal("Error", "系统发生错误，请联系工程人员",'error');
              }
            }); 
          },
          cancel: function(button) {
          },
          confirmButton: "确认",
          cancelButton: "取消"
        });//.confirm
      });//.delete       

      //刪除   
      table_auto.on("click",".delete", function(e){

        e.preventDefault();  
        var id=$(this).data('id');
        var name=$(this).data('name');
        var tr=$(this).parent().parent();

        $.confirm({
          text: "确认删除 "+name+" ?",
          confirm: function(button) {
            $.ajax({
              url:APP_URL+"/dashboard/backup/"+id,
              data:{'_token':token,'method':'DELETE'},
              type : "DELETE",
              success:function(msg){  
                
                HoldOn.close();  
                var data=JSON.parse(msg);     
                if(data.result==1)
                {  

                  swal({   
                      title: "Success!",   
                      text: data.text,   
                      type: "success",    
                      confirmButtonText: "确认",   
                    }, 
                    function(){
                      window.location.reload();
                  });
                  
                }
                else
                {
                  swal("Failed", data.text,'error');
                }                           
              },
              beforeSend:function(){
                //顯示搜尋動畫
                HoldOn.open({
                    theme:'sk-cube-grid',
                    message:"<h4>系统处理中，请勿关闭视窗</h4>"
                });
              },
              error:function(xhr){
                HoldOn.close(); 
                swal("Error", "系统发生错误，请联系工程人员",'error');
              }
            }); 
          },
          cancel: function(button) {
          },
          confirmButton: "确认",
          cancelButton: "取消"
        });//.confirm
      });//.delete     

    //點擊備份按鈕
    $("#backup").click(function() {  

      $.ajax({
          url: APP_URL+"/dashboard/backup",
          data:{'_token':token},
          type : "POST",
          success:function(msg){  
            setTimeout(function(){
                HoldOn.close();
                var data=JSON.parse(msg);     
                if(data.result==1)
                {  

                  swal({   
                      title: "Success!",   
                      text: data.text,   
                      type: "success",    
                      confirmButtonText: "确认",   
                    }, 
                    function(){
                      window.location.reload();
                  });
                  
                }
                else
                {
                  swal("Failed", data.text,'error');
                }                           
            },30000); 
            
          },
          beforeSend:function(){
            //顯示搜尋動畫
            HoldOn.open({
                theme:'sk-cube-grid',
                message:"<h4>系统处理中，请勿关闭视窗</h4>"
            });
          },
          error:function(xhr){
            HoldOn.close(); 

            swal("Error", "系统发生错误，请联系工程人员",'error');
          }
        }); 
    });
       
  });
</script>
@stop