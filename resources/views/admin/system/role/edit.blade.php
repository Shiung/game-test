@extends('layouts.dashboard')
@section('head')
		<link rel="stylesheet" href="{{ asset('admin/plugins/lobibox/lobibox.min.css') }}" type="text/css" media="screen" />
@stop
@section('content-header','編輯會員身份')

@section('content')
        <div class="box-header with-border">
          <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">首頁</a></li>
            <li><a href="{{ route('dashboard.role.index') }}">會員身份</a></li>
            <li class="active">會員身份資料編輯</li>
          </ol> 
        </div>

				<div class="box-body">
          <div class="box">
            <div class="box-header with-border">
              <h3>基本資訊</h3>    
            </div>
            <!-- 資訊表單 -->
	          <form id="Form" >
                <fieldset class="form-group">
                  <label for="name">名稱（英文）</label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ $data->name }}">
                </fieldset>

                <fieldset class="form-group">
                  <label for="display_name">顯示名稱</label>
                  <input type="text" class="form-control" name="display_name" id="display_name" value="{{ $data->display_name }}">
                </fieldset>

                <fieldset class="form-group">
                  <label for="description">敘述</label>
                  <input type="text" class="form-control" name="description" id="description" value="{{ $data->description }}">
                </fieldset>

                <!-- 額外資訊 -->
                <input type="hidden" id="target" name="target" value="info">
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">

                <center><button type="submit" class="btn btn-primary btn-lg">確認</button></center>
            </form>
          </div>

          <div class="box">
            <div class="box-header with-border">
              <h3>擁有權限</h3>    
            </div> 
            <div class="text-right"> 
                 <button  class="btn btn-primary btn-sm"  type="button" id="change_status"  data-toggle="modal" data-target="#myModal" ><i class="fa fa-plus"></i></button> 
            </div>
            <br>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                  <tr>
                    <th>名稱</th>
                    <th>敘述</th>
                    <th>操作</th>                   
                  </tr>
              </thead>
              <tbody>
              @foreach($role_permissions as $role_permission)
              <tr>
                  <td>{{ $role_permission->name }}</td>
                  <td>{{ $role_permission->display_name }}</td>
                  <td>     
                      <button class="btn btn-danger btn-sm delete"  data-toggle="tooltip" title="刪除" data-id="{{ $role_permission->id }}" data-name="{{ $role_permission->display_name }}" ><i class="fa fa-trash"></i></button>                                       
                  </td>  
              </tr>
              @endforeach
              </tbody>
            </table>  
  
          </div>
	       </div><!-- /.box-body -->

        <!-- Modal 新增狀態框框 -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">新增權限</h4>
              </div>
              <div class="modal-body">
                 <label class="control-label" for="permission">權限</label>
                  <select name="permission" id="permission" class="form-control">
                      <option value="0" selected="selected">請選擇</option>
                      @foreach($all_permissions as $all_permission)
                      <option value="{{ $all_permission->id }}" >{{ $all_permission->display_name }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" id="save" class="btn btn-primary">確認</button>
              </div>
            </div>
          </div>
        </div><!-- /.Modal -->

       
        <input type="hidden" id="id" name="id" value="{{ $data->id }}">

@stop
@section('footer-js')

<!-- Alert-->
<script src="{{ asset('admin/plugins/lobibox/lobibox.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('admin/plugins/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/plugins/jquery-confirm/jquery.confirm.min.js') }}"></script>


<script>
  $(document).ready(function() {
      //取得laravel原始位址
  	  var APP_URL = {!! json_encode(url('/')) !!};
      var permission_id;
      var role_id= $('#id').val();
      var token=$('#_token').val();
    
      //基本資訊表單驗證 
      $( "#Form" ).validate( {   
        ignore: [],      
        rules: {
          name: {
            required: true  
          }
        },
        messages: {
          name: "請輸入名稱"
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
          error.addClass( "help-block" );

          if ( element.prop( "type" ) === "checkbox" ) {
            error.insertAfter( element );
          }
          else if (element.attr("name") == "date") 
          {
            error.insertAfter(".input-group");
          }
          else 
          {
            error.insertAfter( element );
          }

        },
        submitHandler: function(form) {


          $.ajax({
            url:APP_URL+"/dashboard/roles/"+role_id,
            data:$('#Form').serialize(),
            type : "PUT",
            success:function(msg){  
                   
              var data=JSON.parse(msg);     

              if(data.result==1)
              {  
                Lobibox.alert('success', {
                  msg: data.text,
                  callback: function(lobibox, type){

                     window.location.href = APP_URL+"/dashboard/roles";
                     
                  }
                }); 
              }
              else
              {
                Lobibox.alert('error', {
                  msg: data.text
                });
              }                           
            },
            error:function(xhr){
              Lobibox.alert('error', {
                msg: 'Ajax request 發生錯誤',
              });
            }
          }); 
         
        }
      });//submit
      
      //刪除權限
      var table  = $("#example1"); 
      table.on("click",".delete", function(e){
        e.preventDefault();  
        var id=$(this).data('id');
        var name=$(this).data('name');
        var tr=$(this).parent().parent();

        $.confirm({
          text: "確認刪除權限- 「"+name+"」 ?",
          confirm: function(button) {
            $.ajax({
              url:"/laravel/public/dashboard/admin/roles/"+role_id+"/permissions/"+id,
              data:{'_token':token,'method':'DELETE'},
              type : "DELETE",
              success:function(msg){  
                     
                var data=JSON.parse(msg);     
                if(data.result==1)
                {  
                  Lobibox.alert('success', {
                    msg: data.text,
                    callback: function(lobibox, type){

                      window.location.reload();
                       
                    }
                  }); 
                }
                else
                {
                  Lobibox.alert('error', {
                    msg: data.text
                  });
                }                           
              },
              error:function(xhr){
                Lobibox.alert('error', {
                  msg: 'Ajax request 發生錯誤',
                });
              }
            }); 
          },
          cancel: function(button) {
          },
          confirmButton: "確認",
          cancelButton: "取消"
        });//.confirm
      });//.delete  

    //確認新增權限
    $("#save").click(function(){
      permission_id=$("#permission").val();

      $.ajax({
          url:"/laravel/public/dashboard/admin/roles/"+role_id+"/permissions/"+permission_id,
          data:{'_token':token,'method':'POST'},
          type : "POST",
          success:function(msg){  
                 
            var data=JSON.parse(msg);  
            console.log(msg);   
            if(data.result==1)
            {  
              Lobibox.alert('success', {
                msg: data.text,
                callback: function(lobibox, type){

                  window.location.reload();
                   
                }
              }); 
            }
            else
            {
              Lobibox.alert('error', {
                msg: data.text
              });
            }                           
          },
          error:function(xhr){
            Lobibox.alert('error', {
              msg: 'Ajax request 發生錯誤',
            });
          }
        }); 
    });
     



  });
</script>
@stop