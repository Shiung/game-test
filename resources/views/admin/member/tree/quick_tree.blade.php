@extends('layouts.form')
@section('head')
<!--SEMANTIC CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('front/semantic/semantic.css') }}">
<!-- Bootstrap 3.3.5 -->
<!--
<link rel="stylesheet" href="{{ asset('front/bootstrap/css/bootstrap.min.css') }}">
-->
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('front/dist/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('front/dist/css/tree.css') }}">
<!--odometer-->
<link rel="stylesheet" href="{{ asset('front/plugins/odometer/themes/odometer-theme-train-station.css') }}" />
<!--countUp-->
<script src="{{ asset('front/plugins/countUp/countUp.js') }}"></script>
<style>
    @import url("{{ asset('front/dist/css/desktop.css') }}") screen and (min-width:1201px);
    @import url("{{ asset('front/dist/css/laptop.css') }}") screen and (min-width:992px)and (max-width:1200px);
    @import url("{{ asset('front/dist/css/tablet.css') }}") screen and (min-width:768px)and (max-width:991px);
    @import url("{{ asset('front/dist/css/tablet-s.css') }}") screen and (min-width:481px)and (max-width:767px);
    @import url("{{ asset('front/dist/css/mobile.css') }}") screen and (max-width:480px);
    
</style>
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('front/plugins/sweetalert/sweetalert.css') }}">

<link rel="stylesheet" href="{{ asset('admin/plugins/HoldOn/HoldOn.min.css') }}">

<style>
    @include("front.user_tree.component.tree_css")
</style>
@stop
@section('content')
<!--首頁\快速安置會員頁面-->

<div class="ui container">

    <!--本人資訊-->
    <div class="ui message">
        <div class="content">
           
            <div class="ui form">
                <div class="inline fields">
                    <div class="eight wide field">
                        <div class="ui blue segment" style="width:100%; text-align:center;">
                            <center>
                                <h2>@lang('default.accounts.kind_left')</h2>
                                <p style="font-size:16px;">@lang('default.accounts.kind_amount') : {{ $kind->left }}<br>@lang('default.accounts.kind_people') : {{ $kind_left_people }}</p>
                            </center>
                        </div>
                    </div>
                    <div class="eight wide field">
                        <div class="ui blue segment" style="width:100%; text-align:center;">
                            <center>
                                <h2>@lang('default.accounts.kind_right')</h2>
                                <p style="font-size:16px;">@lang('default.accounts.kind_amount'):{{ $kind->right }}<br>@lang('default.accounts.kind_people'):{{ $kind_right_people }}</p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/本人資訊-->

    <!--搜索-->
    <div class="ui message">
        <p>@lang('default.place.quick_place')</p>
        <div class="ui fluid action input">
            <input type="text" name="username" id="username" placeholder="@lang('default.place.enter_username')">
            <button id="search" class="ui button">@lang('default.action.search')</button>
        </div>
        <br>
        <div id="result">
          <h3>@lang('default.place.search_result')</h3>
            @if($root)
          <table class="ui blue table">
            <tr>
              <th>@lang('default.place.member')</th>
              <th>@lang('default.place.position')</th>
              <th>@lang('default.place.level')</th>
            </tr>
            
            <tr>
                <td id="result-name">{{ $search_user['name'] }}</td>
                <td id="result-kind">{{ $search_user['kind'] }}</td>
                <td id="result-level">{{ $search_user['level'] }}</td>
            </tr>
            
          </table>
          @else
            No Result
          @endif
        </div>
    </div>
    <!--/搜索-->
    @if($root)
    <!--安置樹-->   
    @include("front.user_tree.component.structure")
    @endif
    <div style="height:200px;">
    </div>

</div><!-- /.ui container -->
@stop
@section('footer-js')
<!-- Alert-->
<script src="{{ asset('admin/plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('front/plugins/validate/jquery.validate.min.js') }}"></script>
<!-- tree-->
<script src="{{ asset('front/plugins/treant/Treant.js') }}"></script>
<script src="{{ asset('front/plugins/treant/vendor/raphael.js') }}"></script>

<script src="{{ asset('admin/plugins/HoldOn/HoldOn.min.js') }}"></script>
<script>
  $(document).ready(function() {

    var table  = $("#data_list"); 
    var token=$('input[name="_token"]').val();
    var alert_message = "必填（Required）";
    var id = $("#id").val();
    @include('front.user_tree.component.tree_js')
      
    //找下線
    function getdata(username,e_id){

      $.ajax({
        url:APP_URL+'/user/place-tree/'+username,
        type : "GET",
        success:function(msg){  

          var result=JSON.parse(msg); 
            
          if (result.result == 1) {
            reBuild(e_id,result.tree)  

            //搜尋結果
            $('#result #result-name').text(result.user.name);
            if (result.user.kind == 'L') {
              kind = lang.kind_left;
            } else {
              kind = lang.kind_right;
            }
            $('#result #result-kind').text(kind);
            $('#result #result-level').text(result.user.level);

          } else {

            swal("Failed",lang.can_not_find_your_tree_member,'error');

            //結果清空
            $('#result #result-name').text('');
            $('#result #result-kind').text('');
            $('#result #result-level').text('');

          }

        HoldOn.close();               
        },
        beforeSend:function(){
            //顯示搜尋動畫
            HoldOn.open({
                theme:'sk-cube-grid',
                message:"<h4>Loading...</h4>"
            });
          },
        error:function(xhr){
          swal("Failed",lang.system_error,'error');
        }
      });
    }


    //點擊搜尋
    $(document).on('click', '#search', function(event){
        //alert($('#username').val());
        username = $('#username').val();

        //檢查是否有輸入
        if (!$('#username').val()) {
          swal("Failed",lang.please_enter_username,'error');
          return false;
        }
        //檢查帳號長度
        if (username.length < 2) {
          swal("Failed",lang.username_error,'error');
          return false;
        }

        //檢查是否包含%
        if (username.match('%')) {
          swal("Failed",lang.username_error,'error');
          return false;
        }

        window.location.href=APP_URL+'/user/quick-tree/'+username;
    });

    
  });
</script>
@stop