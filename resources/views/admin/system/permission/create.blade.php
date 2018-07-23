@extends('layouts.dashboard')
@section('head')

		<!-- DataTables -->
	    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables/dataTables.bootstrap.css') }}">
	    <link rel="stylesheet" href="{{ asset('admin/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
	    <link rel="stylesheet" href="{{ asset('admin/plugins/lobibox/lobibox.min.css') }}" type="text/css" media="screen" />
@stop
@section('content-header','新增權限')

@section('content')
        <div class="box-header with-border">
          <ol class="breadcrumb">
            <li>首頁</li>
            <li>權限列表</li>
            <li class="active">新增權限</li>
          </ol> 
        </div>

				<div class="box-body">
  	        <form id="Form">
  					    <fieldset class="form-group">
  						    <label for="name">名稱（英文）</label>
  						    <input type="text" class="form-control" name="name" id="name" placeholder="ex user-edit">
  					    </fieldset>

                <fieldset class="form-group">
                  <label for="display_name">顯示名稱</label>
                  <input type="text" class="form-control" name="display_name" id="display_name" placeholder="ex 會員編輯">
                </fieldset>

                <fieldset class="form-group">
                  <label for="description">敘述</label>
                  <input type="text" class="form-control" name="description" id="description" placeholder="">
                </fieldset>

               
                <!-- 額外資訊 -->
  					    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">  
  					    <button type="submit" class="btn btn-primary">新增</button>
  					</form>
	      </div><!-- /.box-body -->

@stop
@section('footer-js')
<!-- CK Editor -->
<script type="text/javascript" src="{{ asset('admin/plugins/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/plugins/ckfinder/ckfinder.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('admin/plugins/lobibox/lobibox.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('admin/plugins/validate/jquery.validate.min.js') }}"></script>
<script>
  $(document).ready(function() {
      //取得laravel原始位址
  	  var APP_URL = {!! json_encode(url('/')) !!};

      //表單驗證 
      $( "#Form" ).validate( {   
        ignore: [],      
        rules: {
          name: {
            required: true  
          },  
          display_name: {
            required: true  
          }
        },
        messages: {
          name: "请填写此栏位",
          display_name: "请填写此栏位"
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
            url:APP_URL+"/dashboard/admin/permissions",
            data:$('#Form').serialize(),
            type : "POST",
            success:function(msg){  
                   
              var data=JSON.parse(msg);   

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
  });
</script>
@stop