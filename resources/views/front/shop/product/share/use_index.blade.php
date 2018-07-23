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
    <li class="list-group-item"><b>商品類型： </b>{{ $product->category->name }}</li>
    <li class="list-group-item"><b>價錢： </b>{{ number_format($product->price) }}</li>
</ul>

<!--確認使用-->
<form id="Form">
    <div class="row">
        <div class="col-md-4">
            <fieldset class="form-group">
                <label for="quantity">目前娛樂幣餘額</label>
                <input type="number" class="form-control" id="current_amount"  value="{{ $share_amount }}" readonly >
            </fieldset>
        </div>
        <div class="col-md-4">
            <fieldset class="form-group">
                <label for="quantity">使用數量*  (目前擁有數量：{{ $bag->quantity }})</label>
                <input type="number" class="form-control" name="quantity" id="quantity" value="1" min="0" max="{{ $bag->quantity }}" required >
            </fieldset>
        </div>
        <div class="col-md-4">
            <fieldset class="form-group">
                <label for="quantity">使用後娛樂幣餘額</label>
                <input type="number" class="form-control" id="new_amount" value="" readonly >
            </fieldset>
        </div>
    </div>
        

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

        var token = $('input[name="_token"]').val();
        var current_amount = $('#current_amount').val();
        refreshShareAmount()

        //使用數量改變
        $("#quantity").change(function(){
            refreshShareAmount()
        });
        //更新餘額
        function refreshShareAmount(){
            $('#new_amount').val(parseInt(current_amount)+parseInt($('#quantity').val()) )
        }

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
