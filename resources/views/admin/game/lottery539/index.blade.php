@extends('layouts.admin') 
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
@stop 
@section('content-header',$page_title) 
@section('content')
@inject('SportPresenter','App\Presenters\Game\SportPresenter')
<div class="box-header with-border">
    <ol class="breadcrumb">
        <li>{{ $page_title }}</li>
        <li class="active">未開獎</li>
    </ol>
</div>


<div class="box-body" >

    <div class="table-responsive">
        <table id="data_list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>賭盤狀態</th>
                    <th>新增日期</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>
                        @if($data->games[0]->bet_status == '1')
                        <span style="color:green;">開放下注</span>
                        @else
                        <span style="color:red;">關閉下注</span>
                        @endif
                    </td>
                    <td>{{ $data->created_at }}</td>
                    <td>
                        
                        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','sport-write'),''))
                        <a href="{{ route('admin.game.'.$route_code.'.edit',$data->id) }}"  class="fancybox fancybox.iframe"><button class="btn btn-info btn-sm"   >開獎號碼</button></a>     
                        @endif
                        <a href="{{ route('admin.game.'.$route_code.'.gamble.index',$data->id) }}"><button class="btn btn-warning btn-sm"  data-toggle="tooltip" title="賭盤管理" ><i class="fa fa-tasks"></i></button></a>     
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- /.box-body -->

<input type="hidden" id="category_id" value="{{ $category_id }}"> 

@stop 
@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var table = $("#data_list");
        var category_id = $("#category_id").val();
        var sport_id;
        $(".fancybox").fancybox();

        $("#data_list").DataTable({
            "paging": true,
            "searching": true
        });
        
    });
</script>
@stop