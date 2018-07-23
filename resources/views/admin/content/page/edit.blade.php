@extends('layouts.admin') @section('head')

<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 

@stop 
@section('content-header',$page_title) 
@section('content') 
<div class="box-header with-border">
    <ol class="breadcrumb">
        <li>{{ $page_title }}</li>
        <li class="active">瀏覽編輯-{{ $data->title }}</li>
    </ol>
    <!-- 上一頁 -->
    <div class="text-left">
        <a href="{{ route('admin.'.$route_code.'.index') }}"><button class="btn btn-default btn-sm" data-toggle="tooltip" title="回上一頁"><i class="fa fa-fw fa-reply"></i></button></a>
    </div>
</div>
<div class="box-body" >
    <form id="Form">
        <div class="row">
            <div class="col-md-4">
                <fieldset class="form-group" style="display:none;">
                    <label for="status">狀態*</label>
                    <select class="form-control" id="status" name="status">
                        <option value="1" @if($data->status == 1) selected @endif>開放</option>
                        <option value="0" @if($data->status == 0) selected @endif>關閉</option>
                    </select>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="title">標題*</label>
                    <input type="text" class="form-control" name="title" id="title" value="{{ $data->title }}" required>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group" style="display:none;">
                    <label for="code">頁面網址URL關鍵字* (請勿輸入?  \ / % * 等符號)</label>
                    <input type="text" class="form-control" name="code" id="code" maxlength="20" value="{{ $data->code }}" placebolder="限制20個字元，請勿輸入中文字" required>
                </fieldset>
            </div>
        </div>

        
        <fieldset class="form-group">
            <label for="content">內容*</label>
            <textarea class="form-control" id="content" name="content" rows="3">
                @if($data->content != ''){{ $data->content }} @else @endif
            </textarea>
        </fieldset>

        @if(Auth::guard('admin')->user()->ability(array('super-admin', 'master-admin',$route_code.'-write'),''))               
        <!-- 額外資訊 -->
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="id" name="id" value="{{ $data->id }}">
        <input type="hidden" id="_method" name="_method" value="put">
        <center>
            <button type="submit" class="btn btn-primary">確認</button>
        </center>
        @endif
    </form>
</div>
<!-- /.box-body -->
@stop @section('footer-js')
<!-- CK Editor -->
<script type="text/javascript" src="{{ asset('admin/plugins/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/plugins/ckfinder/ckfinder.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- Validate-->
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/validate/addition-method.min.js') }}"></script>
<!-- Loading -->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>

<script>
    $(document).ready(function() {

        var id = $('#id').val();
        
        //CKEDITOR
        if (typeof CKEDITOR == 'undefined') {
            document.write('加载CKEditor失败');
        } else {
            var editor1 = CKEDITOR.replace('content', {
                filebrowserBrowseUrl: ASSET_URL + "/admin/plugins/ckfinder/ckfinder.html",
                filebrowserImageBrowseUrl: ASSET_URL + "/admin/plugins/ckfinder/ckfinder.html?type=Images",
                filebrowserFlashBrowseUrl: ASSET_URL + '/admin/plugins/ckfinder/ckfinder.html?type=Flash',
                filebrowserUploadUrl: ASSET_URL + '/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl: ASSET_URL + '/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                filebrowserFlashUploadUrl: ASSET_URL + '/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
            });
            editor1.config.height = 300;
        }

        //表單驗證 
        $("#Form").validate({
            ignore: [],
            rules: {
                code: {
                    alphanumeric: true
                }
            },
            messages: {
                title: "請填寫標題",
                code:  {
                    required: "請填寫頁面網址URL關鍵字",
                    alphanumeric: "請確認格式，僅接受英文、數字、底線、減號"
                }
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

                //加這行才能正確讀到ckeditor
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
                
                sendUri = APP_URL + "/content/{{ $route_code }}/" + id;
                sendData = $('#Form').serialize();
                system_ajax(sendUri,sendData,"PUT",function(data){
                    window.location.href = APP_URL + "/content/{{ $route_code }}";
                });


            }
        }); //submit

    });
</script>
@stop