@extends('layouts.admin') 
@section('head')

<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<!-- datetimepicker -->
<link rel="stylesheet" href="{{ asset('plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}"> 
@stop 
@section('content-header',$page_title) 
@section('content')
<div class="box-header with-border">
    <ol class="breadcrumb">
        <li>{{ $page_title }}</li>
        <li class="active">編輯賽程-{{ $data->id }}</li>
    </ol>
    <!-- 上一頁 -->
    <div class="text-left">
        <a href="{{ route('admin.game.'.$route_code.'.index',$category_id) }}"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="回上一頁"><i class="fa fa-fw fa-reply"></i></button></a>
    </div>
</div>
<div class="box-body" >
    <form id="Form">
        <div class="row">
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="taiwan_datetime">比賽開始時間（台灣時間）*</label>
                    <input size="16" type="text" value="{{ $data->taiwan_datetime }}"  name="taiwan_datetime" id="taiwan_datetime"  readonly  class="form-control form_datetime">
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="start_datetime">比賽開始時間*</label>
                    <input size="16" type="text" value="{{ $data->start_datetime }}" name="start_datetime" id="start_datetime"  readonly class="form-control form_datetime">
                
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group" >
                    <label for="status">賽程狀態*</label>
                    <select class="form-control" id="status" name="status">
                        <option value="Scheduled" @if($data->status == "Scheduled") selected @endif>尚未開始</option>
                        <option value="InProgress" @if($data->status == "InProgress") selected @endif>進行中</option>
                        <option value="Final" @if($data->status == "Final") selected @endif>已結束</option>
                        <option value="Suspended" @if($data->status == "Suspended") selected @endif>暫停</option>
                        <option value="Postponed" @if($data->status == "Postponed") selected @endif>延期</option>
                        <option value="Canceled" @if($data->status == "Canceled") selected @endif>取消</option>
                    </select>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h3>主隊資訊</h3>
                <fieldset class="form-group" >
                    <label for="hometeam_name">主隊名稱*</label>
                    <input type="text" class="form-control" name="hometeam_name" id="hometeam_name" value="{{ $home_team->name }}"  required>
                </fieldset>
                <fieldset class="form-group" >
                    <label for="hometeam_score">主隊分數*</label>
                    <input type="number" class="form-control" name="hometeam_score" id="hometeam_score" min="0"  value="{{ $home_team->score }}" required>
                </fieldset>
            </div>
            <div class="col-md-6">
                <h3>客隊資訊</h3>
                <fieldset class="form-group"  >
                    <label for="awayteam_name">客隊名稱*</label>
                    <input type="text" class="form-control" name="awayteam_name" id="awayteam_name" value="{{ $away_team->name }}" required>
                </fieldset>
                <fieldset class="form-group" >
                    <label for="awayteam_score">客隊分數*</label>
                    <input type="number" class="form-control" name="awayteam_score" id="awayteam_score" min="0"  value="{{ $away_team->score }}" required>
                </fieldset>
            </div>
        </div>
        

        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))                
        <!-- 額外資訊 -->
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="category_id" name="category_id" value="{{ $category_id }}">
        <input type="hidden" id="awayteam_id" name="awayteam_id" value="{{ $away_team->id }}">
        <input type="hidden" id="hometeam_id" name="hometeam_id" value="{{ $home_team->id }}">
        <input type="hidden" id="id" name="id" value="{{ $data->id }}">
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
<!-- datetimepicker -->
<script src="{{ asset('plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    $(document).ready(function() {

        var category_id = $('#category_id').val()
        var id = $('#id').val()
        <?php 
        date_default_timezone_set("America/New_York");
        ?>
        var dst = '{{ date("I") }}';
        var timezone = '{{ $category->timezone }}';
        var timezone_summer = '{{ $category->timezone_summer }}';

        $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});

        //夏日節約時間，
        $( "#taiwan_datetime" ).change(function() {
            start_datetime = getDatetimeFormat($(this).val())
            $("#start_datetime").val(start_datetime)
        });

        //自動換算時間
        function getDatetimeFormat(taiwan_datetime){
            stringArray = taiwan_datetime.split(" ");
            new_date = stringArray[0]+'T'+stringArray[1]+':00Z' ;
            startDate = new Date(new_date);
            var dateMsec = startDate.getTime();
            if(dst == '0'){
                compare_timezone = timezone;
            } else {
                compare_timezone = timezone_summer;
            } 
            new_msec = dateMsec + parseInt(compare_timezone)*3600000 - (3600000*8) ;
            var date = new Date(new_msec);
            myDate = date.toString();
            return date.getFullYear()+'-'+('0' + (date.getMonth()+1)).slice(-2) + "-" +  ('0' + date.getDate()).slice(-2) + " " + date.getHours() + ":" + date.getMinutes();
        }


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


                sendUri = APP_URL + "/game/{{ $route_code }}/"+id;
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"PUT",function(data){
                    window.location.href = APP_URL + "/game/{{ $route_code }}/latest/"+category_id;
                });

                
            }
        }); //submit
        
    });
</script>
@stop