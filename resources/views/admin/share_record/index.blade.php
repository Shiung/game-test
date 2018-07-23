@extends('layouts.admin') 
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 

@stop 
@section('content-header',$page_title) 
@section('content')

<div class="box-header with-border">
    <ol class="breadcrumb">
        <li class="active">{{ $page_title }}</li>
    </ol>

    <div class="text-right">
        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin','share'),'') )
        <button class="btn btn-success btn-sm" id="add" data-toggle="modal" data-target="#addModal">發行娛樂幣</button>
        <button class="btn btn-danger btn-sm " id="subtract" data-toggle="modal" data-target="#subtractModal">收回娛樂幣</button>                     
        @endif 
    </div>                  
</div>

<div class="box-body" >

    <!--餘額-->
    <div class="row">
        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item">
                    總發行：{{ $share['all'] }}
                </li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item">
                    已賣出：{{ $share['sell'] }}
                </li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item">
                    剩餘：{{ $share['now'] }}
                </li>
            </ul>
        </div>
    </div>
    <!--/.餘額-->

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
                    <th></th>
                    <th>數量</th>
                    <th>說明</th>
                    <th>日期</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>@if($data->amount < 0 || $data->type == 'member_buy') 
                        <span style="color:red;">減少</span> 
                        @else 
                        <span style="color:green;">增加</span>  
                        @endif
                    </td>
                    <td>
                        {{ abs($data->amount) }}  
                    </td>

                    <td>{{ config('shop.share_record.type.'.$data->type) }}</td>
                    <td>{{ $data->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- /.box-body -->

<!-- 發行Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="Form_add">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">發行娛樂幣</h5>
            </div>
            <div class="modal-body">
                <fieldset class="form-group">
                    <label for="amount">發行數量*</label>
                    <input type="number" class="form-control" name="amount" id="amount" value="" min="0" required>
                </fieldset>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary">確認</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- /.發行Modal -->

<!-- 收回Modal -->
<div class="modal fade" id="subtractModal" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="Form_subtract">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">收回娛樂幣</h5>
            </div>
            <div class="modal-body">
                <fieldset class="form-group">
                    <label for="amount">收回數量*</label>
                    <input type="number" class="form-control" name="amount" id="amount" value="" min="0" max="{{  $share['now'] }}" required>
                </fieldset>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary">確認</button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- /.收回Modal -->
<input type="hidden" name="_token" value="{{ csrf_token() }}"> 
@stop 
@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-confirm/jquery.confirm.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>

<script>
    $(document).ready(function() {

        var token = $('input[name="_token"]').val();
        var table = $("#data_list");
        $("#data_list").DataTable({
            "order": [
                [3, "desc"]
            ],
            "paging": true,
            "searching": true
        });

        //發行表單驗證 
        $("#Form_add").validate({
            ignore: [],
            rules: {
            },
            messages: {
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");

                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element);
                } else if (element.attr("name") == "date") {
                    error.insertAfter(".input-group");
                } else {
                    error.insertAfter(element);
                }

            },
            submitHandler: function(form) {
   
                sendUri = APP_URL + "/{{ $route_code }}" ;
                sendData = $('#Form_add').serialize()+'&_token='+token+'&type=add';
                system_ajax(sendUri,sendData,"POST",function(data){
                    window.location.reload();
                });

            }
        }); //submit

        //收回表單驗證 
        $("#Form_subtract").validate({
            ignore: [],
            rules: {
            },
            messages: {
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");

                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element);
                } else if (element.attr("name") == "date") {
                    error.insertAfter(".input-group");
                } else {
                    error.insertAfter(element);
                }

            },
            submitHandler: function(form) {
   
                sendUri = APP_URL + "/{{ $route_code }}" ;
                sendData = $('#Form_subtract').serialize()+'&_token='+token+'&type=subtract';
                system_ajax(sendUri,sendData,"POST",function(data){
                    window.location.reload();
                });

            }
        }); //submit

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

           if(!dateValidationCheck(start) ||  !dateValidationCheck(end)){
                swal("Failed", "日期格式有誤",'error');
                return false;
            }
            window.location.href = APP_URL+"/{{ $route_code }}/"+start+'/'+end;
      });
        
        
    });
</script>
@stop