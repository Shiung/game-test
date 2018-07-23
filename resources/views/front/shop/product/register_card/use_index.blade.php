@extends('layouts.main')
@section('head')
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">

@stop

@section('content')
<h1>使用商品</h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">我的商品</li>
    <li class="breadcrumb-item active">使用商品</li>
</ol>
<!--/.路徑-->


<h4>商品資訊</h4>
<ul class="list-group">  
    <li class="list-group-item"><b>名稱： </b>{{ $product->name }}</li>
    <li class="list-group-item"><b>功能： </b>{{ $product->description }}</li>
    <li class="list-group-item"><b>紅利： </b>{{ $info->interest*100 }}%</li>
    <li class="list-group-item"><b>使用者回饋金： </b>{{ number_format($info->member_feedback) }}</li>
    <li class="list-group-item"><b>推薦者回饋金： </b>{{ number_format($info->recommender_feedback) }}</li>
    <li class="list-group-item"><b>卡片有效天數：</b>{{ $info->period or '無限期' }}</li>
    <li class="list-group-item"><b>回饋金領取有效天數： </b>{{ $info->feedback_period or '無限期' }}</li>
</ul>

<form id="Form">
    
    <h3>好友基本資訊</h3>

    <div class="row">
        <div class="col-sm-3">
            <fieldset class="form-group">
                <label for="name">姓名*</label>
                <input type="text" class="form-control" name="name" >
            </fieldset>  
        </div>
        <div class="col-sm-3">
            <fieldset class="form-group">
                <label for="username">帳號*</label>
                <input type="text" class="form-control" name="username" maxlength="10" minlength="6" required placeholder="請輸入6~10個字元" required>
            </fieldset>   
        </div>
        <div class="col-sm-3">
            <fieldset class="form-group">
                <label for="password">密碼*</label>
                <input type="password" class="form-control" name="password" id="password" minlength="6" required>
            </fieldset>   
        </div>
        <div class="col-sm-3">
            <fieldset class="form-group">
                <label for="password_confirmation">確認密碼*</label>
                <input type="password" class="form-control" name="password_confirmation" minlength="6"  required>
            </fieldset>   
        </div>
        
    </div>

    <h3>社群資訊</h3>
    <div class="row">
        <div class="col-sm-3">
            <fieldset class="form-group">
                <label for="parent_username">社群好友或自己*</label>
                <input type="text" class="form-control" name="parent_username" maxlength="50" required >
            </fieldset>    
        </div>
        <div class="col-sm-3">
            <fieldset class="form-group">
                <label for="position">社群位置*</label>
                <select class="form-control" name="position" id="position">
                    @for ($i = 1; $i <= $position_count; $i++)
                    <option value="{{ $i }}">位置「{{ $i }}」</option>
                    @endfor
                </select>
            </fieldset> 
        </div>
        
    </div>
    
    <!-- 額外資訊 -->
    <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
    <center>
        <button type="submit" class="btn btn-primary">確認</button>
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

<script>
    $(document).ready(function() {
 
        //送出表單
        $("#Form").validate({
            ignore: [],
            rules: {
                username: {
                    required:true,
                    noSpace: true
                },
                parent_username: {
                    required:true,
                    noSpace: true
                },
                password: {
                    required:true,
                    noSpace: true
                },
                password_confirmation: {
                    required:true,
                    equalTo:"#password",
                    noSpace: true
                }
            },
            messages: {
                name: "請填寫姓名",
                username: {
                    required:"請填寫帳號",minlength:"帳號請輸入6-10個字元",maxlength:"帳號請輸入6-10個字元"
                },
                parent_username: {required:"請填寫接點人帳號"},
                password: {required:"請填寫密碼",minlength:"密碼最少6碼"},
                password_confirmation: "請確認密碼"
      
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

                sendUri = APP_URL + "/shop/use/{{ $route_code }}";
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"POST",function(data){
                    window.location.href= APP_URL + '/shop/my_product';
                },
                function(data){
                });
                
            }
        }); //送出表單

        jQuery.validator.addMethod("noSpace", function(value, element) { 
          return value.indexOf(" ") < 0 && value != ""; 
        }, "請勿輸入空格，請重新確認");




    }); 

</script>
@stop

