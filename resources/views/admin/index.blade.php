@extends('layouts.dashboard')
@section('content')
<div class="box-body">
	<!-- <iframe src="{{ route('dashboard.home.index') }}" id="mainframe" height="100%" width="100%" scrolling="no" frameborder="0" style="border:0" allowfullscreen ></iframe>-->
	<iframe src="{{ route('dashboard.home.index') }}" name="mainframe" width="100%" marginwidth="0" marginheight="0" onload="Javascript:SetCwinHeight()"  scrolling="No" frameborder="0" id="mainframe"  ></iframe>
</div><!-- /.box-body -->
@stop
<script type="text/javascript">
//設定iframe url
function setUrl(url)
{
    document.getElementById("mainframe").src = url; 
}
function SetCwinHeight()
{
var iframeid=document.getElementById("mainframe"); //iframe id
  if (document.getElementById)
  {   
   if (iframeid && !window.opera)
   {   
    if (iframeid.contentDocument && iframeid.contentDocument.body.offsetHeight)
     {   
       iframeid.height = iframeid.contentDocument.body.offsetHeight;   
     }else if(iframeid.Document && iframeid.Document.body.scrollHeight)
     {   
       iframeid.height = iframeid.Document.body.scrollHeight;   
      }   
    }
   }
}
</script>