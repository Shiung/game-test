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
    @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','product-write'),''))
    <div class="text-right">
        <a href="{{ route('admin.shop.product.'.$route_code.'.create') }}"><button class="btn btn-primary btn-sm" data-toggle="tooltip" title="新增"><i class="fa fa-fw fa-plus"></i></button></a>
    </div>
    @endif
</div>

<div class="box-body" >
    <div class="tabbable-panel">
        <div class="tabbable-line">
            <ul class="nav nav-tabs ">
                <li class="active">
                    <a href="#status_1" data-toggle="tab">
                    上架中 </a>
                </li>
                <li>
                    <a href="#status_0" data-toggle="tab">
                    已下架</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="status_1">
                    <h3 style="color:green;">上架中商品</h3>
                    <div class="table-responsive">
                        <table id="data_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>編號</th>
                                    <th>名稱</th>
                                    <th>數量</th>
                                    <th>新增日期</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas->where('status','1')->all() as $data)
                                <tr>
                                    <td>#{{ $data->id }} </td>
                                    <td><a href="{{ route('admin.product.show',$data->id) }}" class="fancybox fancybox.iframe">{{ $data->name }}</a></td>
                                    <td> @if($data->subtract == 1){{ $data->quantity }}@else ∞  @endif </td>
                                    <td>{{ $data->created_at }}</td>
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
                                        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','product-write'),''))
                                        <a  href="{{ route('admin.shop.product.'.$route_code.'.edit',$data->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="編輯" ><i class="fa fa-pencil-square-o"></i></a>  
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="status_0">
                    <h3 style="color:red;">已下架商品</h3>
                    <div class="table-responsive">
                        <table id="data_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>編號</th>
                                    <th>名稱</th>
                                    <th>數量</th>
                                    <th>新增日期</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas->where('status','0')->all() as $data)
                                <tr>
                                    <td>#{{ $data->id }} </td>
                                    <td><a href="{{ route('admin.product.show',$data->id) }}" class="fancybox fancybox.iframe">{{ $data->name }}</a></td>
                                    <td> @if($data->subtract == 1){{ $data->quantity }}@else ∞  @endif </td>
                                    <td>{{ $data->created_at }}</td>
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
                                        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','product-write'),''))
                                        <a  href="{{ route('admin.shop.product.'.$route_code.'.edit',$data->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="編輯" ><i class="fa fa-pencil-square-o"></i></a>  
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<!-- /.box-body -->
<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
@stop 
@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-confirm/jquery.confirm.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var table = $(".table");
        $(".fancybox").fancybox();

        $(".table").DataTable({
            "order": [
                [3, "desc"]
            ],
            "paging": true,
            "searching": true
        });

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
                    
                    sendUri = APP_URL + "/shop/product/account_transfer/change-status/" + id;
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

        
        
    });
</script>
@stop