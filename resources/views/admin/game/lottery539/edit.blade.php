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
        <div class="modal-header">
            <h3 class="modal-title" >開獎資訊</h5>
        </div>

        <div class="modal-body">
            <p>。有效開獎號碼：1~39</p>
            <p>。開獎號碼請勿重複</p>
            <div class="row">
                <div class="col-md-12">
                    <fieldset class="form-group" >
                        <label for="sport_number">期別號碼*</label>
                        <input type="text" class="form-control" name="sport_number" value="{{ $data->sport_number }}"  required>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <fieldset class="form-group" >
                        <label for="lottery_number">號碼[1]*</label>
                        <input type="number" class="form-control" name="lottery_numbers[1]" min="1" max="39" value="@if(count($numbers)>0 ){{ $numbers->toArray()[0]['number'] }}@endif"  required>
                    </fieldset>
                </div>
                <div class="col-md-4">
                    <fieldset class="form-group" >
                        <label for="lottery_number">號碼[2]*</label>
                        <input type="number" class="form-control" name="lottery_numbers[2]" min="1" max="39" value="@if(count($numbers)>0 ){{ $numbers->toArray()[1]['number'] }}@endif"   required>
                    </fieldset>
                </div>
                <div class="col-md-4">
                    <fieldset class="form-group" >
                        <label for="lottery_number">號碼[3]*</label>
                        <input type="number" class="form-control" name="lottery_numbers[3]" min="1" max="39" value="@if(count($numbers)>0 ){{ $numbers->toArray()[2]['number'] }}@endif"   required>
                    </fieldset>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <fieldset class="form-group" >
                        <label for="lottery_number">號碼[4]*</label>
                        <input type="number" class="form-control" name="lottery_numbers[4]" min="1" max="39" value="@if(count($numbers)>0 ){{ $numbers->toArray()[3]['number'] }}@endif"  required>
                    </fieldset>
                </div>
                <div class="col-md-4">
                    <fieldset class="form-group" >
                        <label for="lottery_number">號碼[5]*</label>
                        <input type="number" class="form-control" name="lottery_numbers[5]" min="1" max="39" value="@if(count($numbers)>0 ){{ $numbers->toArray()[4]['number'] }}@endif"   required>
                    </fieldset>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
            <input type="hidden" name="sport_id" id="sport_id"  value="{{ $data->id }}"> 
        </div>
        <div class="modal-footer">
            @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','sport-write'),''))
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary">確定</button>
            @endif
        </div>
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


                sendUri = APP_URL + "/game/{{ $route_code }}/"+sport_id;
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"PUT",function(data){
                    window.parent.location.href = APP_URL + "/game/{{ $route_code }}/history";
                });

                
            }
        }); //submit
        
    });
</script>
@stop