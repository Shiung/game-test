@extends('layouts.main')
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
@stop

@section('content')

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">會員專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->

<h1>{{ $page_title }}</h1>

<div class="table-responsive">
    <table id="data_list" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>會員編號</th>
                <th>名稱</th>
                <th>帳號</th>
                <th>加入日期</th>

            </tr>
        </thead>
        <tbody>
            @foreach($datas as $data)
            <tr>
                <td>{{ $data->member_number }} </td>
                <td>{{ $data->name }}</td>
                <td>{{ $data->user->username }} </td>
                <td> {{ $data->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop

@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script>
    $(document).ready(function() {

        $(".fancybox").fancybox();

        $("#data_list").DataTable({
            "order": [
                [3, "desc"]
            ],
            "paging": true,
            "searching": true
        });
   
    });
</script>
@stop

