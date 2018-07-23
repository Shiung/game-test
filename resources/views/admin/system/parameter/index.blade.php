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
        <h4>網站開放設置</h4>
        <div class="row">
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="web_status">前台網站狀態</label>
                   <select class="form-control"  name="parameters[web_status]" >
                        <option value="1" @if($parameters['web_status'] == '1')  selected @endif>開啟</option>
                        <option value="0" @if($parameters['web_status'] == '0')  selected @endif>關閉</option>
                    </select>
                </fieldset>
            </div>
            <div class="col-sm-3" >
                <fieldset class="form-group">
                   <label for="maintenance_start">維修開始時間（自動關閉網站）</label>
                   <input type="text" class="form-control datetimepicker"   name="parameters[maintenance_start]" value="{{ $parameters['maintenance_start'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3" >
                <fieldset class="form-group" >
                   <label for="maintenance_end">維修結束時間（自動開啟網站）</label>
                   <input type="text" class="form-control datetimepicker"   name="parameters[maintenance_end]" value="{{ $parameters['maintenance_end'] }}" required>
                </fieldset>
            </div>
        </div>
        <h4>基本設置</h4>
        <div class="row">
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="sms_expire_second">簡訊認證幾秒過期</label>
                   <input type="number" class="form-control"  min="10"  name="parameters[sms_expire_second]" value="{{ $parameters['sms_expire_second'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="tree_parent">安置樹一代幾個 </label>
                   <input type="number" class="form-control"  min="1"  name="parameters[tree_parent]" value="{{ $parameters['tree_parent'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="bet_status_closetime">賽程開始前幾分鐘關閉下注 </label>
                   <input type="number" class="form-control"  min="1"  name="parameters[bet_status_closetime]" value="{{ $parameters['bet_status_closetime'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="bet_opentime">結算時間</label>
                   <input type="text" class="form-control datetimepicker" name="parameters[bet_opentime]" value="{{ $parameters['bet_opentime'] }}"  required>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="block_member_period">會員幾天沒使用封鎖</label>
                   <input type="number" class="form-control"  min="1"  name="parameters[block_member_period]" value="{{ $parameters['block_member_period'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="search_parent_limit">明細搜尋最多搜尋幾代 </label>
                   <input type="number" class="form-control"  min="1"  name="parameters[search_parent_limit]" value="{{ $parameters['search_parent_limit'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="tree_subs_total_show">社群樹顯示幾代人數總額 </label>
                   <input type="number" class="form-control"  min="1"  name="parameters[tree_subs_total_show]" value="{{ $parameters['tree_subs_total_show'] }}" required>
                </fieldset>
            </div>
        </div>
        <h4>彩球539</h4>
        <div class="row">
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="one_ratio_539">539中一顆賠率 </label>
                   <input type="number" class="form-control"  min="1"  name="parameters[one_ratio_539]" value="{{ $parameters['one_ratio_539'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="two_ratio_539">539中兩顆賠率 </label>
                   <input type="number" class="form-control"  min="1"  name="parameters[two_ratio_539]" value="{{ $parameters['two_ratio_539'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="three_ratio_539">539中三顆賠率</label>
                   <input type="number" class="form-control"  min="1"  name="parameters[three_ratio_539]" value="{{ $parameters['three_ratio_539'] }}" required>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="sport_starttime_539">539開獎時間</label>
                   <input type="text" class="form-control"    name="parameters[sport_starttime_539]" value="{{ $parameters['sport_starttime_539'] }}"  required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="sport_game_starttime_539">539新增賽程開始時間(自動開始下注)</label>
                   <input type="text" class="form-control datetimepicker"   name="parameters[sport_game_starttime_539]" value="{{ $parameters['sport_game_starttime_539'] }}" required>
                </fieldset>
            </div>
            
        </div>
        <h4>象棋</h4>
        <div class="row">
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="cn_chess_one_ratio">象棋中一顆賠率 </label>
                   <input type="number" class="form-control"   name="parameters[cn_chess_one_ratio]" value="{{ $parameters['cn_chess_one_ratio'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="cn_chess_two_ratio">象棋中兩顆賠率 </label>
                   <input type="number" class="form-control"   name="parameters[cn_chess_two_ratio]" value="{{ $parameters['cn_chess_two_ratio'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="cn_chess_virtual_cash_ratio">象棋金幣中兩顆加碼</label>
                   <input type="number" class="form-control"   name="parameters[cn_chess_virtual_cash_ratio]" value="{{ $parameters['cn_chess_virtual_cash_ratio'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="cn_chess_share_ratio">象棋娛樂幣中兩顆加碼</label>
                   <input type="number" class="form-control"   name="parameters[cn_chess_share_ratio]" value="{{ $parameters['cn_chess_share_ratio'] }}" required>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="cn_chess_red_ratio">象棋紅多賠率率 </label>
                   <input type="number" class="form-control"   name="parameters[cn_chess_red_ratio]" value="{{ $parameters['cn_chess_red_ratio'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="cn_chess_black_ratio">象棋黑多賠率 </label>
                   <input type="number" class="form-control"    name="parameters[cn_chess_black_ratio]" value="{{ $parameters['cn_chess_black_ratio'] }}" required >
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="cn_chess_interval">幾分鐘一局 (<span style="color:red">需可以被60整除</span>)</label>
                   <select name="parameters[cn_chess_interval]" class="form-control" id="cn_chess_interval" @if($parameters['web_status'] == '1')  disabled @endif>
                      <option value="1" @if($parameters['cn_chess_interval'] == '1') selected @endif>1</option>
                      <option value="2" @if($parameters['cn_chess_interval'] == '2') selected @endif>2</option>
                      <option value="3" @if($parameters['cn_chess_interval'] == '3') selected @endif>3</option>
                      <option value="4" @if($parameters['cn_chess_interval'] == '4') selected @endif>4</option>
                      <option value="5" @if($parameters['cn_chess_interval'] == '5') selected @endif>5</option>
                      <option value="6" @if($parameters['cn_chess_interval'] == '6') selected @endif>6</option>
                      <option value="10" @if($parameters['cn_chess_interval'] == '10') selected @endif>10</option>
                      <option value="12" @if($parameters['cn_chess_interval'] == '12') selected @endif>12</option>
                      <option value="15" @if($parameters['cn_chess_interval'] == '15') selected @endif>15</option>
                      <option value="20" @if($parameters['cn_chess_interval'] == '20') selected @endif>20</option>
                      <option value="30" @if($parameters['cn_chess_interval'] == '30') selected @endif>30</option>
                      <option value="60" @if($parameters['cn_chess_interval'] == '60') selected @endif>60</option>
                   </select>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="cn_chess_resttime">每局一開始的休息秒數(<span style="color:red">請勿大於 幾分鐘一局*60 </span>)</label>
                   <input type="number" class="form-control" id="cn_chess_resttime"  name="parameters[cn_chess_resttime]" value="{{ $parameters['cn_chess_resttime'] }}" max="{{ $parameters['cn_chess_interval']*60 }}" required @if($parameters['web_status'] == '1')   disabled @endif>
                </fieldset>
            </div>
        </div>

        <h4>投注獎金</h4>
        <div class="row">
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="bet_bonus_interest">投注獎金利率 </label>
                   <input type="number" class="form-control"   name="parameters[bet_bonus_interest]" value="{{ $parameters['bet_bonus_interest'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="bet_bonus_level">投注獎金代數（不含自己）</label>
                   <input type="number" class="form-control"  min="1"  name="parameters[bet_bonus_level]" value="{{ $parameters['bet_bonus_level'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="bet_bonus_period">投注獎金保留天數</label>
                   <input type="number" class="form-control"  min="1"  name="parameters[bet_bonus_period]" value="{{ $parameters['bet_bonus_period'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="monthly_bet_schedule">每月投注獎金執行日期 (每月幾號) </label>
                   <input type="number" class="form-control"  min="1"  name="parameters[monthly_bet_schedule]" value="{{ $parameters['monthly_bet_schedule'] }}" required>
                </fieldset>
            </div>
        </div>
        <h4>利息</h4>
        <div class="row">
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="daily_interest_schedule">每日利息排程時間 </label>
                   <input type="text" class="form-control datetimepicker"   name="parameters[daily_interest_schedule]" value="{{ $parameters['daily_interest_schedule'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="interest_cleartime">每日利息帳戶清空時間</label>
                   <input type="text" class="form-control datetimepicker"  name="parameters[interest_cleartime]" value="{{ $parameters['interest_cleartime'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="daily_interest_max">娛幣產出紅利最高上限值</label>
                   <input type="number" class="form-control"  name="parameters[daily_interest_max]" value="{{ $parameters['daily_interest_max'] }}" required>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="tree_bonus_interest">組織利息利率 </label>
                   <input type="number" class="form-control"   name="parameters[tree_bonus_interest]" value="{{ $parameters['tree_bonus_interest'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="tree_bonus_level">組織利息代數（不含自己）</label>
                   <input type="number" class="form-control"  min="1"  name="parameters[tree_bonus_level]" value="{{ $parameters['tree_bonus_level'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="tree_bonus_period">組織利息保留天數 </label>
                   <input type="number" class="form-control"  min="1"  name="parameters[tree_bonus_period]" value="{{ $parameters['tree_bonus_period'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="monthly_tree_scheduled">每月組織利息執行日期 (每月幾號) </label>
                   <input type="number" class="form-control"  min="1"  name="parameters[monthly_tree_schedule]" value="{{ $parameters['monthly_tree_schedule'] }}" required>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="recommend_bonus_interest">親推利息利率 </label>
                   <input type="number" class="form-control"    name="parameters[recommend_bonus_interest]" value="{{ $parameters['recommend_bonus_interest'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="recommend_bonus_period">親推利息保留天數</label>
                   <input type="number" class="form-control"  min="1"  name="parameters[recommend_bonus_period]" value="{{ $parameters['recommend_bonus_period'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="daily_interest_period">每日利息保留天數</label>
                   <input type="number" class="form-control"  min="1"  name="parameters[daily_interest_period]" value="{{ $parameters['daily_interest_period'] }}" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="daily_recommend_schedule">每日親推利息排程時間</label>
                   <input type="text" class="form-control datetimepicker"    name="parameters[daily_recommend_schedule]" value="{{ $parameters['daily_recommend_schedule'] }}" required>
                </fieldset>
            </div>
        </div>

        <h4>交易平台</h4>
        <div class="row">
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="share_transaction_fee_percent">手續費 </label>
                   <input type="number" class="form-control"   name="parameters[share_transaction_fee_percent]" value="{{ $parameters['share_transaction_fee_percent'] }}" min="0" max="1" required>
                </fieldset>
            </div>
            <div class="col-sm-3">
                <fieldset class="form-group">
                   <label for="share_transaction_expire_day">掛單過期天數</label>
                   <input type="number" class="form-control"  name="parameters[share_transaction_expire_day]" value="{{ $parameters['share_transaction_expire_day'] }}" min="1" required>
                </fieldset>
            </div>
        </div>

        <h4>會員刪除</h4>
        <div class="row">
          <div class="col-sm-3">
              <fieldset class="form-group">
                 <label for="sub_delete_cash_min">現金帳戶餘額需小於</label>
                 <input type="number" class="form-control"  min="1"  name="parameters[sub_delete_cash_min]" value="{{ $parameters['sub_delete_cash_min'] }}" required>
              </fieldset>
          </div>
          <div class="col-sm-3">
              <fieldset class="form-group">
                 <label for="sub_delete_share_min">娛樂幣帳戶餘額需小於</label>
                 <input type="number" class="form-control"  min="1"  name="parameters[sub_delete_share_min]" value="{{ $parameters['sub_delete_share_min'] }}" required>
              </fieldset>
          </div>
          <div class="col-sm-3">
              <fieldset class="form-group">
                 <label for="sub_delete_manage_min">禮券帳戶餘額需小於</label>
                 <input type="number" class="form-control"  min="1"  name="parameters[sub_delete_manage_min]" value="{{ $parameters['sub_delete_manage_min'] }}" required>
              </fieldset>
          </div>
        </div>

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
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/timepicker/jquery.timepicker.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-confirm/jquery.confirm.min.js') }}"></script>
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>

<script>
    $(document).ready(function() {

        $('.datetimepicker').timepicker({ 'timeFormat': 'H:i' });

        $( "#cn_chess_interval" ).change(function() {
            $('#cn_chess_resttime').attr('max',$(this).val()*60);
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