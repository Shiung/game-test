@extends('layouts.admin') 
@section('head')

<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 

@stop 
@section('content-header',$page_title) 
@section('content')
<div class="box-header with-border">
    <ol class="breadcrumb">
        <li>{{ $page_title }}</li>
        <li class="active">新增轉帳</li>
    </ol>
    <!-- 上一頁 -->
    <div class="text-left">
        <a href="{{ route('admin.system.'.$route_code.'.index') }}"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="回上一頁"><i class="fa fa-fw fa-reply"></i></button></a>
    </div>
</div>
<div class="box-body" >

   
        <div class="row">
            <div class="col-md-6">
                <form id="Form_company">
                    <h3>公司轉帳</h3>
                    <p>正數：匯入金額給會員、負數：從會員帳戶取回金額</p>
                    <fieldset class="form-group">
                        <label for="username">會員帳號*</label>
                        <input type="text" class="form-control" name="username" id="username" value="" required placeholder="">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="money">轉帳金額*</label>
                        <input type="number" class="form-control" name="money" id="money" value="" required placeholder="">
                    </fieldset>
                    @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))                
                    <!-- 額外資訊 -->
                    <center>
                        <button type="submit" class="btn btn-primary">確認轉帳</button>
                    </center>
                    @endif
                </form>
            </div>
            <div class="col-md-6">
                <form id="Form_member">
                    <h3>會員轉帳</h3>

                    <fieldset class="form-group">
                        <label for="transfer">轉出會員帳號*</label>
                        <input type="text" class="form-control" name="transfer" id="transfer" value="" required placeholder="">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="money">轉帳金額*</label>
                        <input type="number" class="form-control" name="money" id="money" value="" min="0" required placeholder="">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="receive">轉入會員帳號*</label>
                        <input type="text" class="form-control" name="receive" id="receive" value="" required placeholder="">
                    </fieldset>
                    
                    @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))                
                    <!-- 額外資訊 -->
                    <center>
                        <button type="submit" class="btn btn-primary">確認轉帳</button>
                    </center>
                    @endif
                </form>
            </div>
        </div>

<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">        
</div>
<!-- /.box-body -->
@stop @section('footer-js')

<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!-- Loading -->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>

<script>
    $(document).ready(function() {

        var token = $("#_token").val();
        //公司轉帳表單驗證 
        $("#Form_company").validate({
            ignore: [],
            rules: {
            },
            messages: {
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");

                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element);
                } else if (element.attr("name") == "date") {
                    error.insertAfter(".input-group");
                } else {
                    error.insertAfter(element);
                }

            },
            submitHandler: function(form) {

                sendUri = APP_URL + "/system/{{ $route_code }}/company";
                sendData = $('#Form_company').serialize()+"&_token="+$("#_token").val();
                system_ajax(sendUri,sendData,"POST",function(data){
                    window.location.href = APP_URL + "/system/{{ $route_code }}";
                });
                
            }
        }); //submit

        //會員轉帳表單驗證 
        $("#Form_member").validate({
            ignore: [],
            rules: {
            },
            messages: {
                money:{
                    min:"請輸入正數",
                    requred:"請填寫此欄位"
                }
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");

                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element);
                } else if (element.attr("name") == "date") {
                    error.insertAfter(".input-group");
                } else {
                    error.insertAfter(element);
                }

            },
            submitHandler: function(form) {

                sendUri = APP_URL + "/system/{{ $route_code }}/member";
                sendData = $('#Form_member').serialize()+"&_token="+$("#_token").val();
                system_ajax(sendUri,sendData,"POST",function(data){
                    window.location.href = APP_URL + "/system/{{ $route_code }}";
                });
                
            }
        }); //submit
        
    });
</script>
@stop