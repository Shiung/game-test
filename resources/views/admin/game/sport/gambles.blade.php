@extends('layouts.admin') 
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />

@stop 
@section('content-header',$page_title) 
@section('content')
@inject('SportPresenter','App\Presenters\Game\SportPresenter')
<div class="box-header with-border">
    <ol class="breadcrumb">
        <li>{{ $page_title }}</li>
        <li class="active">賭盤列表</li>
    </ol>
</div>

<div class="box-body" >

    <form id="Form" style="margin-bottom:20px;">
        <label for="range">時間區間查詢單位：賭盤新增時間</label>
        <div class="row">
            <div class="col-sm-10">
                <div class="input-group">
                    <input type="date" class="form-control" name="start" id="start" value="{{ $start }}">
                    <span class="input-group-addon">~</span>
                    <input type="date" class="form-control" name="end" id="end" value="{{ $end }}">
                </div>
            </div>
            <div class="col-sm-2">
                <input type="button" class="btn btn-info btn-block" id="search" value="查詢" >
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table id="data_list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>賽程編號</th>
                    <th>賽程狀態</th>
                    <th>賭盤類型</th>
                    <th>賭盤內容</th>
                    <th>賭盤狀態</th>  
                    <th>下注狀況</th>  
                    <th>新增時間</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>#{{ $data->sport_id}}</td>
                    <td>{!! config('game.sport.status.'.$data->sport->status) !!}</td>
                    <td>{{ config('game.sport.game.type.'.$data->type) }}</td>
                    <td>
                        {!! $SportPresenter->showGameSummary($data) !!}
                    </td>
                    <td>
                        @if($SportPresenter->checkParameterComplete($data->type,$data))
                        <!--如果賭盤狀態是開放or關閉才能更動-->
                        <select 
                            class="form-control change_bet_status"
                            id="bet_status_{{ $data->id }}" 
                            data-id="{{ $data->id  }}" 
                            data-type="{{ config('game.sport.game.type.'.$data->type) }}"
                            @if($data->bet_status > 1 ) disabled  @endif>
                            <option value="0" @if($data->bet_status == "0") selected @endif>{!! config('game.sport.game.bet_status.'.'0') !!}</option>
                            <option value="1" @if($data->bet_status == "1") selected @endif>{!! config('game.sport.game.bet_status.'.'1') !!}</option>
                            @if($data->bet_status > 1)
                            <option value="2" @if($data->bet_status == "2") selected @endif>{!! config('game.sport.game.bet_status.'.'2') !!}</option>
                            <option value="3" @if($data->bet_status == "3") selected @endif>{!! config('game.sport.game.bet_status.'.'3') !!}</option>
                            @endif
                        </select>
                        @else
                        關閉中，請先完整設定賭盤參數
                        @endif
                    </td>
                    <td>
                        {!! $SportPresenter->showBetTotal($data) !!}
                    </td>
                    <td>
                        {{ $data->created_at }}
                    </td>
                    <td>
                        <a href="{{ route('admin.game.'.$route_code.'.gamble.show',$data->id) }}" class="fancybox fancybox.iframe"><button class="btn btn-info btn-sm"  data-toggle="tooltip" title="瀏覽" ><i class="fa fa-eye"></i></button></a>
                        <!--下注明細
                        <a href="{{ route('admin.game.'.$route_code.'.gamble.bet_record',$data->id) }}" class="fancybox fancybox.iframe"><button class="btn btn-warning btn-sm"  data-toggle="tooltip" title="下注明細" ><i class="fa fa-trophy"></i></button></a>
                        -->
                         @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))
                            <a href="{{ route('admin.game.'.$route_code.'.gamble.edit',$data->id) }}" class="fancybox fancybox.iframe"><button class="btn btn-primary btn-sm"  data-toggle="tooltip" title="編輯" ><i class="fa fa-pencil-square-o"></i></button></a>
                       
                            @if($data->bet_status == 0 && $data->bets->count() == 0)
                            <!--沒有開放下注才能刪除-->
                            <button class="btn btn-danger btn-sm delete" data-toggle="tooltip" title="刪除" data-id="{{ $data->id }}" data-name="{{ $data->title }}"><i class="fa fa-trash"></i></button>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- /.box-body -->
<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
<input type="hidden" id="category_id" value="{{ $category_id }}"> 
@stop 
@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-confirm/jquery.confirm.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>

<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var table = $("#data_list");
        var category_id = $("#category_id").val();
        $(".fancybox").fancybox();

        $("#data_list").DataTable({
            "order": [
                [6, "desc"]
            ],
            "paging": true,
            "searching": true
        });


        //選擇賭盤類型
        $( "#select_type" ).click(function() {
            window.location.href = APP_URL + "/game/{{ $route_code }}/gamble/create/"+sport_id+'/'+$('#game_type').val();
        });

        //刪除   
        table.on("click", ".delete", function(e) {

            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');

            //確認訊息
            $.confirm({
                text: "確認刪除 " + name + " ?",
                confirm: function(button) {
                    
                    sendUri = APP_URL + "/game/{{ $route_code }}/gamble/" + id;
                    sendData = { '_token': token,'_method': 'DELETE'};
                    system_ajax(sendUri,sendData,"DELETE",function(data){
                        window.location.reload();
                    });
                    
                },
                cancel: function(button) {},
                confirmButton: "確認",
                cancelButton: "取消"
            }); //.確認訊息
        });//.刪除

        //改變下注狀態
        $(".change_bet_status").focus(function () {    
            previous = this.value;
        }).change(function() {
            var id = $(this).data('id');
            var name = $(this).data('type');
            var bet_status = $(this).val();
            var selected = $(this);

            //確認訊息
            $.confirm({
                text: "確認改變 " + name + "賭盤狀態 ?",
                confirm: function(button) {
                    
                    $.ajax({
                        url: APP_URL + "/game/{{ $route_code }}/gamble/change-status/" + id,
                        data:  { '_token': token,'_method': 'PUT','bet_status':bet_status},
                        type: "PUT",
                        success: function(msg) {
                            HoldOn.close();
                            var data = JSON.parse(msg);
                            console.log(msg);
                            if (data.result == 1) {
                                swal({
                                    title: "Success!",
                                    text: data.text,
                                    type: "success",
                                    confirmButtonText: "確認",
                                },function(){
                                    previous = this.value;
                                    window.location.reload();
                                });

                            } else {
                                swal({
                                    title: "Failed",
                                    text: data.text,
                                    type: "error",
                                    confirmButtonText: "確認",
                                },function(){
                
                                    window.location.reload();
                                });
                            }
                        },
                        beforeSend: function() {
                            //顯示搜尋動畫
                            HoldOn.open({
                                theme: 'sk-cube-grid',
                                message: "<h4>系統處理中，請勿關閉視窗</h4>"
                            });
                        },
                        error: function(xhr) {
                            HoldOn.close();
                            swal("Error", "系統發生錯誤，請聯繫工程人員", 'error');
                            console.log(xhr);
                        }
                    });
                    
                },
                cancel: function(button) {
                    selected.val(previous)

                },
                confirmButton: "確認",
                cancelButton: "取消"
            }); //.確認訊息
            
            
        });
        

        //搜尋區間範圍
        $("#search").click(function(){
            start = $('#start').val();
            end = $('#end').val();

            if (Date.parse(start) > Date.parse(end) ) {
                swal("Error", "日期範圍有誤，請重新輸入!", 'error');
                return false;
            }

            if (!$('#start').val() || !$('#end').val()) {
                swal("Error", "請輸入完整搜尋日期!", 'error');
                return false;
            }

            window.location.href = APP_URL+"/game/{{ $route_code }}/gambles/"+category_id+'/'+start+'/'+end;
        });
        
    });
</script>
@stop