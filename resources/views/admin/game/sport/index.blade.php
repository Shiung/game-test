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
        <li class="active">未打完賽程</li>
    </ol>
    @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))
    <div class="text-right">
        <a href="{{ route('admin.game.'.$route_code.'.create',$category_id) }}"><button class="btn btn-primary btn-sm" data-toggle="tooltip" title="新增"><i class="fa fa-fw fa-plus"></i></button></a>
    </div>
    @endif
</div>

<div class="box-body" >
    <p style="color:red;">未打完賽程包含：「尚未開始」、「進行中」、「暫停」賽程列表</p>
    <p style="color:red;">完全無人下注，且所有賭盤設定皆為「未開放下注」的狀態下，才能刪除賽程、編輯賽程隊伍&時間資訊</p>
    <div class="table-responsive">
        <table id="data_list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>賽程編號</th>
                    <th>隊伍資訊</th>
                    <th>比賽時間[當地]</th>
                    <th>比賽時間[台灣]</th>
                    <th>賽程狀態</th>
                    <th>開盤狀態</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{ $data->id}}</td>
                    <td>
                        {!! $SportPresenter->showTeamInformation($data) !!}
                    </td>
                    <td>{{ $data->start_datetime }}</td>
                    <td>{{ $data->taiwan_datetime }}</td>
                    <td>{!! config('game.sport.status.'.$data->status) !!}</td>
                    <td>
                        {!! $SportPresenter->showGameStatus($data) !!}
                    </td>
                    <td>
                        <a href="{{ route('admin.game.'.$route_code.'.gamble.index',$data->id) }}"><button class="btn btn-warning btn-sm"  data-toggle="tooltip" title="賭盤管理" ><i class="fa fa-tasks"></i></button></a>
                        
                        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))
                            <a href="{{ route('admin.game.'.$route_code.'.edit',$data->id) }}"><button class="btn btn-primary btn-sm"  data-toggle="tooltip" title="編輯" ><i class="fa fa-pencil-square-o"></i></button></a>
                            <a href="{{ route('admin.game.'.$route_code.'.edit_status',$data->id) }}" class="fancybox fancybox.iframe"><button class="btn btn-info btn-sm "  data-toggle="tooltip" title="更新賽程狀態" ><i class="fa fa-futbol-o"></i></button></a> 
                        
                            @if($data->games->where('bet_status','0')->count() == count($data->games) && !$SportPresenter->checkIfHasBetRecord($data) )
                            <!--沒有賭盤才能刪除-->
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
                [3, "desc"]
            ],
            "paging": true,
            "searching": true
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
                    
                    sendUri = APP_URL + "/game/{{ $route_code }}/" + id;
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

        
    });
</script>
@stop