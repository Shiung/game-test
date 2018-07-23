@extends('layouts.main')
@section('head')

<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
@stop 

@section('content')
@inject('SubsDeletePresenter', 'App\Presenters\SubsDeletePresenter')
<h1>{{ $page_title }}</h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">會員專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->

<h4>符合以下刪除條件才開放申請刪除</h4>
<ul class="list-group">
    <li class="list-group-item"><b>金幣分數帳戶餘額低於：</b>{{ $params['cash_min'] }}</li>
    <li class="list-group-item"><b>娛樂幣分數帳戶餘額低於：</b>{{ $params['share_min'] }}</li>
    <li class="list-group-item"><b>禮券積分帳戶餘額低於：</b>{{ $params['manage_min'] }}</li>
    <li class="list-group-item"><b>需為該會員的邀請人才可申請</b></li>
    <li class="list-group-item"><b>該會員需無任何社群</b></li>
</ul>


<!--確認使用-->
<form id="Form" action="{{ route('front.member.transfer_ownership_record.sms') }}" method="POST">
    <div class="row">
        <div class="col-sm-6">
            <fieldset class="form-group">
                <label>好友<span style="color:red;">(僅顯示符合刪除申請條件的好友)</span></label>
                <select name="delete_member_id" id="subs" class="form-control">
                    <option value="N">請選擇欲刪除好友</option>
                    @foreach($subs as $sub)
                        @if($SubsDeletePresenter->checkIfMemberCanBeDeleted($sub))
                        <option value="{{ $sub->user_id }}">{{ $sub->name }} ({{ $sub->user->username }})</option>
                        @endif
                    @endforeach
                </select>
            </fieldset>  
        </div>
    </div>

    <div id="result">
        <p id="cash"></p>
        <p id="share"></p>
        <p id="manager"></p>
        <p id="last_activity_at"></p>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
    <center>
        <button class="btn btn-primary" type="submit" >確認送出</button>
    </center>
</form>

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
<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var receive = $('#receive').parent();
        var type = 'member';
        $('#subs').select2();
      
        //新增 
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
                } else if (element.attr("name") == "date"  ) {
                    error.insertAfter(".input-group");
                } else {
                    error.insertAfter(element);
                }

            },
            submitHandler: function(form) {
               if($('#subs').val() == 'N'){
                swal("Failed", '請先選擇欲刪除好友', 'error');
                return false;
               }

                sendUri = APP_URL + "/member/{{ $route_code }}" ;
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"POST",function(data){
                    window.location.href = APP_URL + "/member/{{ $route_code }}";
                },function(data){
                    
                });

                
            }
        }); //新增   

       

        //好友切換
        $( "#subs" ).change(function() {
            if($(this).val() == 'N') {
                resetInfo()
            } else {
                setMemberData($(this).val());
            }
            
        });

        //顯示好友基本資訊
        function setMemberData(delete_member_id){

            $.ajax({
                url: APP_URL + "/member/subs_delete_record/sub_info",
                data: {'member_id':delete_member_id},
                type: "GET",
                success: function(msg) {
                    
                    var data = JSON.parse(msg);
                    if (data.result == 1) {
                        $('#cash').html('金幣分數帳戶餘額：'+data.cash);
                        $('#share').html('娛樂分數幣帳戶餘額：'+data.share);
                        $('#manager').html('禮券積分帳戶餘額：'+data.manage);
                        $('#last_activity_at').html('最後活動時間：'+data.last_activity_at);
                    } 
                },
                error: function(xhr) {
                    
                }
            });
        }  

        //清空好友資訊
        function resetInfo(){
            $('#cash').html('');
            $('#share').html('');
            $('#manager').html('');
            $('#last_activity_at').html('');
        }

        
    });
</script>

@stop
