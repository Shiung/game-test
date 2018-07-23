@extends('layouts.admin') 
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />

@stop 
@section('content-header',$page_title) 
@section('content')

<div class="box-header with-border">
    <ol class="breadcrumb">
        <li >{{ $page_title }}</li>
        <li>
            @if($start == $end)
            {{ $start }}
            @else
            {{ $start.' ~ '.$end }}
            @endif
        </li>
        <li class="active">{{ $member->name }}</li>
    </ol>
</div>

<div class="box-body" >
    <ul class="list-group">
        <li class="list-group-item"><b>總額：</b>{{ $total }} </b></li>
    </ul>
    <div class="table-responsive">
        <table id="data_list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>日期</th>
                    <th>類型</th>
                    <th>金額</th>
                    <th>說明</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{ $data->created_at }}</td>
                    <td>
                        @if($data->amount > 0)
                        轉入
                        @else($data->amoumt < 0)
                        轉出
                        @endif
                    </td>
                    <td>
                        {{ abs($data->amount) }}
                    </td>
                    <td>{{ $data->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop 
@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>

<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var table = $("#data_list");


        $("#data_list").DataTable({
            "order": [
                [0, "desc"]
            ],
            "paging": true,
            "searching": true
        });

       

        
    });
</script>
@stop