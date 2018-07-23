@extends('layouts.main')
@section('head')
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">

@stop

@section('content')
<h1>{{ $page_title }}</h1>
<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">會員專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->

@if($sms_state == 1)
<form id="Form" >
    
    <div class="input-group">
        <input type="text" class="form-control" name="code" id="code" maxlength="20" required placeholder="簡訊驗證碼">
        <span class="input-group-btn">
            <button class="btn btn-secondary btn-danger" type="button" id="get_code">請按我取得簡訊驗證碼</button>
        </span>
    </div>  

    <!-- 額外資訊 -->
    <input type="hidden" id="sms_state" name="sms_state" value="{{ $sms_state }}">
    <input type="hidden" id="amount" name="amount" value="{{ $amount }}">
    <input type="hidden" id="description" name="description" value="{{ $description }}">
    <input type="hidden" id="product_id" name="product_id" value="{{ $product_id }}">
    <input type="hidden" id="receive" name="receive" value="{{ $receive }}">
    <input type="hidden" id="message" name="message" value="{{ $message }}">
    <input type="hidden" id="id" name="id" value="">
    <br>
    <center>
        <button type="submit" class="btn btn-primary">驗證</button>
    </center>
    
</form>

@else
{{ $error }}
@endif

@stop

@section('footer-js')
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('front/js/c_library.js') }}"></script>
<script>
    $(document).ready(function() {


        //取得簡訊驗證碼
        $( "#get_code" ).click(function() {
          createSms(APP_URL,$('#id'));
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
                    url: APP_URL + "/shop/use/account_transfer",
                    data: $('#Form').serialize(),
                    type: "POST",
                    success: function(msg) {
                        HoldOn.close();
                        var data = JSON.parse(msg);
 
                        if (data.result == 1) {
                            swal({
                                title: "驗證成功",
                                text: $('#message').val(),
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

