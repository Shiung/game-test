@inject('MarqueeService', 'App\Services\Content\MarqueeService')
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>{{ env('COMPANY_NAME') }}</title>
        <link rel="shortcut icon" type="image/ico" href="{{ asset('front/img/favicon.ico') }}" />
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('front/css/font-awesome.min.css') }}">  
        <link rel="stylesheet" href="{{ asset('front/css/main.css') }}">
        <!-- rwd -->
        <link rel="stylesheet" href="{{ asset('front/css/response.css') }}"> 
        <!-- app menu -->
        <link rel="stylesheet" href="{{ asset('front/css/app/menu.css') }}"> 
        <script src="{{ asset('plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
        <script src="{{ asset('front/js/bladecommon.js') }}"></script>
        <script>
            var APP_URL = {!!json_encode(url('/')) !!}
            var ASSET_URL = {!! json_encode(url('/')) !!};

        </script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        @yield('head')
        <style>
            
            /*app top area*/
            .m-top-area {
                position: fixed;
                width: 100%;
                z-index: 100;
            }
            .m-top-bg {
                width: 100%;
                height: 50px;
                background: #191639;
            }
            .m-bar-logo {
                position: absolute;
                top: 11px;
                width: 80%;
                left: 10%;
                z-index: 999;
            }

            .m-bar-logo img {
                width: 100%;
            }
            
            .m-home-link {
                position: absolute;
                width: 40%;
                height: 50px;
                top: 0;
                left: 30%;
                z-index: 1000;
            }
            
            .m-home-link-area {
                position: relative;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0);
            }
            
            .m-bar-nav-close {
                position: absolute;
                top: 0px;
                width: 90%;
                left: 5%;
                z-index: 998;
            }

            .m-bar-nav-close-bg {
                width: 100%;
            }
            
            .m-bar-nav-btn-open {
                position:absolute;
                bottom: 8px;
                left: 0;
                width: 100%;
            } 
            
            .m-bar-nav-btn-open img{
                width: 100%;
            }
            
            #m-bar-nav-open {
                display: none;
            }
            
            .m-bar-nav-open {
                position: absolute;
                top: 0px;
                width: 90%;
                max-height: 0;
                overflow: hidden;
                left: 5%;
                z-index: 998;
                -webkit-transition: max-height 1s; 
                  -moz-transition: max-height 1s; 
                  -ms-transition: max-height 1s; 
                  -o-transition: max-height 1s; 
                  transition: max-height 1s;  
            }
            
            .m-bar-nav-open-animate {
                max-height: 1200px !important;
            }

            .m-bar-nav-open-bg {
                width: 100%;
            }
            
            #m-bar-nav-item {
                position: absolute;
                width: 100%;
                height: auto;
                top: 13%;
                left: 0;
                display: none;
            }
            
            .m-bar-nav-menu-item {
                width: 100%;
                height: 48px;
                line-height: 48px;
                text-align: center;
                color: #00A3E0;
                font-size: 28px;
            }
            
            
            
            .m-bar-nav-menu-item a {
                color: #00A3E0;
            }
            
            .m-bar-nav-menu-item a:hover , .m-bar-nav-menu-item a:focus {
                color: #FFFFFF;
            }
            
            .m-bar-nav-menu-footer-item {
                width: 100%;
                height: 90px;
                padding-top: 9px;
                padding-left: 5px;
                text-align: center;
            }
            
            .m-bar-nav-menu-footer-item a {
                margin-right: 5px;
            }
            
            .m-bar-nav-menu-footer-item-img {
                height: 80px;
            }
            
            .m-top-margin {
                width: 100%;
                height: 80px !important;
            }
            
            /*延展手機版menu點選範圍*/
            .m-bar-open-area-expand{
                position: absolute;
                width: 100%;
                height: 60px;
                top: 48px;
                left: 0;
                z-index: 999;
                border: 0;
            }
            
            
            @media screen and (min-width: 375px) and (max-width: 413px) {
                .m-bar-nav-menu-item {
                    height: 42px;
                    line-height: 42px;
                    font-size: 28px;
                }    
                
                .m-home-link {
                    height: 45px;
                }
                
                .m-bar-open-area-expand{
                    height: 55px;
                    top: 43px;
                }
            }
            
            @media screen and (max-width: 374px) {
                .m-bar-nav-menu-item {
                    height: 36px;
                    line-height: 36px;
                    font-size: 24px;
                }    
                .m-bar-nav-menu-footer-item {
                    height: 70px;
                }

                .m-bar-nav-menu-footer-item a {
                    margin-right: 5px;
                }

                .m-bar-nav-menu-footer-item-img {
                    height: 60px;
                }
                
                .m-home-link {
                    height: 40px;
                }
                
                .m-bar-open-area-expand{
                    height: 47px;
                    top: 38px;
                }
            }
            
            /*pc layout*/
            
            .top-fixed-bar {
                position: fixed;
                width: 100%;
                z-index: 9999;
            }
            
            .pc-top-bg {
                position: absolute;
                width: 100%;
                left: 0;
                top: 0;
                height: 105px;
                background-color: #191639;
            }
            
            .pc-bar-area {
                position: relative;
                margin: 0 auto;
                width: 1167px;
            }
            
            .pc-bar-height {
                width: 100px;
                height: 210px;
            }
            
            @media screen and (min-width: 768px) and (max-width: 991px) {
                .pc-top-bg {
                    height: 70px;
                }

                .pc-bar-area {
                    width: 768px;
                }
                
                .pc-bar-height {
                    height: 130px;
                }
            }
            
            @media screen and (min-width: 992px) and (max-width: 1399px) {
                .pc-top-bg {
                    height: 87px;
                }

                .pc-bar-area {
                    width: 950px;
                }
                
                .pc-bar-height {
                    height: 160px;
                }
            }
            
            .pc-bar-logo {
                position: absolute;
                width: 100%;
                top: 0;
                left: 0;
                z-index: 999;
            }

            .pc-bar-logo img {
                width: 100%;
            }
            
            .pc-bar-menu {
                position: absolute;
                width: 100%;
                height: 50px;
                left: 0;
                top: 115px;
                z-index: 1000;
                text-align: center;
                line-height: 50px;
                font-size: 22px;
                font-weight: 500;
                color: #00A3E0;
            }
            
            .pc-menu-item {
                color: #00A3E0;
                padding: 0px 15px;
            }
            
            .pc-menu-item:hover , .pc-menu-item:focus {
                color: #FFFFFF;
            }
            
            .pc-bar-name {
                position: absolute;
                width: 100%;
                left: 0;
                top: 30px;
                padding-right: 22px;
                z-index: 1000;
                text-align: right;
                font-size: 18px;
                color: #FFFFFF;
            }
            
            .pc-home-link {
                position: absolute;
                width: 30%;
                height: 105px;
                top: 10px;
                left: 35%;
                z-index: 1000;
            }
            
            .pc-home-link-area {
                position: relative;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0);
            }
            
            @media screen and (min-width: 768px) and (max-width: 991px) {
                .pc-bar-menu {
                    height: 30px;
                    line-height: 30px;
                    top: 76px;
                    font-size: 16px;
                }

                .pc-menu-item {
                    padding: 0px 3px;
                }
                
                
                .pc-bar-name {
                    top: 15px;
                    padding-right: 15px;
                    font-size: 14px;
                }
                
                .pc-home-link {
                    height: 65px;
                }
            }
            
            
            @media screen and (min-width: 992px) and (max-width: 1399px) {
                .pc-bar-menu {
                    height: 35px;
                    line-height: 35px;
                    top: 98px;
                    font-size: 18px;
                }

                .pc-menu-item {
                    padding: 0px 5px;
                }
                
                .pc-bar-name {
                    top: 20px;
                    padding-right: 20px;
                    font-size: 16px;
                }
                .pc-home-link {
                    height: 85px;
                }
            }
            
            /*pc top bar 完成*/
            
            /*跑馬燈公告*/
            
            .m-marquee-position {
                display: none;
                position: fixed;
                width: 100%;
                height: 35px;
                z-index: 99;
                bottom: 0;
                left: 0;
            }
            
            .m-marquee-area {
                position: relative;
                width: 100%;
                height: 35px;
                background: url("{{ asset('front/img/home/phone/bulletin.png') }}");
                background-repeat: no-repeat;
                background-size: 100% 100%;
            }
            
            .m-marquee-area marquee {
                position: absolute;
                line-height: 33px;
                color: #191639;
                font-size: 16px;
                width: 65%;
                right: 0;
                bottom: 0;
            }
            
            .pc-marquee-position {
                display: none;
                position: fixed;
                width: 100%;
                height: 65px;
                z-index: 99;
                bottom: 0;
                left: 0;
                background: url("{{ asset('front/img/home/web/bulletin_bg.png') }}");
                background-repeat: no-repeat;
                background-size: 100% 100%;
            }
            
            .pc-marquee-area {
                position: relative;
                width: 1400px;
                height: 65px;
                line-height: 65px;
                margin: 0 auto;
            }
            
            .pc-marquee-area img {
                height: 65px;
            }
            
            .pc-marquee-area marquee {
                position: absolute;
                line-height: 60px;
                color: #191639;
                font-size: 24px;
                width: 1150px;
                right: 0;
                bottom: 0;
            }
            
            @media screen and (min-width: 768px) and (max-width: 991px) {
                .pc-marquee-position {
                    height: 45px;
                }
                
                .pc-marquee-area {
                    width: 768px;
                    height: 45px;
                    line-height: 45px;
                }
                
                .pc-marquee-area img {
                    height: 45px;
                }
                
                .pc-marquee-area marquee {
                    width: 582px;
                    line-height: 40px;
                    font-size: 20px;
                }        
            }
                    
            @media screen and (min-width: 992px) and (max-width: 1399px) {
                .pc-marquee-position {
                    height: 45px;
                }
                .pc-marquee-area {
                    width: 950px;
                    height: 45px;
                    line-height: 45px;
                }
                
                .pc-marquee-area img {
                    height: 45px;
                }

                .pc-marquee-area marquee {
                    width: 750px;
                    line-height: 40px;
                    font-size: 20px;
                } 
            }

            @media screen and (min-width: 1200px) and (max-width: 1399px) {
                .pc-marquee-position {
                    height: 45px;
                }
                .pc-marquee-area {
                    width: 1200px;
                    height: 45px;
                    line-height: 45px;
                }
                
                .pc-marquee-area img {
                    height: 45px;
                }

                .pc-marquee-area marquee {
                    width: 1000px;
                    line-height: 40px;
                    font-size: 20px;
                } 
            }

        </style>
    </head>

    <body>
        <!--PC top menu -->
        <div class="pc_layout">
            @include('layouts.front-partials.navigation')
        </div><!-- PC layout -->

        <!--APP-->
        <div class="app_layout">
            <!-- top menu 
            <nav class="responsive-menu">
                <div class="logo2"><a href="{{ route('front.index') }}"><img src="{{ asset('front/img/logo.png') }}" height="50px"></a></div>   
                <a href="#" class="toggle-menu" data-toggle-class="active" data-toggle-target=".main-menu, this"><svg height="32" viewBox="0 0 32 32" width="32" xmlns="http://www.w3.org/2000/svg"><path d="M4 10h24c1.104 0 2-.896 2-2s-.896-2-2-2H4c-1.104 0-2 .896-2 2s.896 2 2 2zm24 4H4c-1.104 0-2 .896-2 2s.896 2 2 2h24c1.104 0 2-.896 2-2s-.896-2-2-2zm0 8H4c-1.104 0-2 .896-2 2s.896 2 2 2h24c1.104 0 2-.896 2-2s-.896-2-2-2z" fill="#fff"/></svg></a>
                
                <ul class="main-menu">
                     @include('layouts.front-partials.menulist') 
                </ul>
            </nav>-->
            <div class="m-top-area">
                
                <!--手機版上方menu藍色色塊-->
                <div class="m-top-bg">
                    
                </div>
                
                <!--手機版上方menu logo-->
                <div class="m-bar-logo">
                    <img src="{{ asset('front/img/home/phone/chess/P01_menu_01.png') }}">
                </div>
                
                <!--回首頁連結-->
                <a class="m-home-link" href="{{ route('front.index') }}"><div class="m-home-link-area"></div></a>

            </div>
            
        </div><!-- app layout-->

        <!-- content -->
        <div class="content">
            @yield('title-area')
            <div class="m-top-margin hidden-sm hidden-md hidden-lg"></div>
            <div class="container" >
                @yield('content')
            </div>
        </div>

        <!--跑馬燈-->
        <div class="pc_layout">
            <div class="pc-marquee-position">
                <div class="pc-marquee-area">
                    <img src="{{ asset('front/img/home/web/bulletin_title.png') }}" >
                    <!--跑馬燈-->
                    <marquee>
                        @foreach($MarqueeService->all() as $marquee)
                        {{ $marquee->content }} - {{ $marquee->created_at }}&nbsp;&nbsp;&nbsp;
                        @endforeach
                    </marquee>
                    <!--/.跑馬燈-->
                </div>
            </div>
        </div>

        <div class="app_layout">
            <div class="m-marquee-position">
                <div class="m-marquee-area">
                    <!--跑馬燈-->
                    <marquee>
                        @foreach($MarqueeService->all() as $marquee)
                        {{ $marquee->content }} - {{ $marquee->created_at }}&nbsp;&nbsp;&nbsp;
                        @endforeach
                    </marquee>
                    <!--/.跑馬燈-->
                </div>

            </div>
        </div>

        @yield('outer-area')
       
        <!-- footer -->
        @include('layouts.front-partials.footer')
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        
    </body>

</html>

<script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
<!-- app menu -->
<script src="{{ asset('front/js/app/menu.js') }}"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119702832-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-119702832-1');
</script>

@yield('footer-js')