@extends('layouts.master')
@section('head')
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('front/plugins/sweetalert/sweetalert.css') }}">
<!--樹本身的樣式css-->
<link rel="stylesheet" href="{{ asset('front/dist/css/tree.css') }}">
<!-- 打開外部視窗 fancy -->
<link rel="stylesheet" href="{{ asset('admin/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />

<link rel="stylesheet" href="{{ asset('admin/plugins/HoldOn/HoldOn.min.css') }}">

<style>
    @include("front.user_tree.component.tree_css")
</style>
@stop
@section('content')
<!--首頁\重新安置會員頁面-->
@inject('UserPresenter','App\Presenters\Front\UserPresenter')
@inject('MemberLevelPresenter','App\Presenters\Front\MemberLevelPresenter')
<div class="ui inverted segment">
    <div class="ui container" style="text-align:center; padding:60px 0px;">
        <h1 style="color:white">@lang('default.place.replace_member')</h1>
        <div class="ui large breadcrumb">
          <a href="{{ route('member.dashboard.index') }}"  class="section">@lang('default.index')</a>
          <div class="divider"> / </div>
          <a href="{{ route('member.formal_user.index') }}" class="section" >@lang('default.menu.formal_member')</a>
          <div class="divider"> / </div>
          <a class="section">@lang('default.place.replace_member')</a>
        </div>    
    </div>
</div>

<div class="ui container">

    <!--激活對象資訊-->
    <div class="ui stackable three column grid">
        <div class="computer tablet only two wide column"></div>
        <div class="twelve wide column">
            <div class="ui icon message">
                <i class="user icon"></i>
                <div class="content">
                    <p style="font-size:20px;">@lang('default.place.place_member') ： {{ $place_user->username }} ( {{$place_user->name}} )<br>@lang('default.user.member_level')：{{  $MemberLevelPresenter->showMemberLevel($place_user->member_level->id) }} ({{ $place_user->member_level->price_usd }})</p>
                </div>
            </div>
        </div>
        <div class="computer tablet only two wide column"></div>
    </div>
    <!--/激活對象資訊-->
    <!--快速搜尋-->
    <div class="ui stackable three column grid">
        <div class="computer tablet only two wide column"></div>
        <div class="twelve wide column">
            <a class="fancybox fancybox.iframe" href="{{ route('member.quick_replace.index',$record->id) }}"><button class="ui fluid large vk button">@lang('default.place.quick_place')</button></a>
        </div>
        <div class="computer tablet only two wide column"></div>
    </div>
    <!--/快速搜尋-->
    <!--對碰資訊-->
    <div class="ui four column grid">
        <div class="computer only two wide column"></div>
        <div class="six wide computer eight wide tablet column">
            <div class="ui icon message">
                <div class="content">
                    <center>
                        <div class="header">
                            <h2>@lang('default.accounts.kind_left')</h2>
                        </div>
                        <p style="font-size:16px;">@lang('default.accounts.kind_amount') : {{ $kind->left }}
                            <br>@lang('default.accounts.kind_people') : {{ $kind_left_people }}</p>
                    </center>
                </div>
            </div>
        </div>
        <div class="six wide computer eight wide tablet column">
            <div class="ui icon message">
                <div class="content">
                    <center>
                        <div class="header">
                            <h2>@lang('default.accounts.kind_right')</h2>
                        </div>
                        <p style="font-size:16px;">@lang('default.accounts.kind_amount'):{{ $kind->right }}
                            <br>@lang('default.accounts.kind_people'):{{ $kind_right_people }}</p>
                    </center>
                </div>
            </div>
        </div>
        <div class="computer only two wide column"></div>
    </div>
    <!--/對碰資訊-->

    <!--安置樹-->   
    @include("front.user_tree.component.structure")
    <div style="height:200px;">
    </div>


  <form id="Form">
    <!-- 額外資訊 -->
    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="id" name="id" value="{{ $place_user->user_id }}">
    <input type="hidden" id="position" name="position" >
    <input type="hidden" id="parent_id" name="parent_id" >
    <input type="hidden"  name="_method" value="PUT">  
  </form>

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
<script type="text/javascript" src="{{ asset('admin/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script>
  $(document).ready(function() {

    var table  = $("#data_list"); 
    var token=$('input[name="_token"]').val();
    var alert_message = lang.required+"（Required）";
    var id = $("#id").val();
     $(".fancybox").fancybox();

    @include('front.user_tree.component.tree_js')
    //找下線
    function getdata(username,e_id){

      $.ajax({
        url:APP_URL+'/user/place-tree/'+username,
        type : "GET",
        success:function(msg){  

          var data=JSON.parse(msg); 
            
          reBuild(e_id,data.tree)  

       
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
    //安置位置點擊
    $(document).on('click touchstart', '.place-node', function(event){
        arr = $(this).attr('id').split("-");
        if (!$(this).find('p').text()){
          checkplace(arr[0],arr[1]);
        }
    });

    //檢查安置位置
    function checkplace(parent_id,position)
    {
      $.ajax({
          url:APP_URL+"/user/place-check/"+parent_id+'/'+position,
          type : "GET",
          success:function(msg){ 

            $('#parent_id').val(parent_id);
            $('#position').val(position);
                 
            if (msg == 1) {

              //可以安置，呼叫送出function
              placeConfirm(parent_id,position);

            } else {
              
              //被其他人佔掉了
              swal({   
                  title: "Failed!",   
                  text: lang.already_place,   
                  type: "waring",    
                  confirmButtonText: "OK",   
                }, 
                function(){
                  window.location.reload();
              });
            }
                                
          },
          error:function(xhr){
            swal("Failed",lang.system_error,'error');
          }
        }); 
           
    }

    //確認安置
    function placeConfirm(parent_id,position)
    {

      swal({   
        title: lang.action_confirm,   
        text: lang.replace_member,   
        type: "warning",   
        showCancelButton: true,    
        confirmButtonText: lang.confirm, 
        cancelButtonText: lang.cancel,   
        closeOnConfirm: false,
        showLoaderOnConfirm: true }, 
        function(){
          $.ajax({
            url:APP_URL+"/user/replace/"+id,
            data:$('#Form').serialize(),
            type : "PUT",
            success:function(msg){  
     
              var data=JSON.parse(msg);   

              if(data.result==1)
              {  
                swal({   
                    title: "Success!",   
                    text: data.text,   
                    type: "success",    
                    confirmButtonText: "OK",   
                  }, 
                  function(){
                    window.location.href = APP_URL+"/user/formal";
                });
              }
              else
              {
                swal("Failed", data.text,'error');
              }                           
            },
            error:function(xhr){
              console.log(xhr);
              swal("Failed",lang.system_error,'error');
            }
          }); 
        });
      
    }      

  });
</script>
@stop