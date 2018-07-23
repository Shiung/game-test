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
        <li>{{ $category->name }}</li>
        <li >未開獎</li>
        <li class="active">賭盤管理</li>
    </ol>
    <!-- 上一頁 -->
    <div class="text-left">
        <a href="{{ route('admin.game.'.$route_code.'.index') }}"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="回上一頁"><i class="fa fa-fw fa-reply"></i></button></a>
    </div>
    @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))
    <!--<div class="text-right">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#selectModal"><i class="fa fa-fw fa-plus"></i></button>
    </div>-->
    @endif
</div>

<div class="box-body" >
    <p>新增時間：{{ $sport->created_at }}</p>
    <hr>
    <h4>賭盤資訊</h4>
    <div class="table-responsive">
        <table id="data_list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>賭盤類型</th>
                    <th>賭盤內容</th>
                    <th>賭盤狀態</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
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
                        <!--下注明細
                        <a href="{{ route('admin.game.'.$route_code.'.gamble.bet_record',$data->id) }}" class="fancybox fancybox.iframe"><button class="btn btn-warning btn-sm"  data-toggle="tooltip" title="下注明細" ><i class="fa fa-trophy"></i></button></a>
                        -->
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- 選擇賭盤類型Modal -->
<div class="modal fade" id="selectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">  
            <div class="modal-header">
                <h5 class="modal-title" >請選擇欲新增的賭盤類型 </h5>
                <p style="color:red;">**若無類型可選擇，表示所有賭盤類型都已經新增過**</p>
            </div>
            <div class="modal-body">
                <fieldset class="form-group">
                    <label for="bet_status">賭盤類型</label>
                    <select class="form-control" id="game_type" name="game_type" >
                        @foreach(config('game.sport.game.sport_types') as $key => $item)
                            @if($datas->where('type',$key)->count() == 0)
                            <option value="{{ $key }}">{{ $item }}</option>
                            @endif
                        @endforeach
                    </select>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="select_type">確認</button>
            </div>
        </div>
    </div>
</div>
<!-- /.box-body -->
<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
<input type="hidden" id="sport_id" value="{{ $sport->id }}"> 
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
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>

<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var table = $("#data_list");
        var sport_id = $("#sport_id").val();
        var previous;

        $(".fancybox").fancybox();

        //選擇賭盤類型
        $( "#select_type" ).click(function() {
    
            if(!$('#game_type').val()){
                return false;
            }
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


        
        
    });
</script>
@stop