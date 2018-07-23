@extends('layouts.blank') 
@section('head')

<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 

@stop 
@section('content-header',$page_title) 
@section('content')

<div class="box-body" >
    <div class="row">
        <div class="col-sm-6">
            <h5>主隊</h5>
            <ul class="list-group">  
                <li class="list-group-item"><b>隊伍名稱： </b>{{ $home_team->name }}</li>
                <li class="list-group-item"><b>分數： </b>{{ $home_team->score }}</li>
            </ul>
        </div>
        <div class="col-sm-6">
            <h5>客隊</h5>
            <ul class="list-group">  
                <li class="list-group-item"><b>隊伍名稱： </b>{{ $away_team->name }}</li>
                <li class="list-group-item"><b>分數： </b>{{ $away_team->score }}</li>
            </ul>
        </div>
    </div>
    <form id="Form">
        <fieldset class="form-group">
            <label for="status">賽程狀態*</label>
            <select class="form-control" id="status" name="status">
                <option value="Scheduled" @if($data->status == "Scheduled") selected @endif>尚未開始</option>
                <option value="InProgress" @if($data->status == "InProgress") selected @endif>進行中</option>
                <option value="Final" @if($data->status == "Final") selected @endif>已結束</option>
                <option value="Suspended" @if($data->status == "Suspended") selected @endif>暫停</option>
                <option value="Postponed" @if($data->status == "Postponed") selected @endif>延期</option>
                <option value="Canceled" @if($data->status == "Canceled") selected @endif>取消</option>
            </select>
        </fieldset>
        

        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))                
        <!-- 額外資訊 -->
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">

        <input type="hidden" id="id" name="id" value="{{ $data->id }}">
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

        var category_id = $('#category_id').val()
        var id = $('#id').val()


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


                sendUri = APP_URL + "/game/{{ $route_code }}/status/"+id;
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"PUT",function(data){
                    window.parent.location.reload();
                });

                
            }
        }); //submit
        
    });
</script>
@stop