<!DOCTYPE html>
<html lang="tw">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>{{ env('COMPANY_NAME') }}</title>
        <!-- Bootstrap Core CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('admin/css/font-awesome.min.css') }}">
        <!-- 自己的css-->
        <link rel="stylesheet" href="{{ asset('front/css/main.css') }}">
        @yield('head')
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
<!-- jQuery 2.1.4 -->
<script src="{{ asset('plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<!-- jim library -->
<script src="{{ asset('admin/js/jim_library.js') }}"></script>
<script>
    //取得laravel原始位址
    var APP_URL = {!! json_encode(url('/game-admin/dashboard')) !!};

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
