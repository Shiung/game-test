@extends('layouts.main')
@section('head')
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
@stop

@section('content')
<h1>第一次帳號開通成功，請重設密碼 </h1>
<form id="Form" >
    
    <fieldset class="form-group">
        <label for="password">新密碼*</label>
        <input type="password" class="form-control" name="password" id="password" required>
    </fieldset>  
    
    <fieldset class="form-group">
        <label for="password" >確認密碼*</label>
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
    </fieldset>  

    <!-- 額外資訊 -->
    <center>
        <button type="submit" class="btn btn-primary">確認送出</button>
    </center>
     
</form>
@stop

@section('footer-js')
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>

<script>
    $(document).ready(function() {

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
                password:"請填寫新密碼",
      
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

                sendUri = APP_URL +"/verify/first-reset-pwd";
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"POST",
                    function(data){
                        window.location.href = APP_URL+'/auth/logout' ;
                    },
                    function(data){
                    }
                );

            }
        }); 


    });
</script>
@stop

