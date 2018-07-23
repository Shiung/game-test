@extends('layouts.admin')
@section('head')
<style>
    html, body {
        height: 100%;
    }




    .title {
        font-size: 72px;
        margin-bottom: 20px;
    }
    .warningtext {
        font-size: 30px;
        margin-bottom: 30px;
    }
</style>
@stop

@section('content')

    <div class="container">
        <div class="content">
            <center>
             <!--這一塊是顯示一般沒有權限瀏覽各頁的畫面-->
            <div class="title">權限不足！</div>
            <div class="warningtext">您沒有權限進入此功能</div>
        </center>
        </div><!--/content-->
    </div><!--/container-->
@stop
@section('footer-js')
@stop