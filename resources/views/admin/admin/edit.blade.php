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
            <li class="active">編輯</li>
          </ol> 

          <!-- 上一頁 -->
          <div class="text-left"> 
            <a  onclick="javascript:history.back()"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="回上一頁"><i class="fa fa-fw fa-reply"></i></button></a>
          </div> 

          <h3 >帳號：{{ $data->username }}</h3>
        </div>

        

        <div class="box-body">
          <div class="row">
            <div class="col-sm-6">
                <div class="box-header with-border">
                  <h3>基本資訊</h3>    
                </div>
                <!-- 資訊表單 -->
    	          <form id="Form" >
                    <fieldset class="form-group">
                        <label for="status">是否給予最高管理員權限*</label>
                        <p>最高管理員權限：管理後台管理員、擁有所有功能權限</p>
                        <select class="form-control" id="type" name="type">
                            <option value="1" @if($data->type == 1) selected @endif>否</option>
                            <option value="0" @if($data->type == 0) selected @endif>是</option>
                        </select>
                    </fieldset>

                    <fieldset class="form-group">
                      <label for="name">名稱</label>
                      <input type="text" class="form-control" name="name" id="name" value="{{ $data->name }}">
                    </fieldset>

                    <!-- 額外資訊 -->
                    <input type="hidden" id="target" name="target" value="info">
                      <input type="hidden" id="_method" name="_method" value="put">
                    <input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">

                    <center><button type="submit" class="btn btn-primary ">確認</button></center>
                </form>
            </div>
            <div class="col-sm-6">
                  <div class="box-header with-border">
                    <h3>重設密碼</h3>    
                  </div>
                  <!-- 資訊表單 -->
                  <form id="Form_pass" >

                    <fieldset class="form-group">
                      <label for="content">密碼</label>
                      <input type="password" class="form-control" name="password" id="password" placeholder="">
                    </fieldset>

                    <fieldset class="form-group">
                      <label for="content">確認密碼</label>
                      <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="">
                    </fieldset>

                    <!-- 額外資訊 -->
                    <input type="hidden" id="target" name="target" value="pass">
                      <input type="hidden" id="_method" name="_method" value="put">
                     <input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">

                    <center><button type="submit" class="btn btn-primary ">確認</button></center>
                </form>
            </div>
          </div>
	       </div><!-- /.box-body -->

       
        <input type="hidden" id="id" name="id" value="{{ $data->id }}">

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

      var id= $('#id').val();
      //基本資訊表單驗證 
      $( "#Form" ).validate( {   
        ignore: [],      
        rules: {
          name: {
            required: true  
          }
        },
        messages: {
          name: "請填寫此欄位"
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

          
          sendUri = APP_URL + "/system/{{ $route_code }}/" + id;
          sendData = $('#Form').serialize();
          system_ajax(sendUri,sendData,"PUT",function(data){
              window.location.href = APP_URL+"/system/{{ $route_code }}";
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
          password: "請填寫此欄位",
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

          sendUri = APP_URL + "/system/{{ $route_code }}/" + id;
          sendData = $('#Form_pass').serialize();
          system_ajax(sendUri,sendData,"PUT",function(data){
              window.location.href = APP_URL+"/system/{{ $route_code }}";
          });

          
         
        }
      });//submit


  });
</script>
@stop