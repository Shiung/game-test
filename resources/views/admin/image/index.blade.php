<html>
<head>

</head>
<body>

<form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="" >
      <div class="form-group">
        <label for="catagry_name">Name</label>
         <input type="hidden" name="_token" value="{{ csrf_token()}}">
      </div>
      <div class="form-group">
        <label for="catagry_name">Logo</label>
        <input type="file" name="file" class="form-control" id="file">
        <input type="text" name="folder" class="form-control" id="folder">
        <p class="invalid">Enter Catagory Logo.</p>
    </div>

    </form>
    </div>
  </div>
  <br>

<span>File</span>

<input id="uploadbutton" type="button" value="Upload"/>
<input id="token" type="hidden" value="{{ csrf_token() }}"/>
</body>
</html>

<script   src="https://code.jquery.com/jquery-2.2.4.min.js"  ></script>
<script>
var APP_URL = {!! json_encode(url('/')) !!};

$("#file").on("change", function (e) {
  $.ajax({
        url:APP_URL+'/image/upload',
        data:new FormData($("#upload_form")[0]),
        type:'POST',
        processData: false,
        contentType: false,
        success:function(response){
          var data=JSON.parse(response);
          console.log(data);
        },
        error:function(xhr){

          console.log(xhr)
        }
      });
 });
</script>