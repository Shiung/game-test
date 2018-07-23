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
        <li class="active">{{ $page_title }}</li>
    </ol>
</div>

<div class="box-body" >
    <form id="Form" style="margin-bottom:20px;">
        @include('admin.statistic.search_bar')
    </form>
    <ul class="list-group">
        <li class="list-group-item"><b>總額：</b>{{ $total }} </b></li>
    </ul>
    <div class="table-responsive">
        <table id="data_list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>日期</th>
                    <th>總額</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $date => $amount)
                <tr>
                    <td>{{ $date }}</td>
                    <td>
                        @if($amount != 0)
                        <a href="{{ route('admin.statistic.'.$route_code.'.members',[$date,getEndDateByType($date,$period_type)]) }}">{{ abs($amount) }} </a>
                        @else
                        0
                        @endif
                    </td>
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
        $(".fancybox").fancybox();

        $("#data_list").DataTable({
            "order": [
                [0, "desc"]
            ],
            "paging": true,
            "searching": true
        });

       
        //搜尋區間範圍
        $("#search").click(function(){
            start = $('#start').val();
            end = $('#end').val();
            period_type = $('#period_type').val();

            if (Date.parse(start) > Date.parse(end) ) {
                swal("Error", "日期範圍有誤，請重新輸入!", 'error');
                return false;
            }

            if (!$('#start').val() || !$('#end').val()) {
                swal("Error", "請輸入完整搜尋日期!", 'error');
                return false;
            }

           if(!dateValidationCheck(start) ||  !dateValidationCheck(end)){
                swal("Failed", "日期格式有誤",'error');
                return false;
            }
            window.location.href = APP_URL+"/statistic/{{ $route_code }}/summary/"+start+'/'+end+'/'+period_type;
      });
        
    });
</script>
@stop