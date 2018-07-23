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
            <div class="col-md-6">
                <h3>主隊-{{ $home_team->name }}</h3>
                <fieldset class="form-group" >
                    <label for="hometeam_score">主隊分數*</label>
                    <input type="number" class="form-control" name="hometeam_score" id="hometeam_score" min="0"  value="{{ $home_team->score }}" required>
                </fieldset>
            </div>
            <div class="col-md-6">
                <h3>客隊-{{ $away_team->name }}</h3>
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

<script>
    $(document).ready(function() {

        var category_id = $('#category_id').val()
        var id = $('#id').val()


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


                sendUri = APP_URL + "/game/{{ $route_code }}/score/"+id;
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"PUT",function(data){
                    window.location.href = APP_URL + "/game/{{ $route_code }}/latest/"+category_id;
                });

                
            }
        }); //submit
        
    });
</script>
@stop