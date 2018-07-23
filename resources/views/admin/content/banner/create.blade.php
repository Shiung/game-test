@extends('layouts.admin') 
@section('head')

<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<!-- 打開外部視窗 fancy -->
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" >
@stop 
@section('content-header',$page_title) 
@section('content')
<div class="box-header with-border">
    <ol class="breadcrumb">
        <li>{{ $page_title }}</li>
        <li class="active">新增</li>
    </ol>
    <!-- 上一頁 -->
    <div class="text-left">
        <a href="{{ route('admin.'.$route_code.'.index') }}"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="回上一頁"><i class="fa fa-fw fa-reply"></i></button></a>
    </div>
</div>
<div class="box-body" >
    <form id="Form">
        <fieldset class="form-group">
          <label for="title">主圖*</label>
          <div class="input-group">
            <input type="text" class="form-control" name="filepath" value="" id="image" readonly required>
            <span class="input-group-btn">
               <a class="fancybox fancybox.iframe" href="{{ route('admin.file_manager.index',['image','img']) }}" ><button class="btn btn-secondary btn-info"  type="button">瀏覽</button></a>
            </span>
          </div>
        </fieldset>
        <!-- 圖片預覽 -->
        <img src="" width="100" id="img"> 

        <div class="row">
            <div class="col-md-12">
                <fieldset class="form-group">
                    <label for="name">名稱*</label>
                    <input type="text" class="form-control" name="name" id="name" value="" required>
                </fieldset>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="sort_order">順序*</label>
                    <input type="number" class="form-control" name="sort_order" id="sort_order" value="1" required>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="url">網址</label>
                    <input type="url" class="form-control" name="url" id="url"  placeholder="ex http://www.google.com">
                </fieldset>
            </div>
        </div>


        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))                
        <!-- 額外資訊 -->
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <center>
            <button type="submit" class="btn btn-primary">確認</button>
        </center>
        @endif
    </form>
</div>
<!-- /.box-body -->
@stop @section('footer-js')

<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!-- Loading -->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<!-- 打開外部視窗 fancy -->
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>


<script>
    $(document).ready(function() {
        $(".fancybox").fancybox();

        //表單驗證 
        $("#Form").validate({
            ignore: [],
            rules: {
            },
            messages: {
                name: "請填寫名稱",
                filepath: "請選擇圖片",
                sort_order:"請填寫排序",
                url:{
                    url:"請填寫正確網址格式"
                }
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");

                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element);
                } else if (element.attr("name") == "date" || element.attr("name") == "filepath") {
                    error.insertAfter(".input-group");
                } else {
                    error.insertAfter(element);
                }

            },
            submitHandler: function(form) {

                sendUri = APP_URL + "/content/{{ $route_code }}";
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"POST",function(data){
                    window.location.href = APP_URL + "/content/{{ $route_code }}";
                });
                
            }
        }); //submit
        
    });
</script>
@stop