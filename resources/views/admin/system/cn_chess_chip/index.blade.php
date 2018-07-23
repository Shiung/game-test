@extends('layouts.admin') 
@section('head')
<link rel="stylesheet" href="{{ asset('plugins/timepicker/jquery.timepicker.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 

@stop 
@section('content-header',$page_title) 
@section('content')

<div class="box-header with-border">
    <ol class="breadcrumb">
        <li class="active">{{ $page_title }}</li>
    </ol>
</div>

<div class="box-body" >

    <form id="Form" style="margin-bottom:20px;">
      @foreach($datas as $data)
      <h4>{{ $data['name'] }}</h4>
        @foreach($data['chips'] as $key => $chip)
        <p>第{{ $key }}個</p>
        <div class="row">
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label >顯示名稱</label>
                   <select class="form-control chip_name" name="chips[{{ $data['id'] }}][{{ $key }}][name]"  data-id="{{ $data['id'] }}" data-key="{{ $key }}">
                        @foreach(config('cn_chess.chips') as $chip_name =>  $chip_amount)
                        <option value="{{ $chip_name }}" @if($chip['name'] == $chip_name) selected @endif amount="{{ $chip_amount }}">{{ $chip_name }}</option>
                        @endforeach
                   </select>
                   
                </fieldset>
            </div>
            <div class="col-sm-3" >
                <fieldset >
                   <label for="maintenance_start">金額</label>
                   <input type="number" class="form-control"  id="amount_{{ $data['id'] }}_{{ $key }}" name="chips[{{ $data['id'] }}][{{ $key }}][amount]" value="{{ $chip['amount'] }}" required readonly>
                </fieldset>
            </div>
        </div>
        @endforeach
      @endforeach
        
      

        <!-- 額外資訊 -->
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))
        <center>
        <button type="submit" class="btn btn-primary btn">確認</button>
        </center>
        @endif
        </form>
    
</div>

@stop 
@section('footer-js')

<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-confirm/jquery.confirm.min.js') }}"></script>
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>

<script>
    $(document).ready(function() {

        $( ".chip_name" ).change(function() {
            id = $(this).data('id');
            key = $(this).data('key');
            amount = $(this).find(':selected').attr('amount');
            
            $('#amount_'+id+'_'+key).val(amount)
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

                sendUri = APP_URL + "/system/{{ $route_code }}";
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"PUT",function(data){
                    window.location.href = APP_URL + "/system/{{ $route_code }}";
                });
                
            }
        }); //submit
        

        
    });
</script>
@stop