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
</ul>

<!--餘額-->
<div class="row">
    <div class="col-md-3">
        <ul class="list-group">
            <li class="list-group-item">
                金幣可用餘額：{{ number_format($cash_account) }}
            </li>
        </ul>
    </div>
</div>
<!--/.餘額-->

<!--確認使用-->
<form id="Form" action="{{ route('front.shop.use.account_transfer.sms') }}" method="POST">
    <div class="row">
        <div class="col-md-4">
            <fieldset class="form-group">
                <label for="amount">紅包金額*</label>
                <input type="number" class="form-control" name="amount" id="amount" value="" min="0" max="{{ $cash_account }}" required >
            </fieldset>
        </div>
        <div class="col-md-4">
             <fieldset class="form-group">
                <label for="receive">發紅包帳號*</label>
                <input type="text" class="form-control" name="receive" id="receive" value="" placeholder="">
            </fieldset>
        </div>
        <div class="col-md-4" style="display:none;">
            <fieldset class="form-group">
                <label for="position">紅包類型</label>
                <select class="form-control" name="type" id="type">
                    <option value="member" selected>指定紅包帳號</option>
                    <option value="company">不指定發紅包帳號（群發）</option>
                </select>
            </fieldset> 
        </div>
        
    </div>

    <div class="row">
        <div class="col-md-12">
             <fieldset class="form-group">
                <label for="description">說明*</label>
                <input type="text" class="form-control" name="description" id="description" required placeholder="限50個字元">
            </fieldset>
        </div>
    </div>
    
    <input type="hidden" class="form-control" name="product_id" id="product_id" value="{{ $product->id }}" required>
    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
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
        var receive = $('#receive').parent();
        var type = 'member';

        //轉帳類型改變
        $( "#type" ).change(function() {
            type =  $(this).val();
            if(type == 'member'){
                receive.css('display','block');
            } else {
                receive.css('display','none');
            }
        });

        //轉帳帳號檢查
        $( "#receive" ).change(function() {
            if(type == 'member' && $(this).val()){
                checkUser($(this).val());
            } 
        });
        //新增 
        $("#Form").validate({
            ignore: [],
            rules: {
            },
            messages: {
                amount:{
                    required:"請填寫此欄位",
                    max:"餘額不足"
                }
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");

                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element);
                } else if (element.attr("name") == "date"  ) {
                    error.insertAfter(".input-group");
                } else {
                    error.insertAfter(element);
                }

            },
            submitHandler: function(form) {
                if(type == 'member'){
                    if(!$('#receive').val()){
                        swal("Failed",'請輸入會員帳號', 'error');
                        return false;
                    }
                }
                return true;
                
                
            }
        }); //新增   

        //檢查會員是否存在
        function checkUser(username){
            $.ajax({
                url: APP_URL + "/shop/use/account_transfer/check-user",
                data: {'receive':username},
                type: "POST",
                success: function(msg) {
                    var data = JSON.parse(msg);
                    if (data.result != 1) {
                        swal({ 
                              title: "操作確認", 
                              text: "帳號不存在，請重新輸入", 
                              type: "error", 
                        },
                        function(){ 
                              $('#receive').val('')
                        });
                    } 
                },
                error: function(xhr) {
                    
                }
            });
        }  
        
    });
</script>

@stop
