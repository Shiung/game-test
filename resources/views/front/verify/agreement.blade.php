@extends('layouts.main')
@section('head')
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
@stop

@section('content')
<h1>請詳細閱讀以下使用者規章，確認沒問題後請勾選並確認 </h1>

{!! $data->content !!}

<center>
<form id="Form" >

    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
    <input type="checkbox" id="agreement" name="agreement" value="1" required>
    <label for="remember" id="checkbox_img">
        <span class="remember-word">我同意：使用者遵守娛樂家 使用者規章 (遊戲管理規章+會員服務條款)</span>
    </label>  
    <br>
    <p style="color:red;">當您在線上勾選「我同意」，並註冊完成；或開始使用本服務時，即推定您已經詳細閱讀、了解，並同意遵守本服務條款之約定</p>
    <button type="submit" class="btn btn-success">確認</button>
     
</form>
</center>
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
                agreement: { 
                  required: "請勾選",
                },
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
                swal({
                    title: '操作確認',
                    text: '確認同意以上使用者規範?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '確認',
                    cancelButtonText: '取消'
                },function(){
                    sendUri = APP_URL +"/verify/agreement";
                    sendData = $('#Form').serialize();
                    system_ajax(sendUri,sendData,"POST",
                        function(data){
                            window.location.href = APP_URL ;
                        },
                        function(data){
                        }
                    );
                });
                

            }
        }); 


    });
</script>
@stop

