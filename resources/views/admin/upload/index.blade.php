@extends('layouts.blank') 
@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<style>
    body {
        min-height: 700px;
    }
    
    .card {
        font-size: 50px;
        overflow: hidden;
        padding: 0;
        border: none;
        border-radius: .28571429rem;
        box-shadow: 0 1px 3px 0 #d4d4d5, 0 0 0 1px #d4d4d5;
    }
    
    .card-block {
        font-size: 0.7em;
        position: relative;
        margin: 0;
        padding: 1em;
        border: none;
        border-top: 1px solid rgba(34, 36, 38, .1);
        box-shadow: none;
    }
    
    .card-img-top {
        display: block;
        width: 100%;
        height: auto;
    }
    
    .card-title {
        font-size: 1em;
        font-weight: 700;
        line-height: 1.2857em;
    }
    
    .card-text {
        clear: both;
        margin-top: .5em;
        color: rgba(0, 0, 0, .68);
    }
    
    .text-bold {
        font-weight: 700;
    }
    
    .card_selected {
        opacity: 0.5;
    }
</style>
@stop 
@section('content')
<div class="container-fluid">

    {{-- Top Bar --}}
    <div class="row page-title-row">
        <div class="col-md-6">
            <h3 class="pull-left">檔案管理 </h3>
        </div>

        <div class="col-md-6 text-right">
            <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#modal-folder-create">
          <i class="fa fa-plus-circle"></i> 新增資料夾
        </button>
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-file-upload">
          <i class="fa fa-upload"></i> 上傳檔案
        </button>
        </div>
    </div>

    <ul class="breadcrumb">
        @foreach ($breadcrumbs as $path => $disp)
        <li><a href="{{ route('admin.file_manager.index',[$field_name,$image_part]) }}?folder={{ $path }}">{{ $disp }}</a></li>
        @endforeach
        <li class="active">{{ $folderName }}</li>

    </ul>

    <div class="row">
        <div class="col-sm-12">

            <div class="table-responsive">
                <table id="uploads-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>類型</th>
                            <th>大小</th>
                            <th data-sortable="false">操作</th>
                        </tr>
                    </thead>
                    <tbody>

                        {{-- The Subfolders --}} @foreach ($subfolders as $path => $name)
                        <tr>
                            <td>
                                <a href="{{ route('admin.file_manager.index',[$field_name,$image_part]) }}?folder={{ $path }}">
                                    <i class="fa fa-folder fa-lg fa-fw"></i> {{ $name }}
                                </a>
                            </td>
                            <td>資料夾</td>
                            <td>-</td>
                            <td>
                                @if($name != 'product' && $name != 'category' && $name != 'product_slider' && $name !="info" && $name !="banner")
                                <button type="button" class="btn btn-xs btn-danger" onclick="delete_folder('{{ $name }}')">
                    <i class="fa fa-times-circle fa-lg"></i>
                    刪除
                  </button> @endif
                            </td>
                        </tr>
                        @endforeach {{-- The Files --}} @foreach ($files as $file)
                        <tr>
                            <td>
                                <div class="card">
                                    @if (is_image($file['mimeType']))
                                    <img src="{{ $file['webPath'] }}" height="50"> 
                                    @else
                                    <i class="fa fa-file-o fa-lg fa-fw"></i> 
                                    @endif

                                    <div class="card-block">
                                        <h5 class="text-bold">
                                            {{ $file['name'] }}
                                        </h5>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $file['mimeType'] or 'Unknown' }}</td>
                            <td>{{ human_filesize($file['size']) }}</td>
                            <td>
                                <button type="button" class="btn btn-xs btn-danger" onclick="delete_file('{{ $file['name'] }}')">
                                    <i class="fa fa-times-circle fa-lg"></i>
                                刪除
                                </button> @if (is_selected($file['mimeType']))
                                <button type="button" class="btn btn-xs btn-primary" onclick="select_image('{{ $file['name'] }}','{{ $file['webPath'] }}')">
                                  <i class="fa fa-check fa-lg"></i>
                                  選擇
                                </button> @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<input type="hidden" value="{{ $field_name }}" id="field_name" name="field_name">
<input type="hidden" value="{{ $image_part }}" id="image_part" name="image_part">
<input type="hidden" value="@foreach($breadcrumbs as $path => $disp)@if($disp!='根目錄'){{$disp}}@endif/@endforeach{{$folderName}}/" name="path" id="path"> @include('admin.upload._modals') @stop 
@section('footer-js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
    // Confirm file delete
    function delete_file(name) {
        $("#delete-file-name1").html(name);
        $("#delete-file-name2").val(name);
        $("#modal-file-delete").modal("show");
    }

    // Confirm folder delete
    function delete_folder(name) {
        $("#delete-folder-name1").html(name);
        $("#delete-folder-name2").val(name);
        $("#modal-folder-delete").modal("show");
    }

    // Preview image
    function preview_image(path) {
        $("#preview-image").attr("src", path);
        $("#modal-image-view").modal("show");
    }

    // Preview image
    function select_image(name, image) {
        if (window.parent) {
            field_name = document.getElementById('field_name').value;
            path = document.getElementById('path').value;
            image_part = document.getElementById('image_part').value;
            if (path == '根目錄/') {
                path = '/';
            }
            image_name = '//manager' + path + name;

            window.parent.document.getElementById(field_name).value = image_name.trim().substring(1, image_name.trim().length);

            //預覽圖片
            if (image_part != 'N') {
                window.parent.document.getElementById(image_part).src = image;
            }

            parent.jQuery.fancybox.close();
        }
    }

    // Startup code
    $(function() {
        $("#uploads-table").DataTable();

    });
</script>
@stop