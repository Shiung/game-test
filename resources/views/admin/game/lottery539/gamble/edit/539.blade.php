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

    <form id="Form">
        <h4>賠率</h4>
        <div class="row">
            <div class="col-md-3">
                <fieldset class="form-group" >
                    <label for="one_ratio">中一顆*</label>
                    <input type="number" class="form-control" name="one_ratio" id="one_ratio"  max="100" value="@if($detail->one_ratio){{ $detail->one_ratio*100 }}@endif" required>
                </fieldset>
            </div>
            <div class="col-md-3">
                <fieldset class="form-group" >
                    <label for="two_ratio">中兩顆*</label>
                    <input type="number" class="form-control" name="two_ratio" id="two_ratio"  max="100" value="@if($detail->two_ratio){{ $detail->two_ratio*100 }}@endif" required>
                </fieldset>
            </div>
            <div class="col-md-3">
                <fieldset class="form-group" >
                    <label for="three_ratio">中三顆*</label>
                    <input type="number" class="form-control" name="three_ratio" id="three_ratio"  max="100" value="@if($detail->three_ratio){{ $detail->three_ratio*100 }}@endif" required>
                </fieldset>
            </div>
        </div>


        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))                
        <!-- 額外資訊 -->
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="sport_id" name="sport_id" value="{{ $sport->id }}">
        <input type="hidden" id="game_id" name="game_id" value="{{ $data->id }}">
        <input type="hidden" id="type" name="type" value="{{ $type }}">
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

        var sport_id = $('#sport_id').val()
        var game_id = $('#game_id').val()

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

                sendUri = APP_URL + "/game/{{ $route_code }}/gamble/"+game_id;
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"PUT",function(data){
                    window.parent.location.reload();
                });
                
            }
        }); //submit
        
    });
</script>
@stop