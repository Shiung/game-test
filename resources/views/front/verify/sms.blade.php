@extends('layouts.main')
@section('head')
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">

@stop

@section('content')
<h1>身份驗證-Step.2 </h1>
<form id="Form" method="post" action="{{ route('front.verify.sms') }}">
    
    <div class="input-group">
        <input type="text" class="form-control" name="code" id="code" maxlength="20" required placeholder="簡訊驗證碼">
        <span class="input-group-btn">
            <button class="btn btn-secondary btn-danger" type="button" id="get_code">請按我取得簡訊驗證碼</button>
        </span>
    </div>   

    <!-- 額外資訊 -->
    <input type="hidden" id="phone" name="phone" value="{{ $phone }}">
    <input type="hidden" id="id" name="id" value="">
    <br>
    <center>
        <button type="submit" class="btn btn-primary">驗證</button>
    </center>
    
</form>
@stop

@section('footer-js')
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script src="{{ asset('front/js/c_library.js') }}"></script>
<script>
    $(document).ready(function() {

        var phone = $('#phone').val();

        //取得簡訊驗證碼
        $( "#get_code" ).click(function() {
          createSms(APP_URL,$('#id'),phone);
        });
        //送出表單
        $("#Form").validate({
            ignore: [],
            rules: {
            },
            messages: {
                code: "請填寫簡訊驗證碼",
      
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
                $.ajax({
                    url: APP_URL + "/verify/sms-auth",
                    data: $('#Form').serialize(),
                    type: "POST",
                    success: function(msg) {

                        var data = JSON.parse(msg);
                        HoldOn.close();
                        if (data.result == 1) {
                            swal({
                                title: "驗證成功",
                                text: "您可以開始使用本系統！",
                                type: "success",
                                confirmButtonText: "OK",
                            },
                            function() {
                                window.location.href = APP_URL ;
                            });
                        } else {
                            if(data.error == 'ERROR_CODE'){
                                swal("驗證失敗", data.text+'  請重新輸入', 'error');
                            } else if(data.error == 'EXPIRE_CODE') {
                                swal("驗證失敗", data.text+'  簡訊已重新寄出，請重新輸入', 'error');

                            } else if(data.error == 'ERROR_ID') {
                                swal("驗證失敗", data.text+'  簡訊已重新寄出，請重新輸入', 'error');
                            } else {
                                swal("Failed", '系統發生問題，請聯繫網站人員', 'error');
                            }
                            
                            $('#id').val(data.id);
                        }
                    },
                    beforeSend: function() {
                        HoldOn.open({
                            theme: 'sk-cube-grid',
                            message: "<h4>系統處理中，請勿關閉視窗</h4>"
                        });
                    },
                    error: function(xhr) {
                        HoldOn.close();
                        swal("Failed", '系統發生問題，請聯繫網站人員', 'error');
                    }
                });
            }
        }); //送出表單
    });
</script>
@stop

