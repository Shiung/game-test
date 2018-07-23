@extends('layouts.blank')
@section('head')
<style>
#result{
  margin-top: 30px;
}
</style>

<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}">
@stop
@section('content')
<div style="min-height:400px">
  <center>
    <h3>檔案上傳</h3>
    <form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="" >
      <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token()}}">
      </div>
      <p style="color:red;">注意：檔案大小限制2M以下，圖片建議 450 x 450 比例為最佳解析度</p>
      <div class="form-group">
        <div class="input-group">
            <input type="text" class="form-control" readonly id="path"  placeholder="請選擇檔案">
            <label class="input-group-btn">
                <span class="btn btn-primary">
                    瀏覽&hellip; <input type="file" style="display: none;" name="file" id="file" >
                </span>
            </label>
            
        </div>
      </div>
    </form>
    <br>
    <button id="submit" type="button" class="btn btn-info" >確認</button>
    <div id="result" ></div>
    
    <input id="field" type="hidden"  value="{{ $field }}"/>
      <input id="img" type="hidden"  value="{{ $img }}"/>
  </center>
</div>
@stop
@section('footer-js')
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script>
  $(document).ready(function() {

      var path;
      var filename;
      var content;
      var field = $('#field').val();
      var img = $('#img').val();
      var path = "{{ env('UPLOAD_URL') }}";

      $("#file").on("change", function (e) {

        //檢查檔名
        if(checkType($("#file").val())) {
            form_Data = new FormData($("#upload_form")[0]);

            $.ajax({
              url:APP_URL+'/member-upload',
              data:form_Data, 
              type:'POST',
              processData: false,
              contentType: false,
              success:function(response){
                HoldOn.close(); 
                var data=JSON.parse(response);
                 
                if (data.result == 1) {
                  filename = data.filename;
                  content = '<div class="alert alert-success"><strong>上傳成功!</strong> </div>';
                  $('#path').val(filename)
                } else {
                    console.log(data)
                  content = '<div class="alert alert-danger"><strong>上傳失敗</strong> '+data.error+'</div>';
                }
                
                $('#result').html(content);

              },
              beforeSend:function(){
                //顯示搜尋動畫
                HoldOn.open({
                    theme:'sk-cube-grid',
                    message:"<h4>Loading</h4>"
                });
              },
              error:function(xhr){
                HoldOn.close(); 
                  console.log(xhr)
                content = '<div class="alert alert-danger"><strong>上傳失敗!</strong> 系統發生問題，請聯絡客服 </div>';
                $('#result').html(content);
              }
            });
        }

        
      });

      $("#submit").click(function(){
          //檢查有沒有選圖
          if(!$('#path').val()) {
              content = '<div class="alert alert-info"><strong>注意!</strong> 請先上傳檔案 </div>';
              $('#result').html(content);
              return false;
          }
          if (window.parent) {
            
            console.log(window.parent.document.getElementById(field))
            window.parent.document.getElementById(field).value = filename
            //預覽圖片
            if (img != 'N') {
                window.parent.document.getElementById(img).src = path+filename;
            }

            parent.jQuery.fancybox.close();
        }

    });
     
      //檢查檔案格式 
      function checkType(name) {
        var ext = name.split('.').pop().toLowerCase();
       
        if($.inArray(ext, ['gif','png','jpg','jpeg','xls','xlsx','pdf','zip','rar','doc','docx']) == -1) {
            content = '<div class="alert alert-danger"><strong>Failed!</strong> 檔案格式不允許</div>';
            $('#result').html(content);
            return false;
        } else {
          return true;
        }
      }
     
  });
</script>
@stop