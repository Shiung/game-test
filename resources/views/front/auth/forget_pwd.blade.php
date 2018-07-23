@extends('layouts.front_no_auth_blank')
@section('head')
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 

<style>
    
    html,body { 
        background: url("{{ asset('front/img/login/w_p00_login_03.png') }}") no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        color: #58595B;
    }
    
    .login-area {
        position: absolute;
        right:0;
        left:0;
        margin:auto;
    }
    
    @media screen and (max-width: 767px) {
        html , body { 
            height: 100%;
            background: url("{{ asset('front/img/login/m_p00_login_03.png') }}") no-repeat center center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
                
        input {                       
          font-size: 16px;
        }
        
        .login-area {
            background: url("{{ asset('front/img/login/m_p00_login_04.png') }}");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            width: 70%;
            height: 75%;
            top: 17%;
            padding: 28% 20px 20px 20px;
        }
        
        .title {
            letter-spacing: 5px;
            padding-left: 5px;
        }
        
        .subtitle {
            font-size: 14px;
            line-height: 150%;
        }
    }
    
    @media screen and (min-width: 768px) and (max-width: 1280px) {
        .login-area {
            background: url("{{ asset('front/img/login/w_p00_login_04.png') }}");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            width: 575px;
            height: 400px;
            top: 30%;
            padding: 100px 100px 20px 100px;
        }
        
        .title {
            font-size: 36px;
            font-weight: 600;
            letter-spacing: 5px;
            padding-left: 5px;
        }
        
        .subtitle {
            font-size: 18px;
            line-height: 150%;
        }
    }

    @media screen and (min-width: 1281px) {
        .login-area {
            background: url("{{ asset('front/img/login/w_p00_login_04.png') }}");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            width: 920px;
            height: 650px;
            top: 24%;
            padding: 180px 150px 20px 150px;
        }
        
        .title {
            font-size: 48px;
            font-weight: 600;
            letter-spacing: 5px;
            padding-left: 5px;
        }
        
        .subtitle {
            font-size: 26px;
            line-height: 150%;
        }
    }
    
        
    /*INPUT區域*/
    
    .username-area , .phone-area {
        position: relative;
    }
    
    .username-area label , .phone-area label {
        position: absolute;
        left: 0;
        color: #58595B;
    }
    
    #username, #phone {
        background: none;
        border: none;
        border-bottom: solid 1px #58595B;
        color: #58595B;
        font-size: 26px;
        font-weight: 400;
        letter-spacing: 1px;
        margin: 0em 0 10px 0;
        padding: 0 0 0 0;
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        -ms-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
    }

    #username:focus, #phone:focus {
        outline: none;
        padding: 0 0 0 0;
    }
    
    ::-webkit-input-placeholder {
        color: #58595B;
    }

    :-moz-placeholder { 
        color: #58595B;
        opacity: 1;
    }

    ::-moz-placeholder {
        color: #58595B;
        opacity: 1;
    }

    :-ms-input-placeholder {
        color: #58595B;
    }
    
    @media screen and (max-width: 767px) {
        
        .username-area  {
            margin-bottom: 10%;
            margin-top:18%;
        }
        
        #username, #phone {
            color: #58595B;
            font-size: 16px;
            margin: 0;
            padding: 0 0 0 0;
            padding-left: 70px;
            border-radius: 0px;
        }
        
        .username-area label , .phone-area label {
            font-size: 16px;
        }
        
        #username:focus, #phone:focus {
            padding-left: 70px;
        }
        
    }

    @media screen and (min-width: 768px) and (max-width: 1280px) {
        
        .username-area  {
            margin-top: 5%;
        }
        
        #username, #phone {
            color: #58595B;
            font-size: 16px;
            margin: 0em 0 0px 0;
            padding: 0 0 0 0;
            padding-left: 90px;
            padding-bottom: 2px;
        }
        
        #username {
            margin-bottom: 15px;
        }
        
        #phone {
            margin-bottom: 10px;
        }
        
        .username-area label , .phone-area label {
            font-size: 16px;
        }
        
        #username:focus, #phone:focus {
            outline: none;
            padding-left: 90px;
            padding-bottom: 2px;
        }
        
        #username-error , #phone-error {
            height: 0;
            margin-top:0;
        }
        
    }
    
    @media screen and (min-width: 1281px) {
        
        .username-area  {
            margin-top: 10%;
        }
        
        #username {
            padding-left: 150px;
            margin-bottom: 30px;
            padding-bottom: 5px;
            letter-spacing: 3px;
        }
        
        #phone {
            padding-left: 150px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            letter-spacing: 3px;
        }
        
        .username-area label , .phone-area label {
            font-size: 26px;
        }
        
        #username:focus, #phone:focus {
            padding-left: 150px;
            padding-bottom: 5px;
        }
        
        label.error, label.error, .help-block {
            font-size: 26px;
            margin-top:10px;
        }
        
        #username-error , #phone-error {
            height: 0;
            margin-top:0;
        }
        
    }
    
    /*按鈕區域*/
    
    .btn-area {
        margin-top: 30px;
        position: relative;
    }
    
    .login-btn {
        width: 80%;
        height: 50px;
        line-height: 50px;
        background-color: #58595B;
        color: white;
        font-size: 24px;
        text-align: center;
        border-radius: 5px;
        letter-spacing: 20px;
        padding-left: 20px;
        border: 0;
    }
    
    .login-btn:hover {
        background-color: #E90B27;
    }
    
    @media screen and (max-width: 767px) {
        .btn-area {
            width: 100%;
            margin-top: 18%;
            position: relative;
            text-align: center;
        }

        .login-btn {
            width: 100%;
            height: 28px;
            line-height: 28px;
            font-size: 16px;
            border-radius: 5px;
            margin-bottom: 3px;
            letter-spacing: 10px;
            padding-left: 20px;
        }
            
    }
    
    @media screen and (min-width: 768px) and (max-width: 1280px) {
        
        .btn-area {
            margin-top: 10px;
            position: relative;
        }

        .login-btn {
            width: 290px;
            height: 35px;
            line-height: 35px;
            font-size: 16px;
            border-radius: 10px;
        }
 
    }
    
</style>

@stop 
@section('content')

<div class="login-area">
    <center><h1 class="title">忘記密碼</h1></center>
    <center>
        <p class="subtitle hidden-sm hidden-md hidden-lg">確認送出後，您將收到<br>新密碼簡訊，請用<br>新密碼登入並盡快重設密碼。</p>
        <p class="subtitle hidden-xs">確認送出後，您將收到新密碼簡訊，請用<br>新密碼登入並盡快重設密碼。</p>
    </center>
    
    <form id="Form" >  
       
        <div class="username-area">
            <label for="username">帳號</label>
            <input type="text" placeholder="" name="username" id="username" required>
        </div>

        <div class="phone-area">
            <label for="phone" >手機號碼</label>
            <input type="text" placeholder="" name="phone" id="phone" required>
        </div>  

    <center>
        <div class="btn-area">
            <button type="submit" class="login-btn">送出</button>
        </div>
    </center>  
</form>
</div>
<!--
<center>



<h1>忘記密碼 </h1>
<p>確認送出後，您將收到新密碼簡訊，請用新密碼登入並盡快重設密碼。</p>
</center>
<form id="Form" >  
    <fieldset class="form-group">
        <label for="username">帳號*</label>
        <input type="text" class="form-control" name="username" id="username" required>
    </fieldset>  
    
    <fieldset class="form-group">
        <label for="phone" >手機號碼*</label>
        <input type="text" class="form-control" name="phone" id="phone" required>
    </fieldset>  
    <center>
        <button type="submit" class="btn btn-primary">確認送出</button>
    </center>  
</form>
-->
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
            },
            messages: {
                username: "請填寫帳號",
                phone:"請填寫手機號碼",
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
                sendUri =  APP_URL + "/auth/forget-password";
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"POST",
                    function(data){
                        window.location.href = APP_URL+'/auth/login' ;
                    },
                    function(data){
                    }
                );
            }
        }); 
    });
</script>
@stop
