<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ env('COMPANY_NAME') }}-後台管理系統</title>
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/css/font-awesome.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. 模板顏色 -->
    <link rel="stylesheet" href="{{ asset('admin/css/skins/skin-black.min.css') }}">
    <!-- 自己的css-->
    <link rel="stylesheet" href="{{ asset('admin/css/main.css') }}">
    
    @yield('head')
  </head>
  <body class="hold-transition skin-black sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <a href="{{ route('admin.index') }}" class="logo">
          <img src="{{ asset('front/img/logo.png') }}" height="30px">
        </a>
        @include('layouts.admin-partials.header')
      </header>
      <aside class="main-sidebar">
        @include('layouts.admin-partials.menu')
      </aside>
      <div class="content-wrapper">
        <section class="content" >
          <div class="info-box">
            
            <!-- 內容 -->
            @yield('content')
            
            <div class="box-footer"></div><!-- /.box-footer-->
            </div><!-- /.box -->
            <!-- 白色底的框框 -->
            </section><!-- /.主要內容 -->
            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
              @include('layouts.admin-partials.footer')
            </footer>
            </div><!-- ./wrapper -->
          </body>
        </html>
        <!-- jQuery 2.1.4 -->
        <script src="{{ asset('plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('admin/js/app.min.js') }}"></script>
        <!-- jim library -->
        <script src="{{ asset('admin/js/jim_library.js') }}"></script>
        <script>
        $(document).ready(function() {
          
          //取得網址
          var current_url = window.location.href;
          var url_arr = current_url.split("/");
          dashboard_index = url_arr.indexOf("dashboard");

        });
        //取得laravel原始位址
        var APP_URL = {!! json_encode(url('/game-admin/dashboard')) !!};
        //套件位置
        var ASSET_URL = {!! json_encode(url('/')) !!};

        refreshToken()
        setInterval( refreshToken , 200000 )
        //重新取得token
        function refreshToken(){
          $.ajax({
            url:{!! json_encode(url('/admin-token')) !!},
            type : "GET",
            data:{current_token:localStorage.a_token},
            success:function(new_token){         
            },
            error:function(xhr){
              console.log(xhr)
            }
          }); 
        }
 
        
        </script>
        @yield('footer-js')