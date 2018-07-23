@extends('layouts.admin') 
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
@stop 
@section('content-header',$page_title) 
@section('content')

<div class="box-header with-border">
    <ol class="breadcrumb">
        <li>商品管理</li>
        <li class="active">{{ $page_title }}</li>
    </ol>

</div>

<div class="box-body" >
    <p>若要編輯娛樂碼商品，請先將商品狀態改成「下架」</p>
    <div class="table-responsive">
        <table id="data_list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>名稱</th>
                    <th>金額</th>
                    <th>狀態</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td><a href="{{ route('admin.product.show',$data->id) }}" class="fancybox fancybox.iframe">{{ $data->name }}</a></td>
                    <td>{{ $data->price }}</td>
                    <td>
                        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','product-write'),''))
                        <div class="btn-group status" data-toggle="buttons">
                            <label class="btn @if($data->status==0)  btn-primary @else btn-default @endif">
                                <input type="radio" data-id="{{ $data->id }}" data-status="0" name="status" data-name="{{ $data->name }}"@if($data->status==0) checked @endif>下架
                            </label>
                            <label class="btn @if($data->status==1) btn-primary @else btn-default @endif"  >
                                <input type="radio" data-id="{{ $data->id }}" data-status="1" name="status" data-name="{{ $data->name }}" @if($data->status==1) checked @endif>上架
                            </label>
                        </div>   
                        @endif
                    </td>
                    <td>
                        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','product-write'),'') && $data->status == 0)
                        <button class="btn btn-primary btn-sm edit" data-toggle="tooltip" title="編輯" data-id="{{ $data->id }}" data-name="{{ $data->name }}" data-price="{{ $data->price }}"><i class="fa fa-pencil"></i></button>
                        @endif
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
<!-- /.box-body -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="Form">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">編輯權利碼商品</h5>
            </div>
            <div class="modal-body">
                <fieldset class="form-group">
                    <label for="name">名稱*</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $data->name }}" required>
                </fieldset>
                <fieldset class="form-group">
                    <label for="name">金額（僅開放小數點後兩位，超過會四捨五入）*</label>
                    <input type="text" class="form-control" name="price" id="price" value="{{ round($data->price) }}" required >
                </fieldset>
                <fieldset class="form-group">
                    <label for="description">商品說明（用途）*</label>
                    <input type="text" class="form-control" name="description" id="description" value="{{ $data->description }}" required>
                </fieldset>
    
            </div>
            <div class="modal-footer">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary">確認</button>
            </div>
        </form>
    </div>
  </div>
</div>
@stop 
@section('footer-js')
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-confirm/jquery.confirm.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var table = $("#data_list");
        
        $(".fancybox").fancybox();


        //更新上下架狀態 
        table.on("change", ".status :input", function(e) {

            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');
            var status = $(this).data('status');
            var label = $(this).parent()
  
            

            //確認訊息
            $.confirm({
                text: "確認改變「" + name + "」   上下架狀態?",
                confirm: function(button) {
                    
                    sendUri = APP_URL + "/shop/product/own_share/change-status/" + id;
                    sendData = { '_token': token,'_method': 'PUT','status':status};
                    system_ajax(sendUri,sendData,"PUT",function(data){

                        window.location.reload()
                        label.removeClass("btn-default");
                        label.addClass("btn-primary");
                        label.removeClass("active");
                        label.siblings().addClass("btn-default");
                        label.siblings().removeClass("btn-primary");
                    });
                    
                },
                cancel: function(button) {
                    label.removeClass("active");
                },
                confirmButton: "確認",
                cancelButton: "取消"
            }); //.確認訊息
        });//.更新

        //打開編輯modal 
        table.on("click", ".edit", function(e) {

            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');
            var price = $(this).data('price');
  
            

            $('#editModal').modal('toggle');
        });//.更新

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

                
                sendUri = APP_URL + "/shop/product/{{ $route_code }}" ;
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"PUT",function(data){
                    window.location.reload();
                });


            }
        }); //submit
        
    });
</script>
@stop