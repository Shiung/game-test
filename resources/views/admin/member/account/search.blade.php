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
        <li class="active">{{ $page_title }}</li>
    </ol>
</div>
<div class="box-body" >
    <form id="Form" method="POST" action="{{ route('admin.member.account.detail') }}">

        <div class="row">
            <div class="col-sm-4">
                <fieldset class="form-group" id="username_field" >
                    <label for="range">會員帳號</label>
                    <input type="text" class="form-control" name="username" id="username" maxlength="50"  required>
                </fieldset>  
            </div>
            <div class="col-sm-4">
                <fieldset class="form-group">
                    <label for="range">搜尋區間</label>
                    <select class="form-control" id="range" name="range" >
                        <option value="all">全部</option>
                        @foreach(config('member.range') as $key => $item)
                        <option value="{{ $key }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>
            <div class="col-sm-4">
                <fieldset class="form-group">
                    <label for="type">帳戶類型</label>
                    <select class="form-control" id="type" name="type" >
                        <option value="all">全部</option>
                        @for($i=1;$i<5;$i++)
                        <option value="{{ $i }}">{{ config('member.account.type.'.$i) }}</option>
                        @endfor
                    </select>
                </fieldset>  
            </div>
        </div>  
     
        <!-- 額外資訊 -->
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_method" name="_method" value="POST">
        <center>
            <button type="submit" class="btn btn-primary">確認搜尋</button>
        </center>
        
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


        //送出表單
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
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                return true;
            }
        }); //送出表單
        
    });
</script>
@stop