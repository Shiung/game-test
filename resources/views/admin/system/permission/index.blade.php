@extends('layouts.subdashboard')
@section('head')

		<!-- DataTables -->
	    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables/dataTables.bootstrap.css') }}">
	    <link rel="stylesheet" href="{{ asset('admin/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
	    <link rel="stylesheet" href="{{ asset('admin/plugins/lobibox/lobibox.min.css') }}" type="text/css" media="screen" />
@stop
@section('content-header','權限')

@section('content')

				<div class="box-header with-border">
          <ol class="breadcrumb">
            <li>首頁</li>
            <li>權限列表</li>
          </ol>
					<div class="text-right"> 
						<!-- 限制項目個數 -->
						<a  href="{{ route('dashboard.permission.create') }}"><button class="btn btn-primary btn-sm" data-toggle="tooltip" title="新增"><i class="fa fa-fw fa-plus"></i></button></a>
					</div>    
				</div>

				<div class="box-body">
				    <div class="table-responsive">
					    <table id="example1" class="table table-bordered table-striped">
					      	<thead>
						        <tr>
						          <th>名稱</th>
                      <th>代碼</th>
						          <th>操作</th>                   
						        </tr>
					      	</thead>
						    <tbody>
                    @foreach($datas as $data)
                    <tr>
    						        <td>{{ $data->display_name }}</td>
                        <td>{{ $data->name }}</td>
    						        <td>
                          <a href="{{ route('dashboard.permission.edit',$data->id) }}"><button class="btn btn-info btn-sm"  data-toggle="tooltip" title="編輯" ><i class="fa fa-pencil-square-o"></i></button>
    							        <!--<a href="nightmarket/{{ $data->nightmarket_id }}/edit"><button class="btn btn-primary btn-sm"  data-toggle="tooltip" title="編輯" ><i class="fa fa-pencil-square-o"></i></button></a>-->  
    							        <button class="btn btn-danger btn-sm delete"  data-toggle="tooltip" title="刪除" data-id="{{ $data->id }}" data-name="{{ $data->display_name }}"><i class="fa fa-trash"></i></button>                                     
    						        </td>  
                    </tr>
                    @endforeach
						    </tbody>
					    </table>
				    </div><!-- /.box-body -->
				    <input type="hidden" name="_token" value="{{ csrf_token() }}">   
				</div>
			
@stop
@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script src="{{ asset('admin/plugins/lobibox/lobibox.js') }}"></script>
<script src="{{ asset('admin/plugins/jquery-confirm/jquery.confirm.min.js') }}"></script>
<script>
  $(document).ready(function() {

    var token=$('input[name="_token"]').val();
     $("#example1").DataTable({
        "order": [[ 1, "desc" ]],
         "paging": true
      });
    $(".fancybox").fancybox({
        'width' : 900
    });
     var table  = $("#example1"); 
    table.on("click",".delete", function(e){
      e.preventDefault();  
      var id=$(this).data('id');
      var name=$(this).data('name');
      var tr=$(this).parent().parent();

      $.confirm({
        text: "確認刪除 "+name+" ?",
        confirm: function(button) {
          $.ajax({
            url:"/laravel/public/dashboard/admin/permissions/"+id,
            data:{'_token':token,'method':'DELETE'},
            type : "DELETE",
            success:function(msg){  
                   
              var data=JSON.parse(msg);     
              if(data.result==1)
              {  
                Lobibox.alert('success', {
                  msg: data.text,
                  callback: function(lobibox, type){

                    window.location.reload();
                     
                  }
                }); 
              }
              else
              {
                Lobibox.alert('error', {
                  msg: data.text
                });
              }                           
            },
            error:function(xhr){
              Lobibox.alert('error', {
                msg: 'Ajax request 發生錯誤',
              });
            }
          }); 
        },
        cancel: function(button) {
        },
        confirmButton: "確認",
        cancelButton: "取消"
      });//.confirm
    });//.delete       
  });
</script>
@stop