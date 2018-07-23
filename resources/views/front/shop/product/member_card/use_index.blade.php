@extends('layouts.main')
@section('head')

<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 

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
    <li class="list-group-item"><b>額外說明： </b>若使用同名稱但不同紅利，會以紅利較高為主進行計算，使用同名稱同紅利，有效天數則累計</li>
</ul>

<!--確認使用-->
<form id="Form">
      <input type="hidden" class="form-control" name="product_id" id="product_id" value="{{ $product->id }}" required>
      <center>
        <button class="btn btn-primary" type="submit">確認使用</button>
      </center>
</form>

@stop

@section('footer-js')

<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<script>
    $(document).ready(function() {

        //新增 
        $("#Form").validate({
            ignore: [],
            rules: {
            },
            messages: {
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");

                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element);
                } else if (element.attr("name") == "date" || element.attr("name") == "amount" ) {
                    error.insertAfter(".input-group");
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
        }); //新增

        
        
    });
</script>

@stop
