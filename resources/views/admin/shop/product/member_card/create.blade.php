@extends('layouts.admin') 
@section('head')

<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 

@stop 
@section('content-header',$page_title) 
@section('content')
<div class="box-header with-border">
    <ol class="breadcrumb">
        <li>商品管理</li>
        <li>{{ $page_title }}</li>
        <li class="active">新增</li>
    </ol>
    <!-- 上一頁 -->
    <div class="text-left">
        <a href="{{ route('admin.shop.product.'.$route_code.'.index') }}"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="回上一頁"><i class="fa fa-fw fa-reply"></i></button></a>
    </div>
</div>
<div class="box-body" >
    <form id="Form">
        <div class="row">
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="name">商品名稱*</label>
                    <input type="text" class="form-control" name="name" id="name" value="" required>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="tree_name">組織圖顯示的級別名稱（最多三個字）*</label>
                    <input type="text" class="form-control" name="tree_name" id="tree_name" value="" required maxlength="3">
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="price">價格*</label>
                    <input type="number" class="form-control" name="price" id="price" min="0" value="" required>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <fieldset class="form-group">
                    <label for="description">商品說明（用途）*</label>
                    <input type="text" class="form-control" name="description" id="description" value="" required>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="subtract">是否扣庫存*</label>
                    <select class="form-control" id="subtract" name="subtract">
                        <option value="0">否（無限制數量）</option>
                        <option value="1">是（前台顯示數量）</option>
                    </select>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group" style="display:none;" id="quantity_part">
                    <label for="quantity">數量*</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" min="0" value="1" required>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <fieldset class="form-group" >
                    <label for="interest">紅利（%）*</label>
                    <input type="number" class="form-control" name="interest" id="interest" min="0"  required>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group" >
                    <label for="member_feedback">使用者回饋金*</label>
                    <input type="number" class="form-control" name="member_feedback" id="member_feedback" min="0"  required>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group" >
                    <label for="recommender_feedback">推薦者回饋金*</label>
                    <input type="number" class="form-control" name="recommender_feedback" id="recommender_feedback" min="0"  required>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <fieldset class="form-group" >
                    <label for="period">卡片有效天數*  (輸入0 ：無限期)</label>
                    <input type="number" class="form-control" name="period" id="period" min="0"  required>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group" >
                    <label for="feedback_period">回饋金有回饋金領取有效天數* (輸入0 ：無限期)</label>
                    <input type="number" class="form-control" name="feedback_period" id="feedback_period" min="0"  required>
                </fieldset>
            </div>
        </div>


        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))                
        <!-- 額外資訊 -->
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <center>
            <button type="submit" class="btn btn-primary">確認</button>
        </center>
        @endif
    </form>
</div>
<!-- /.box-body -->
@stop @section('footer-js')

<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!-- Loading -->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>

<script>
    $(document).ready(function() {

        //是否扣庫存更動
        $( "#subtract" ).change(function() {
            if($(this).val() == '0'){
                $('#quantity').val(1);
                $('#quantity_part').css('display','none');
            } else {
                $('#quantity_part').css('display','block');
            }
        });

        //表單驗證 
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
                } else if (element.attr("name") == "date") {
                    error.insertAfter(".input-group");
                } else {
                    error.insertAfter(element);
                }

            },
            submitHandler: function(form) {


                sendUri = APP_URL + "/shop/product/{{ $route_code }}";
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"POST",function(data){
                    window.location.href = APP_URL + "/shop/product/{{ $route_code }}";
                });
                
            }
        }); //submit
        
    });
</script>
@stop