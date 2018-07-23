@extends('layouts.main')
@section('head')
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
@stop

@section('content')
<h1>身份驗證-Step.1</h1>
<form id="Form" method="POST" action="{{ route('front.verify.sms') }}">
    
    <fieldset class="form-group">
        <label for="phone">手機號碼* (中國區需在號碼前加+86 ，如+861350168168)</label>
        <input type="text" class="form-control" name="phone" maxlength="20" placeholder="請輸入手機號碼，以取得簡訊驗證碼">
    </fieldset>   

    <!-- 額外資訊 -->
    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="_method" name="_method" value="POST">
    <input type="hidden" id="token" name="token" value="">
    <center>
        <button type="submit" class="btn btn-primary">下一步</button>
    </center>
    
</form>
@stop

@section('footer-js')
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script>
    $(document).ready(function() {

        //送出表單
        $("#Form").validate({
            ignore: [],
            rules: {
                phone: {required:true},
            },
            messages: {
                phone: "請填寫手機號碼",
      
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
                
                //檢查手機號碼是否能使用
                 $.ajax({
                    url: APP_URL + "/verify/phone-check",
                    data: $('#Form').serialize(),
                    type: "POST",
                    success: function(msg) {
                        HoldOn.close();
                        var data = JSON.parse(msg);
                        if (data.result == 1) {
                            form.submit();
                        } else {
                            swal("Failed", data.text, 'error');
                            return false;
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

