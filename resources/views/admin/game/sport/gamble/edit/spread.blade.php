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
    <h3>編輯賭盤類型：{{ config('game.sport.game.sport_types.'.$type) }}</h3>
    <h4>賽程資訊</h4>
    <div class="row">
        <div class="col-sm-6">
            <ul class="list-group">  
                <li class="list-group-item"><b>主隊： </b>{{ $home_team->name }} ｜  分數：{{ $home_team->score }}</li>
                <li class="list-group-item"><b>客隊： </b>{{ $away_team->name }} ｜  分數：{{ $away_team->score }}</li>
            </ul>
        </div>
        <div class="col-sm-6">
            <ul class="list-group">  
                <li class="list-group-item"><b>賽程狀態： </b>{!! config('game.sport.status.'.$sport->status) !!}</li>
                <li class="list-group-item"><b>比賽時間： </b>
                    <br>{{ $sport->start_datetime }}[當地]
                    <br>{{ $sport->taiwan_datetime }}[台灣]
                </li>
            </ul>
        </div>
    </div>
    <form id="Form">
        <h4>參數</h4>
        <div class="row">
            <div class="col-md-3">
                <fieldset class="form-group" >
                    <label for="dead_heat_point">平局點*</label>
                    <input type="number" class="form-control" name="dead_heat_point" id="dead_heat_point" min='0' value="@if($detail->dead_heat_point){{ $detail->dead_heat_point }}@endif" required>
                </fieldset>
            </div>
            <div class="col-md-3">
                <fieldset class="form-group"  >
                    <label for="real_bet_ratio">平局有效下注比例(%)*</label>
                    <input type="number" class="form-control" name="real_bet_ratio" id="real_bet_ratio"  min="-100" max="100" value="@if($detail->real_bet_ratio){{ $detail->real_bet_ratio*100 }}@endif" required>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <fieldset class="form-group">
                    <label for="dead_heat_team_id">讓分基準隊伍*</label>
                    <select class="form-control" id="dead_heat_team_id" name="dead_heat_team_id">
                        <option value="N" >請選擇隊伍</option>
                        <option value="{{ $home_team->id }}" @if($detail->dead_heat_team_id == $home_team->id) selected @endif>{{ $home_team->name }}</option>
                        <option value="{{ $away_team->id }}" @if($detail->dead_heat_team_id == $away_team->id) selected @endif>{{ $away_team->name }}</option>
                    </select>
                </fieldset>
            </div>
            <div class="col-md-3">
                <fieldset class="form-group"  >
                    <label for="spread_one_side_bet">讓分的單邊下注值*   (<span style="color:red;">輸入0 : 沒有單邊下注額限制</span>)</label>
                    @if($detail->spread_one_side_bet)
                    <input type="number" class="form-control" name="spread_one_side_bet" id="spread_one_side_bet"  value="{{ $detail->spread_one_side_bet }}" required>
                    @else
                    <input type="number" class="form-control" name="spread_one_side_bet" id="spread_one_side_bet"  value="0" required>
                    @endif  
                </fieldset>
            </div>
        </div>
        <h4>賠率</h4>
        <div class="row">
            <div class="col-md-3">
                <fieldset class="form-group" >
                    <label for="adjust_line">調整賠率(%)*</label>
                    @if($detail->adjust_line)
                    <input type="number" class="form-control" name="adjust_line" id="adjust_line" min='-100' max="100" value="{{ $detail->adjust_line*100 }}" required>
                    @else
                    <input type="number" class="form-control" name="adjust_line" id="adjust_line" min='-100' max="100" value="0" required>
                    @endif
                </fieldset>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <fieldset class="form-group" >
                    <label for="home_line">[主]原始賠率(%)*</label>
                    <input type="number" class="form-control" name="home_line" id="home_line" min='0' max="100"  value="@if($detail->home_line){{ $detail->home_line*100 }}@endif" required>
                </fieldset>
                <fieldset class="form-group" >
                    <label for="current_line">[主]網站顯示賠率(%)  --自動計算</label>
                    <input type="number" class="form-control"  id="over_current_line" value="90"  readonly>
                </fieldset>
            </div>
            <div class="col-md-3">
                <fieldset class="form-group" >
                    <label for="line">[客]原始賠率(%)*</label>
                    <input type="number" class="form-control" name="away_line" id="away_line" min='0' max="100" value="@if($detail->away_line){{ $detail->away_line*100 }}@endif" required>
                </fieldset>
                <fieldset class="form-group" >
                    <label for="current_line">[客]網站顯示賠率(%)  --自動計算</label>
                    <input type="number" class="form-control"  id="under_current_line" value="90"  readonly>
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
        var over_current_line = $('#over_current_line');
        var under_current_line = $('#under_current_line');
        countCurrentLine()    

        //改變賠率調整參數
        $("#adjust_line").change(function(){
            countCurrentLine()    
        });

        //改變原始賠率
        $("#home_line").change(function(){
            countCurrentLine()    
        });
        $("#away_line").change(function(){
            countCurrentLine()    
        });

        //計算顯示賠率
        function countCurrentLine(){
            var home_line = parseInt($('#home_line').val());
            var away_line = parseInt($('#away_line').val());
            var adjust = parseInt($('#adjust_line').val());
            over_current_line.val(home_line+adjust);
            under_current_line.val(away_line+adjust);
        }
        //表單驗證 
        $("#Form").validate({
            ignore: [],
            rules: {
                dead_heat_team_id: { notEqual: "N" }
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

        //檢查是否有選隊伍
        jQuery.validator.addMethod("notEqual", function(value, element, param) {
          return this.optional(element) || value != param;
        }, "請選擇隊伍");
                
    });
</script>
@stop