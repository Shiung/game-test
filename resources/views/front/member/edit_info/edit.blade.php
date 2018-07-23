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

<form id="Form" method="POST" action="{{ route('front.member.info_sms') }}">
    
    <fieldset class="form-group">
        <label for="name">姓名*</label>
        <input type="text" class="form-control" name="name" maxlength="20" value="{{ $data->name }}" required>
    </fieldset>   

    <div class="row" style="display:none;">
        <div class="col-sm-4">
            <fieldset class="form-group">
                <label for="bank_code"></label>
                <input type="text" class="form-control" name="bank_code" maxlength="10" value="{{ $data->bank_code }}" >
            </fieldset>   
        </div>
        <div class="col-sm-8">
            <fieldset class="form-group">
                <label for="bank_account"></label>
                <input type="text" class="form-control" name="bank_account" maxlength="20" value="{{ $data->bank_account }}" >
            </fieldset>   
        </div>
    </div>  
 
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
                name: {required:true},
            },
            messages: {
                name: "請填寫姓名",
      
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

