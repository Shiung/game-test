@extends('layouts.main')
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 

<style>
.menu_active{
    background-color: #DCDCDC;
}
</style>
@stop 

@section('content')
@inject('SportPresenter','App\Presenters\Game\SportPresenter')

<h1>{{ $page_title }}</h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">遊戲大廳</li>
    <li class="breadcrumb-item active">{{ $page_title }}-歷史紀錄</li>
</ol>
<!--/.路徑-->

<hr>
<form id="Form" style="margin-bottom:20px;">
    <div class="input-group">
        <input type="date" class="form-control" name="date" id="date" value="{{ $date }}">
        <span class="input-group-btn">
            <input type="button" class="btn btn-info" id="search" value="查詢" >
        </span>
    </div>
</form>

<table class="table" id="data_list">
    <thead>
        <th>期別號碼</th>
        <th>開獎號碼</th>
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
           {{ $item->number }}
           @endforeach
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
<input type="hidden" value="{{ $type }}" id="type">


@stop

@section('footer-js')

<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>

<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var type = $('#type').val()
        //搜尋區間範圍
        $("#search").click(function(){
            date = $('#date').val();

            if (!$('#date').val() ) {
                swal("Error", "請輸入完整搜尋日期!", 'error');
                return false;
            }

            window.location.href = APP_URL+"/game/category/"+type+"/history/"+date;
        });
        
    });
</script>

@stop
