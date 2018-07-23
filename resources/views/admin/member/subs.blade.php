@extends('layouts.admin') @section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
@stop 

@section('content-header',$page_title) 
@section('content')
<div class="box-body" >
    <div class="box-header with-border">
        <ol class="breadcrumb">
            <li>會員列表</li>
            <li class="active">{{ $data->name }}-好友列表</li>
        </ol>

    </div>

    <hr>
    <div class="table-responsive">
        <table id="data_list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>編號</th>
                    <th>名稱</th>
                    <th>加入日期</th>

                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td> #{{ $data->member_number }}</td>
                    <td><a href="{{ route('admin.'.$route_code.'.show',$data->user_id) }}" class="fancybox fancybox.iframe">{{ $data->name }} （{{ $data->user->username }}）</a></td>
                    <td> {{ $data->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- /.box-body -->
@stop 
@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script>
    $(document).ready(function() {

        
        var table = $("#data_list");
        $(".fancybox").fancybox();

        $("#data_list").DataTable({
            "order": [
                [2, "desc"]
            ],
            "paging": true,
            "searching": true
        });

       
        
    });
</script>
@stop