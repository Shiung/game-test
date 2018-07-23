@extends('layouts.main')
@section('head')

@stop 

@section('content')

<h1>{{ $page_title }} </h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">會員專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->

<hr>
<form id="Form" method="POST" action="{{ route('front.account.detail') }}">

    <div class="row">
        <div class="col-sm-6">
            <fieldset class="form-group">
                <select class="form-control" id="user_type" name="user_type" >
                    <option value="own">搜尋本人帳號</option>
                    <option value="sub">搜尋社群帳號</option>
                </select>
            </fieldset>
        </div>
        <div class="col-sm-6">
            <fieldset class="form-group" id="username_field" style="display:none;">
                <input type="text" class="form-control" name="username" id="username" maxlength="50" placeholder="請輸入好友帳號">
            </fieldset>  
        </div>
    </div>   

    <div class="row">
        <div class="col-sm-6">
            <fieldset class="form-group">
                <label for="range">搜尋區間</label>
                <select class="form-control" id="range" name="range" >
                    @foreach(config('member.range') as $key => $item)
                    <option value="{{ $key }}">{{ $item }}</option>
                    @endforeach
                </select>
            </fieldset>
        </div>
        <div class="col-sm-6">
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

@stop

@section('footer-js')
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<script>
    $(document).ready(function() {

        setUsernameField()
        
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


        //選擇搜尋類型
        $( "#user_type" ).change(function() {
            setUsernameField()  
        });

        //設置好友帳號是否顯示
        function setUsernameField(){
            if($('#user_type').val() == 'sub'){
                //下線要變成required
                $("#username").prop('required',true);
                $('#username_field').css('display','block');
            } else {
                $("#username").prop('required',false);
                $('#username').val('');
                $('#username_field').css('display','none');
            }
        }
    });
</script>

@stop
