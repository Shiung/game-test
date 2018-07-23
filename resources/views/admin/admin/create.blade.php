@extends('layouts.admin')
@section('head')
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
@stop
@section('content-header',$page_title)
@section('content')
<div class="box-header with-border">
  <ol class="breadcrumb">
    <li>管理員列表</li>
    <li class="active">新增</li>
  </ol>
  <!-- 上一頁 -->
  <div class="text-left">
    <a onclick="javascript:history.back()"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="回上一頁"><i class="fa fa-fw fa-reply"></i></button></a>
  </div>
</div>
<div class="box-body">
  <form id="Form">
    <fieldset class="form-group">
        <label for="status">是否給予最高管理員權限* （最高管理員權限：管理後台管理員、擁有所有功能權限）</label>
        <p style="color:red">***建議系統最高管理員只設定一位</p>
        <select class="form-control" id="type" name="type">
            <option value="1">否</option>
            <option value="0">是</option>
        </select>
    </fieldset>
    <fieldset class="form-group">
      <label for="name">名稱</label>
      <input type="text" class="form-control" name="name" id="name" value="">
    </fieldset>
    <fieldset class="form-group">
      <label for="username">帳號</label>
      <input type="text" class="form-control" name="username" id="username" value="">
    </fieldset>
    <fieldset class="form-group">
      <label for="content">密碼</label>
      <input type="password" class="form-control" name="password" id="password" placeholder="">
    </fieldset>
    <fieldset class="form-group">
      <label for="content">確認密碼</label>
      <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="">
    </fieldset>
    
    <!-- 額外資訊 -->
    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">

    <center>
    <button type="submit" class="btn btn-primary">確認</button>
    </center>
  </form>
  </div><!-- /.box-body -->

@stop
@section('footer-js')
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script>
  $(document).ready(function() {

      //表單驗證 
      $( "#Form" ).validate( {   
        ignore: [],      
        rules: {
          name: {
            required: true  
          },  
          username: {
            required: true  
          }, 
          password: {
            required: true  
          }, 
          password_confirm: {
            required: true,
            equalTo: "#password"  
          }
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
          sendUri = APP_URL + "/system/{{ $route_code }}" ;
          sendData = $('#Form').serialize();
          system_ajax(sendUri,sendData,"POST",function(data){
              window.location.href = APP_URL+"/system/{{ $route_code }}";
          });
          
         
        }
      });//submit
  });
</script>
@stop