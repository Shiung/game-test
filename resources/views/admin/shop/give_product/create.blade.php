@extends('layouts.admin') 
@section('head')

<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
@stop 
@section('content-header',$page_title) 
@section('content')
<div class="box-header with-border">
    <ol class="breadcrumb">
        <li>{{ $page_title }}</li>
        <li class="active">新增</li>
    </ol>
    <!-- 上一頁 -->
    <div class="text-left">
        <a href="{{ route('admin.shop.'.$route_code.'.index') }}"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="回上一頁"><i class="fa fa-fw fa-reply"></i></button></a>
    </div>
</div>
<div class="box-body" >
    <form id="Form">
        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','give-product-write'),''))                
        <!-- 額外資訊 -->
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">確認贈送</button>
        </div>
        @endif
        <div class="row">
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="price">商品*</label>
                    <select class="form-control" name="product_id" id="products">
                        @foreach($products as $product)
                            @if($product->product_category_id != 3 &&  $product->product_category_id != 2)
                            <option value="{{ $product->id }}" data-name="[{{ $product->category->name }}]{{ $product->name }}">[{{ $product->category->name }}] #{{ $product->id }} {{ $product->name }}（金額：{{ $product->price }}）</option>
                            @endif
                        @endforeach  
                    </select>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="price">數量*</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" min="1" value="" required>
                </fieldset>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <fieldset class="form-group">
                    <label for="description">贈送說明*</label>
                    <input type="text" class="form-control" name="description" id="description" placeholder="限制100個字元" required>
                </fieldset>
            </div>
        </div>

        <h3>贈送會員</h3>
        <div class="table-responsive">
            <table id="data_list" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th> <input name="clickAll" id="clickAll" type="checkbox"> 全選</th>
                        <th>編號</th>
                        <th>帳號</th>
                        <th>名稱</th>
                        <th>加入日期</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label><input type="checkbox" name="ids[]" value="{{ $member->user_id }}"></label>
                            </div>
                        </td>
                        <td>#{{ $member->member_number }}</td>
                        <td>{{ $member->user->username }}</td>
                        <td>
                            <a href="{{ route('admin.member.show',$member->user_id) }}" class="fancybox fancybox.iframe">{{ $member->name }}</a>
                  
                        </td>
                        <td>{{ $member->created_at }} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        
    </form>
</div>
<!-- /.box-body -->
@stop @section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!-- Loading -->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<!-- Select2-->
<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>

<script>
    $(document).ready(function() {

        var ids = [];
        var table = $("#data_list");
        var token = $('input[name="_token"]').val();

        $('#products').select2();
        $(".fancybox").fancybox();
        $("#data_list").DataTable({
            "order": [
                [3, "desc"]
            ],
            "paging": false,
            "searching": true
        });

        //判斷是否有勾選項目
        $("input[name='ids[]']").click(function() {
            if ($("input[name='ids[]']:checked").length > 0) {
                $("#update").prop("disabled",false);
            } else {
                $("#update").prop("disabled",true);
            }
        });

        //全選
        $("#clickAll").click(function() {
             if($("#clickAll").prop("checked")) {
               $("#data_list input[name='ids[]']").each(function() {
                   $(this).prop("checked", true);
               });
             } else {
               $("#data_list input[name='ids[]']").each(function() {
                   $(this).prop("checked", false);
               });  
               //清空
               ids = [];         
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
                ids = [];
                $(':checkbox:checked').each(function(i){
                    if($(this).attr('id') != 'clickAll'){
                        ids.push($(this).val())
                        //ids[i] = $(this).val();
                    }
                });
                console.log(ids)

                if(ids.length == 0){
                    swal("Failed", "請選擇贈送對象",'error');
                    return false;
                }

                name = $('#products').find(':selected').attr('data-name')
                quantity = $('#quantity').val();
                swal({
                    title: '操作確認',
                    text: '確認贈送 '+name+' *'+quantity+'個 給勾選會員(共'+ids.length+'名)?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '確認',
                    cancelButtonText: '取消'
                },function(){
                    sendUri = APP_URL + "/shop/{{ $route_code }}";
                    sendData = { '_token' :token, quantity:$('#quantity').val(),'product_id' : $('#products').val(),'ids' :ids ,'description':$('#description').val() };
                    system_ajax(sendUri,sendData,"POST",function(data){
                        window.location.href = APP_URL + "/shop/{{ $route_code }}";
                    });
                });
                
            }
        }); //submit
        
    });
</script>
@stop