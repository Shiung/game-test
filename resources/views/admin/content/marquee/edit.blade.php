@extends('layouts.admin') @section('head')

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
        <li class="active">瀏覽編輯</li>
    </ol>
    <!-- 上一頁 -->
    <div class="text-left">
        <a href="{{ route('admin.'.$route_code.'.index') }}"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="回上一頁"><i class="fa fa-fw fa-reply"></i></button></a>
    </div>
</div>
<div class="box-body" >
    <form id="Form">
        <div class="row">
            <div class="col-md-12">
                <fieldset class="form-group">
                    <label for="content">跑馬燈內容*</label>
                    <input type="text" class="form-control" name="content" id="content" value="{{ $data->content }}" required placeholder="限制225個字元">
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="sort_order">順序*</label>
                    <input type="number" class="form-control" name="sort_order" id="sort_order" value="{{ $data->sort_order }}" required>
                </fieldset>
            </div>
        </div>


        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))               
        <!-- 額外資訊 -->
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="id" name="id" value="{{ $data->id }}">
        <input type="hidden" id="_method" name="_method" value="put">
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

<script>
    $(document).ready(function() {

        var id = $('#id').val();

        //表單驗證 
        $("#Form").validate({
            ignore: [],
            rules: {
            },
            messages: {
                content: "請填寫跑馬燈內容",
                sort_order: "請填寫順序"
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
                
                sendUri = APP_URL + "/content/{{ $route_code }}/" + id;
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"PUT",function(data){
                    window.location.href = APP_URL + "/content/{{ $route_code }}";
                });


            }
        }); //submit
    });
</script>
@stop