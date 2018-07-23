@extends('layouts.main')
@section('head')
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
@stop

@section('content')

<h1>{{ $page_title }} </h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">{{ $page_title }}</li>
</ol>
<!--/.路徑-->


<!--新增留言-->
<form id="Form">
    <div class="input-group message-group">
        <input type="text" class="form-control" name="content" id="content" required placeholder="留言內容，限制100個字元"> 
        <span class="input-group-btn">
            <input type="submit" class="btn btn-info"  value="送出" >
        </span>
    </div>
</form>
<!--/.新增留言-->

<hr>
<!--日期-->
<div style="margin-bottom:20px; width: 100%" class="form-inline">
    <div class="form-group">
        <label>開始時間</label>
        <input type="date" class="form-control" name="start" id="start" value="{{ $start }}">
    </div>

    <div class="form-group">
        <label>結束時間</label>
        <input type="date" class="form-control" name="end" id="end" value="{{ $end }}">
    </div>

    <input type="button" class="btn btn-info " id="search" value="查詢" >
        
</div>
<!--/.日期-->


<!--列表-->
<table class="table" id="data_list">
    <thead>
        <th>留言人</th>
        <th>內容</th>
        <th>新增日期</th>
    </thead>
    <tbody>
    @foreach($datas as $data)
    <tr>
        <td>{{ $data->member->name }}</td>
        <td>{{ $data->content }}</td>
        <td>{{ $data->created_at }}</td>
        <td>
            @if(Auth::guard('web')->user()->id == $data->member_id )
            <button class="btn btn-danger btn-sm delete" data-toggle="tooltip" title="刪除" data-id="{{ $data->id }}" data-name="{{ $data->content }}"><i class="fa fa-trash"></i></button>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
<!--/.列表-->

<!--分頁-->
<div class="page-area">{!! $datas->render() !!}</div>

@stop

@section('footer-js')
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script src="{{ asset('front/js/recordcommon.js') }}"></script>
<script>
    $(document).ready(function() {  
        var table = $("#data_list");
        //submit
        $("#Form").validate({ignore:[],rules:{},messages:{},errorElement:"em",errorPlacement:function(e,r){e.addClass("help-block"),"checkbox"===r.prop("type")?e.insertAfter(r):"content"==r.attr("name")?e.insertAfter(".message-group"):e.insertAfter(r)},submitHandler:function(e){sendUri=APP_URL+"/{{ $route_code }}",sendData=$("#Form").serialize(),system_ajax(sendUri,sendData,"POST",function(e){window.location.reload()},function(e){})}});
        //delete 
        table.on("click",".delete",function(t){t.preventDefault();var e=$(this).data("id"),n=$(this).data("name"),a=$(this).parent().parent();swal({title:"操作確認",text:"確認刪除留言「"+n+"」？",type:"warning",showCancelButton:!0,confirmButtonText:"確認",cancelButtonText:"取消"},function(){sendUri=APP_URL+"/{{ $route_code }}/"+e,sendData={},system_ajax(sendUri,sendData,"DELETE",function(t){a.remove()},function(t){})})});
        //search
        $("#search").click(function(){searchDateRange($("#start").val(),$("#end").val(),"/{{ $route_code }}/")});
    }); 

</script>
@stop
