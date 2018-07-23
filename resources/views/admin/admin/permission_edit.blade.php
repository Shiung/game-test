@extends('layouts.admin')
@section('head')
    <!-- Alert -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
    <!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
@stop
@section('content-header',$page_title)
@section('content')
@inject('AdminPresenter','App\Presenters\AdminPresenter')
        <div class="box-header with-border">
          
          <ol class="breadcrumb">
            <li>管理列表</li>
            <li class="active">權限管理</li>
          </ol> 
          <!-- 上一頁 -->
          <div class="text-left">
              <a onclick="javascript:history.back()"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="回上一頁"><i class="fa fa-fw fa-reply"></i></button></a>
          </div>
          <h3 >帳號：{{ $data->name }}</h3>
        </div>

				<div class="box-body">
          <div class="row">
            <div class="col-sm-12">
                <!-- 資訊表單 -->
    	          <form id="Form" >
                  <table class="table">
                    <tbody>
                       @foreach($roles as $key =>  $role_data)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>
                              @foreach($role_data as $role)
                              <div class="checkbox">
                                <label><input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ $AdminPresenter->checkOptionChecked($role->id,$user_roles)  }}>{{ $role->display_name }}</label>
                              </div>
                              @endforeach
                            </td>
                        </tr>
                        @endforeach


                    </tbody>
                  </table>
                   
                  <!-- 額外資訊 -->
                  <input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">
                  <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                  @if(Auth::guard('admin')->user()->hasRole('master-admin') || Auth::guard('admin')->user()->hasRole('super-admin'))
                  <center><button type="submit" class="btn btn-primary ">確認</button></center>
                  @endif
                </form>
            </div>
          </div>
	       </div><!-- /.box-body -->
     
         

@stop
@section('footer-js')
<!-- Alert-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
  $(document).ready(function() {
      
      var user_role_id=$( "#Form #user_role" ).val();

      //設定會員權限
      $("#role").val(user_role_id);
    
      //基本資訊表單驗證 
      $( "#Form" ).validate( {   
        ignore: [],      
        rules: {
        },
        messages: {
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

          id= $('#id').val();
          role=$('#Form #role').val();

          $.ajax({
            url:APP_URL+"/system/admin/permission/"+id,
            data:$('#Form').serialize(),
            type : "PUT",
            success:function(msg){  
                   
              var data=JSON.parse(msg);     
              HoldOn.close();
              if(data.result==1)
              {  
                swal({   
                    title: "Success!",   
                    text: data.text,   
                    type: "success",    
                    confirmButtonText: "確認",   
                  }, 
                  function(){
                     window.location.href = APP_URL+"/system/admin";
                }); 
              }
              else
              {
                swal("Failed", data.text,'error');
              }                           
            },
            beforeSend: function() {
              //顯示搜尋動畫
              HoldOn.open({
                  theme: 'sk-cube-grid',
                  message: "<h4>系統處理中，請勿關閉視窗</h4>"
              });
            },
            error:function(xhr){
              HoldOn.close();
              swal("Error", "系統發生錯誤，請聯繫工程人員",'error');
            }
          }); 
         
        }
      });//submit

  });
</script>
@stop