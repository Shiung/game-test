@extends('layouts.main')
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
@stop 

@section('content')

<h1>{{ $page_title }} </h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">商城專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->

<!--購買輸入-->
<div class="row">
  <div class="col-sm-12">
    <form id="Form">
        <div class="input-group amount_group">
          <input type="number" class="form-control" name="amount" id="amount" placeholder="請輸入欲儲值金幣(1:100)" min="1" required>
          <span class="input-group-btn">
            <button class="btn btn-secondary btn-danger" type="submit">確認申請</button>
          </span>
        </div>
    </form>
  </div>
</div>
<!--/.購買輸入-->

<hr>

<!--時間區間-->
<form id="Form" style="margin-bottom:20px;">
    <div class="input-group ">
        <input type="text" class="form-control" name="start" id="start" value="{{ $start }}" placeholder="ex 2017-01-01">
        <span class="input-group-addon">~</span>
        <input type="text" class="form-control" name="end" id="end" value="{{ $end }}" placeholder="ex 2017-02-01">
        <span class="input-group-btn">
            <input type="button" class="btn btn-info" id="search" value="查詢" >
        </span>
    </div>
</form>
<!--/.時間區間-->

<!--列表-->
<table id="data_list" class="table table-bordered table-striped">
    <thead>
        <th>金額</th>
        <th>確認狀態</th>
        <th>申請日期</th>
        <th></th>
    </thead>
    <tbody>
    @foreach($datas as $data)
    <tr>
        <td>{{ number_format($data->amount) }}</td>
        <td>{!! config('shop.charge.confirm_status.'.$data->confirm_status) !!}
            @if($data->confirm_status == 1 || $data->confirm_status == 2) 
            <br><small>確認時間：{{ $data->confirm_at }}</small>
            @endif
        </td>
        <td>{{ $data->created_at }}</td>
        <td>
            @if($data->confirm_status == 0)
                <button class="btn btn-danger btn-sm delete" data-id="{{ $data->id }}" data-name="{{ $data->created_at }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
<!--/.列表-->
@stop

@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script src="{{ asset('front/js/recordcommon.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="{{ asset('plugins/js-webshim/minified/polyfiller.js') }}"></script>
<script>
    $(document).ready(function() {

        var table = $("#data_list");

        $("#data_list").DataTable({
            "order": [
                [2, "desc"]
            ],
            "paging": true,
            "searching": true
        });
        //千分位
        webshims.setOptions('forms-ext', {
            replaceUI: 'true',
            types: 'number'
        });
        webshims.polyfill('forms forms-ext');

        //新增 
        $("#Form").validate({
            ignore: [],
            rules: {
            },
            messages: {
                amount: "請確認購買金額",
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                     error.insertAfter(element);

                } else if (element.attr("name") == "date" ) {
                     error.insertAfter(".input-group");
                } else if (element.attr("name") == "amount" ) {
                    error.insertAfter(".amount_group");
                 } else {
                     error.insertAfter(element);
                 }

            },
            submitHandler: function(form) {
                swal({
                    title: '操作確認',
                    text: '確認申請購買 '+$('#amount').val()+'分金幣?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '確認',
                    cancelButtonText: '取消'
                },function(){
                    sendUri = APP_URL + "/shop/{{ $route_code }}";
                    sendData = $('#Form').serialize();
                    system_ajax(sendUri,sendData,"POST",
                        function(data){
                            window.location.reload();
                        },
                        function(data){
                        }
                    );
                });
            }
        }); //新增

        
        //搜尋區間範圍
        $("#search").click(function(){
            searchDateRange($('#start').val(),$('#end').val(),"/shop/{{ $route_code }}/")
        });
  
        //刪除   
        table.on("click", ".delete", function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');

            swal({
                title: '操作確認',
                text: '確認刪除 '+name+' 購買申請?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '確認',
                cancelButtonText: '取消'
            },function(){
                sendUri = APP_URL + "/shop/{{ $route_code }}/" + id;
                sendData = { '_method': 'DELETE'};
                system_ajax(sendUri,sendData,"DELETE",
                    function(data){
                        window.location.reload();
                    },
                    function(data){
                    }
                );
            });

        });//.刪除

        

        
    });
</script>

@stop
