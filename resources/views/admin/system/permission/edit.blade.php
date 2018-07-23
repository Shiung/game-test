@extends('layouts.dashboard')
@section('head')
		<link rel="stylesheet" href="{{ asset('admin/plugins/lobibox/lobibox.min.css') }}" type="text/css" media="screen" />
@stop
@section('content-header','編輯權限')

@section('content')
        <div class="box-header with-border">
          <ol class="breadcrumb">
            <li>首頁</li>
            <li>權限</li>
            <li class="active">權限資料編輯</li>
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
	       </div><!-- /.box-body -->

       
        <input type="hidden" id="id" name="id" value="{{ $data->id }}">

@stop
@section('footer-js')

<!-- Alert-->
<script src="{{ asset('admin/plugins/lobibox/lobibox.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('admin/plugins/validate/jquery.validate.min.js') }}"></script>


<script>
  $(document).ready(function() {
      //取得laravel原始位址
  	  var APP_URL = {!! json_encode(url('/')) !!};
    
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

          id= $('#id').val();

          $.ajax({
            url:APP_URL+"/dashboard/admin/permissions/"+id,
            data:$('#Form').serialize(),
            type : "PUT",
            success:function(msg){  
                   
              var data=JSON.parse(msg);     
              console.log(data);  
              if(data.result==1)
              {  
                Lobibox.alert('success', {
                  msg: data.text,
                  callback: function(lobibox, type){

                     window.location.href = APP_URL+"/dashboard/admin/permissions";
                     
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

      //密碼表單驗證 
      $( "#Form_pass" ).validate( {   
        ignore: [],      
        rules: {
          password: {
            required: true  
          }, 
          password_confirm: {
            required: true,
            equalTo: "#password"  
          }
        },
        messages: {
          password: "請輸入密碼",
          password_confirm: "請確認密碼"
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

          $.ajax({
            url:APP_URL+"/dashboard/admin/users/"+id,
            data:$('#Form_pass').serialize(),
            type : "PUT",
            success:function(msg){  
                   
              var data=JSON.parse(msg);     
              //console.log(data);  
              if(data.result==1)
              {  
                Lobibox.alert('success', {
                  msg: data.text,
                  callback: function(lobibox, type){

                     window.location.href = APP_URL+"/dashboard/admin/users";
                     
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


  });
</script>
@stop