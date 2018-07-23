@extends('layouts.main')
@section('head')

@stop

@section('content')

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">會員專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->

<h1>{{ $page_title }}</h1>

<form id="Form" method="POST" action="{{ route('front.member.pwd_sms') }}">
    
    <fieldset class="form-group">
        <label for="password">新密碼*</label>
        <input type="password" class="form-control" name="password" id="password" required>
    </fieldset>   

     <fieldset class="form-group">
        <label for="password_confirmation">確認新密碼*</label>
        <input type="password" class="form-control" name="password_confirmation"  required>
    </fieldset>  
 
    <!-- 額外資訊 -->
    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="_method" name="_method" value="POST">
    <center>
        <button type="submit" class="btn btn-primary">確認</button>
    </center>
    
</form>

@stop

@section('footer-js')
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>

<script>
    $(document).ready(function() {

        //送出表單
        $("#Form").validate({
            ignore: [],
            rules: {
                password:{ 
                  required: true,
                  minlength:6
                },
                password_confirmation: {
                  equalTo: "#password"
                }
            },
            messages: {
                password: { 
                  required: "請輸入新密碼",
                  minlength:"請輸入最少六碼"
                },
                password_confirmation: "請再次確認新密碼",
      
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");

                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element);
                } else {
                    error.insertAfter(element);
                }

            },
            submitHandler: function(form) {
                return true;
            }
        }); //送出表單

    });
</script>
@stop

