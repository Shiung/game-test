@extends('layouts.main')
@section('head')

<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@stop 

@section('content')

<h1>{{ $page_title }}</h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">會員專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->

@if($process_count == 0 || ! $process_count)
<h3>申請表</h3>
<!--確認使用-->
<form id="Form" action="{{ route('front.member.transfer_ownership_record.sms') }}" method="POST">
    <div class="row">
        <div class="col-sm-3">
            <fieldset class="form-group">
                <label for="name">姓名*</label>
                <input type="text" class="form-control" name="name" >
            </fieldset>  
        </div>
        <div class="col-sm-3">
            <fieldset class="form-group">
                <label for="username">帳號*</label>
                <input type="text" class="form-control" id="username" name="username" maxlength="10" minlength="6" required placeholder="請輸入6~10個字元" required>
            </fieldset>   
        </div>
        <div class="col-sm-3">
            <fieldset class="form-group">
                <label for="password">密碼*</label>
                <input type="password" class="form-control" name="password" id="password" minlength="6" required>
            </fieldset>   
        </div>
        <div class="col-sm-3">
            <fieldset class="form-group">
                <label for="password_confirmation">確認密碼*</label>
                <input type="password" class="form-control" name="password_confirmation" minlength="6"  required>
            </fieldset>   
        </div>
        
    </div>

    
    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
    <center>
        <button class="btn btn-primary" type="submit">確認送出</button>
    </center>
</form>
@endif


@if($datas->where('status','0')->count() > 0)
<h3>申請紀錄</h3>
<!--列表-->
<table id="data_list" class="table table-bordered table-striped">
    <thead>
        <th>時間</th>
        <th class="no-sort">舊資訊</th>
        <th class="no-sort">新資訊</th>
        <th class="no-sort">處理狀態</th>
    </thead>
    <tbody>
    @foreach($datas as $data)
    @if($data->status == '0')
    <tr>
        <td>{{ $data->created_at }}</td>
        <td>{{ $data->old_username }}({{ $data->old_name }})</td>
        <td>{{ $data->username }}({{ $data->name }})</td>
        <td>{{ config('member.transfer_ownership_record.status.'.$data->status) }}</td>
    </tr>
    @endif
    @endforeach
    </tbody>
</table>
<!--/.列表-->
@endif

@stop

@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var receive = $('#receive').parent();
        var type = 'member';

      
        //新增 
        $("#Form").validate({
            ignore: [],
            rules: {
                username: {
                    required:true,
                    noSpace: true
                },
                parent_username: {
                    required:true,
                    noSpace: true
                },
                password: {
                    required:true,
                    noSpace: true
                },
                password_confirmation: {
                    required:true,
                    equalTo:"#password",
                    noSpace: true
                }
            },
            messages: {
                name: "請填寫姓名",
                username: {
                    required:"請填寫帳號",minlength:"帳號請輸入6-10個字元",maxlength:"帳號請輸入6-10個字元"
                },
                password: {required:"請填寫密碼",minlength:"密碼最少6碼"},
                password_confirmation: "請確認密碼"
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");

                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element);
                } else if (element.attr("name") == "date"  ) {
                    error.insertAfter(".input-group");
                } else {
                    error.insertAfter(element);
                }

            },
            submitHandler: function(form) {
                return true;
                
                
            }
        }); //新增   

        $("#data_list").DataTable({
            "order": [
                [0, "desc"]
            ],
            "paging": true,
            "searching": true,
            "columnDefs": [{
              "orderable": false,
              "targets": "no-sort"
            }]
        });

        //帳號檢查
        $( "#username" ).change(function() {

            if( $(this).val()){
                checkUser($(this).val());
            } 
        });

        //檢查會員是否存在
        function checkUser(username){
            $.ajax({
                url: APP_URL + "/member/username-exist",
                data: {'username':username},
                type: "GET",
                success: function(msg) {
                    var data = JSON.parse(msg);

                    if (data.result == 1) {
                        swal({ 
                              title: "操作確認", 
                              text: "帳號重複，請重新輸入", 
                              type: "error", 
                        },
                        function(){ 
                              $('#username').val('')
                        });
                    } 
                },
                error: function(xhr) {
                    
                }
            });
        }  

        jQuery.validator.addMethod("noSpace", function(value, element) { 
          return value.indexOf(" ") < 0 && value != ""; 
        }, "請勿輸入空格，請重新確認");
 
        
    });
</script>

@stop
