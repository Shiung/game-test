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
    </ol>
</div>

<div class="box-body" >
    <ul class="list-group">  
        <li class="list-group-item">
            <b>最新期別：</b> {{ $latest_data->sport_number}}

        </li>
    </ul>

    <form id="Form" style="margin-bottom:20px;">
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
                    <th>期別</th>
                    <th>開獎結果</th>
                    <th>新增時間</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{ $data->sport_number}}</td>
                    <td>
                        @foreach($data->teams as $key =>  $item)
                        @if($key != 0)
                            、
                        @endif
                        <span style="color:{{ config('cn_chess.number_to_chess.'.$item->number.'.color') }}">{{ config('cn_chess.number_to_chess.'.$item->number.'.chess') }}</span>
                        @endforeach
                    </td>
                    <td>
                        {{ $data->created_at }}
                    </td>
                    <td>
                        <a href="{{ route('admin.game.'.$route_code.'.show',$data->id) }}" class="fancybox fancybox.iframe"><button class="btn btn-primary btn-sm"  data-toggle="tooltip" title="詳細資訊" ><i class="fa fa-eye"></i></button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <center>{{ $datas->links() }}</center>
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

            window.location.href = APP_URL+"/game/{{ $route_code }}/history/"+start+'/'+end;
        });
        
    });
</script>
@stop