@extends('layouts.front_no_auth_blank')
@section('head')
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />

<style>
    
    html,body { 
      background: url("{{ asset('front/img/login_bg.png') }}") no-repeat center center fixed; 
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
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
            background: url("{{ asset('front/img/m_login_bg.png') }}") no-repeat center center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        
        input {                       
          font-size: 16px;
        }
        
        .login-area {
            background: url("{{ asset('front/img/m_login_area.png') }}");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            width: 70%;
            top: 38%;
            padding: 30px 20px 20px 20px;
        }
    }

    @media screen and (min-width: 768px) and (max-width: 1280px) {
        .login-area {
            background: url("{{ asset('front/img/w_login_area.png') }}");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            width: 575px;
            height: 292px;
            top: 47.75%;
            padding: 20px 75px;
        }
    }

    @media screen and (min-width: 1281px) {
        .login-area {
            background: url("{{ asset('front/img/w_login_area.png') }}");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            width: 920px;
            height: 430px;
            top: 47.75%;
            padding: 40px 125px;
        }
    }
    
    /*帳號密碼區域*/
    
    .username-area , .password-area {
        position: relative;
    }
    
    .username-area label , .password-area label {
        position: absolute;
        left: 0;
        color: #58595B;
        font-weight: normal;
    }
    
    #username, #password {
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

    #username:focus, #password:focus {
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
            margin-bottom: 20px;
        }
        
        #username, #password {
            color: #58595B;
            font-size: 14px;
            margin: 0;
            padding: 0 0 0 0;
            padding-left: 40px;
            border-radius: 0px;
        }
        
        .username-area label , .password-area label {
            font-size: 14px;
        }
        
        #username:focus, #password:focus {
            padding-left: 40px;
        }
        
        label.error, label.error, .help-block {
            font-size: 12px;
            margin-top: 0px;
        }
        
    }

    @media screen and (min-width: 768px) and (max-width: 1280px) {
        #username, #password {
            color: #58595B;
            font-size: 16px;
            margin: 0em 0 0px 0;
            padding: 0 0 0 0;
            padding-left: 50px;
            padding-bottom: 2px;
        }
        
        #username {
            margin-bottom: 15px;
        }
        
        #password {
            margin-bottom: 10px;
        }
        
        .username-area label , .password-area label {
            font-size: 16px;
        }
        
        #username:focus, #password:focus {
            outline: none;
            padding-left: 50px;
            padding-bottom: 2px;
        }
        
        #username-error , #password-error {
            height: 0;
            margin-top:0;
        }
        
        label.error, label.error, .help-block {
            font-size: 14px;
            margin-top: 0px;
        }
        
    }
    
    @media screen and (min-width: 1281px) {
        #username {
            padding-left: 80px;
            margin-bottom: 30px;
            padding-bottom: 5px;
        }
        
        #password {
            padding-left: 80px;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }
        
        .username-area label , .password-area label {
            font-size: 26px;
        }
        
        #username:focus, #password:focus {
            padding-left: 80px;
            padding-bottom: 5px;
        }
        
        label.error, label.error, .help-block {
            font-size: 18px;
            margin-top: 5px;
        }
        
        #username-error , #password-error {
            height: 0;
            margin-top:0;
        }
        
    }
    
    /*記住我checkbox框*/
  
    .remember-area {
        position: relative;
        margin: 10px 0px;
    }
    
    .agreement-area {
        position: absolute;
        width: 65%;
        top: 0;
        left: 40%;
    }
    
    #checkbox_img:before {
        content: url("{{ asset('front/img/login/p00_login_icon_02.png') }}");
        position: absolute;
        z-index: 100;
    }
    :checked+#checkbox_img:before {
        content: url("{{ asset('front/img/login/p00_login_icon_01.png') }}");
    }
    
    #agreementbox_img:before {
        content: url("{{ asset('front/img/login/p00_login_icon_02.png') }}");
        position: absolute;
        z-index: 100;
    }
    :checked+#agreementbox_img:before {
        content: url("{{ asset('front/img/login/p00_login_icon_01.png') }}");
    }
    
    input[type=checkbox] {
        display: none;
    }
    .remember-word {
        padding-left: 40px;
        color: #58595B;
        font-size: 26px;
        font-weight: normal;
    }
    
    #captcha_text {
        color: #58595B;
        font-size: 26px;
        font-weight: normal;
    }
    .captcha-input {
        background: #E1E2E3;
        border: none;
        border-radius: 0;
        color: #58595B;
        font-size: 26px;
        font-weight: 400;
        letter-spacing: 1px;
        margin: 0;
        padding: 0 20px;
        height: 56px;
        line-height: 56px;
        width: 257px;
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
    .captcha-img {
        margin: 0;
        height: 56px;
        margin-top: -10px;
        margin-left: 15px;
    }
    .captcha-refresh-img {
        margin: 0;
        height: 56px;
        margin-top: -10px;
        margin-left: 15px;
        cursor: pointer;
    }
    
    @media screen and (max-width: 767px) {
        
        .remember-area {
            margin: 12px 0px 0px 0px;
        }

        #checkbox_img:before {
            background-image: url("{{ asset('front/img/login/p00_login_icon_02.png') }}");
            background-size: 20px 20px;
            display: inline-block;
            width: 20px; 
            height: 20px;
            content:"";
        }
        
        :checked+#checkbox_img:before {
            background-image: url("{{ asset('front/img/login/p00_login_icon_01.png') }}");
            background-size: 20px 20px;
            display: inline-block;
            width: 20px; 
            height: 20px;
            content:"";
        }
        
        #agreementbox_img:before {
            background-image: url("{{ asset('front/img/login/p00_login_icon_02.png') }}");
            background-size: 20px 20px;
            display: inline-block;
            width: 20px; 
            height: 20px;
            content:"";
        }
        
        :checked+#agreementbox_img:before {
            background-image: url("{{ asset('front/img/login/p00_login_icon_01.png') }}");
            background-size: 20px 20px;
            display: inline-block;
            width: 20px; 
            height: 20px;
            content:"";
        }

        .remember-word {
            padding-left: 25px;
            font-size: 14px;
            height: 18px;
            line-height: 18px;
            padding-bottom: 2px;
        }
        
        .captcha-area {
            margin-top: 0px;
            height: 120px;
        }
        
        #captcha_text {
            font-size: 14px;
            margin-bottom: -5px;
        }
        
        .captcha-input {
            font-size: 16px;
            padding: 0 12px;
            height: 33px;
            line-height: 33px;
            width: 100%;
        }
        
        .captcha-img {
            width: 56%;
            height: 30px;
            margin-top: 10px;
            margin-left: 0px;
        }
        
        .captcha-refresh-img {
            width: 37%;
            height: auto;
            margin-top: 10px;
            margin-left: 4%;
        }   
    }

    @media screen and (min-width: 768px) and (max-width: 1280px) {
        .remember-area {
            margin: 10px 0px 0px 0px;
        }

        #checkbox_img:before {
            background-image: url("{{ asset('front/img/login/p00_login_icon_02.png') }}");
            background-size: 20px 20px;
            display: inline-block;
            width: 20px; 
            height: 20px;
            content:"";
        }
        
        :checked+#checkbox_img:before {
            background-image: url("{{ asset('front/img/login/p00_login_icon_01.png') }}");
            background-size: 20px 20px;
            display: inline-block;
            width: 20px; 
            height: 20px;
            content:"";
        }
        
        #agreementbox_img:before {
            background-image: url("{{ asset('front/img/login/p00_login_icon_02.png') }}");
            background-size: 20px 20px;
            display: inline-block;
            width: 20px; 
            height: 20px;
            content:"";
        }
        
        :checked+#agreementbox_img:before {
            background-image: url("{{ asset('front/img/login/p00_login_icon_01.png') }}");
            background-size: 20px 20px;
            display: inline-block;
            width: 20px; 
            height: 20px;
            content:"";
        }

        .remember-word {
            padding-left: 25px;
            font-size: 16px;
            line-height: 20px;
        }

        .captcha-area {
            margin-top: 0px;
            height: 90px;
        }
        
        #captcha_text {
            font-size: 16px;
            margin-bottom: 0px;
        }
        .captcha-input {
            font-size: 16px;
            padding: 0 12px;
            height: 35px;
            line-height: 35px;
            width: 160px;
        }
        .captcha-img {
            height: 35px;
            margin-top: -4px;
            margin-left: 10px;
        }
        .captcha-refresh-img {
            height: 35px;
            margin-top: -4px;
            margin-left: 10px;
        } 
    }
    
    @media screen and (min-width: 1281px) {
        .captcha-area {
            margin-top: 0px;
            height: 110px;
        }
    }
    
    /*按鈕區域*/
    .btn-area {
        margin-top: 20px;
        position: relative;
    }
    
    .login-btn {
        width: 478px;
        height: 56px;
        line-height: 56px;
        background-color: #58595B;
        color: white;
        font-size: 26px;
        text-align: center;
        border-radius: 5px;
        letter-spacing: 20px;
        padding-left: 20px;
        border: 0;
    }
    
    .login-btn:hover {
        background-color: #E90B27;
    }
    
    .forget-pass {
        position: absolute;
        color: #58595B;
        font-size: 24px;
        text-decoration: underline;
        bottom: 0px;
        margin-left: 20px;
    }
    
    .forget-pass:hover {
        color: #E4002B;
        
    }
    
    @media screen and (max-width: 767px) {
        .btn-area {
            width: 100%;
            margin-top: 5px;
            position: relative;
            text-align: center;
        }

        .login-btn {
            width: 100%;
            height: 28px;
            line-height: 28px;
            font-size: 14px;
            border-radius: 5px;
            margin-bottom: 3px;
            letter-spacing: 10px;
            padding-left: 20px;
        }

        .forget-pass {
            position: relative;
            width: 100%;
            font-size: 14px;
            padding-right: 20px;
        }

        .forget-pass:hover {
            color: #E4002B;
        }   
            
    }
    
    @media screen and (min-width: 768px) and (max-width: 1280px) {
        .btn-area {
            margin-top: 0px;
            position: relative;
        }

        .login-btn {
            width: 290px;
            height: 35px;
            line-height: 35px;
            font-size: 16px;
            border-radius: 8px;
        }

        .forget-pass {
            font-size: 16px;
        }

        .forget-pass:hover {
            color: #E4002B;
        }    
    }
    
</style>
@stop 

@section('content')
<div class="login-area">
    <form id="Form" >
        <div class="username-area">
            <label for="username">帳號</label>
            <input type="text" placeholder="" name="username" id="username" required>
        </div>

        <div class="password-area">
            <label for="password" >密碼</label>
            <input type="password" placeholder="" name="password" id="password" required>
        </div>  
        
        <div class="remember-area">
            <input type="checkbox" id="remember" name="remember" value="1">
            <label for="remember" id="checkbox_img">
                <span class="remember-word">記住我</span>
            </label>
            <div class="agreement-area">
                <input type="checkbox" id="agreement" name="agreement" value="1" checked>
                <label for="agreement" id="agreementbox_img">
                    <span class="remember-word">我同意<a href="{{ route('front.login.agreement') }}" class="fancybox fancybox.iframe">使用者規範</a></span>
                </label>    
            </div>    
        </div>

        
        
        
        <div class="captcha-area">
            <label id="captcha_text" for="captcha">驗證碼</label>
            <div style="margin-top:5px;">
                <input type="text" class="captcha-input" name="captcha" id="captcha" required>
                <img src="{{ captcha_src() }}" alt="captcha" class="captcha-img" data-refresh-config="default">
                <a id="refresh_captcha"><img id="refresh" src="{{ asset('front/img/login/p00_login_icon_03_01.png') }}" class="captcha-refresh-img" onmouseover="refresh_hover(this);" onmouseout="refresh_unhover(this);"></a>
            </div>
        </div>  

        <div class="btn-area">
            <button type="submit" class="login-btn">登入</button>

            <a href="{{ route('front.forget-password.index') }}" class="forget-pass">忘記密碼</a>
        </div>
    </form>
</div>


@stop
@section('footer-js')
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script src="{{ asset('front/js/captcha.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>

<script>
    $(document).ready(function() {
        $(".fancybox").fancybox();  
        $("#Form").validate({
            ignore: [],
            rules: {},
            messages: {
                username: "",
                password: "",
                captcha: "驗證碼輸入錯誤，請重新輸入"
            },
            errorElement: "em",
            errorPlacement: function(e, a) {
                e.addClass("help-block"), a.prop("type"), e.insertAfter(a.parent())
            },
            submitHandler: function(e) {
                if (!$('[name="agreement"]').is(':checked')) {
                   swal("Error", "請勾選同意使用者規範", 'error');
                   return false;
                };
                
                sendUri = APP_URL + "/auth/login", sendData = $("#Form").serialize(), system_ajax_no_alert(sendUri, sendData, "POST", function(e) {
                    window.location.href = APP_URL
                }, function(e) {
                    var a = $("img.captcha-img");
                    a.data("refresh-config"), refreshCaptcha(a, a.data("refresh-config"), $("#captcha"))
                })
            }
        });
        $("#refresh_captcha").click(function(){var a=$("img.captcha-img");a.data("refresh-config");refreshCaptcha(a,a.data("refresh-config"),$("#captcha"))});
    });
</script>

<script>
    function refresh_hover(element) {
        element.setAttribute('src', "{{ asset('front/img/login/p00_login_icon_03_02.png') }}");
    }
    function refresh_unhover(element) {
        element.setAttribute('src', "{{ asset('front/img/login/p00_login_icon_03_01.png') }}");
    }
</script>
@stop
