@extends('layouts.main')
@section('head')
<!--Slide-->
<link rel="stylesheet" href="{{ asset('plugins/ResponsiveSlides/responsiveslides.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
<script type="text/javascript" src="{{ asset('plugins/fancybox/source/jquery.fancybox.js?v=2.1.5') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script>

<script>
  $(function() {
    //check system alert
    var alert_open="{{ $system_alert_read }}";"0"==alert_open&&$.fancybox.open({padding:0,href:APP_URL+"/system-alert",type:"iframe"});
  });
</script>
<style>
    .home-banner {
        position: relative;
    }
    .rslides {
        position: absolute;
        top: 2px;
        list-style: none;
        overflow: hidden;
        width: 100%;
        height: 0;
        padding: 0;
        padding-bottom: 20.83%;
        margin: 0;
    }

    .rslides li {
        -webkit-backface-visibility: hidden;
        position: absolute;
        display: none;
        width: 100%;
        left: 0;
        top: 0;
    }

    .rslides li:first-child {
        position: relative;
        display: block;
        float: left;
    }

    .rslides img {
        display: block;
        height: auto;
        float: left;
        width: 100%;
        border: 0;
    }

    .app_btn, .app_btn img{
        width: 100%;
        margin-top: 0px;
    }
    
    html , body {
        height: 100%;
        overflow: hidden;
    }
    
    @media screen and (max-width: 767px) {
        html , body {
            height: 100.05%;
        }     
    }
    
    /*滿版背景*/
    
    .full-screen {
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    #mycarousel {
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 95%;
        z-index: 0;
    }
    
    #pccarousel {
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 95%;
        z-index: 0;
    }
    
    
    @media screen and (min-width: 768px) {
        .carousel-indicators {
            left: 14.5%;
            margin-left: 0;
            text-align: left;
        }    
    }
    
    @media screen and (max-width: 767px) {
        .carousel-indicators {
            text-align: right;
            width: 70%;
        }    
    }
    
    .carousel-indicators li {
        width: 12px;
        height: 12px;
        margin: 0;
        margin-right: 3px;
        border: 2px solid #d7ae4c;
    }
    
    .carousel-indicators .active {
        width: 12px;
        height: 12px;
        margin-right: 4px;
        background-color: #FFF;
        border: 2px solid #d7ae4c;
    }
    
    
    
    /*右方*/
    .content {
        width: 100%;
        height: 100%;
    }
    
    .pc-right-item {
        position: fixed;
        top:59%;
        margin-top: -114px;
        right: 0;
        z-index: 999;
    }
    
    .pc-right-item-link-area {
        position: absolute;
        top: 30px;
        left: 120px;
    }
    
    .pc-right-item-link { 
        line-height: 61px;
        color: #191639;
        font-size: 32px;
        font-weight: bold;
        cursor: pointer;
    }
            
    .pc-right-item-link:hover , .pc-right-item-link:focus {
        color: #00A3E0;
    }
    
    
    @media screen and (min-width: 768px) and (max-width: 991px) {
        .pc-right-item {
            margin-top: -60px;
        }
        
        .pc-right-item img {
            height: 120px;
        }

        .pc-right-item-link-area {
            top: 16px;
            left: 62px;
        }

        .pc-right-item-link { 
            line-height: 32px;
            font-size: 17px;
        }
    }
            
    @media screen and (min-width: 992px) and (max-width: 1199px) {
        .pc-right-item {
            margin-top: -80px;
        }
        
        .pc-right-item img {
            height: 160px;
        }

        .pc-right-item-link-area {
            top: 23px;
            left: 85px;
        }

        .pc-right-item-link { 
            line-height: 42px;
            font-size: 22px;
        }
    }

    @media screen and (min-width: 1200px) and (max-width: 1399px) {
        .pc-right-item {
            margin-top: -80px;
        }
        
        .pc-right-item img {
            height: 160px;
        }

        .pc-right-item-link-area {
            top: 23px;
            left: 85px;
        }

        .pc-right-item-link { 
            line-height: 42px;
            font-size: 22px;
        }
    }
    
    .m-marquee-position {
        display: block !important;
    }
    
    .pc-marquee-position {
        display: block !important;
    }
    
    .m-link {
        position: absolute;
        width: 30%;
        height: 30px;
        bottom: 9%;
        left: 35%;
    }
    
</style>
@stop

@section('title-area')
<div class="pc-right-item hidden-xs">
    <img src="{{ asset('front/img/home/web/P01_menu_icon_00.png') }}">
    <div class="pc-right-item-link-area">
        <a class="pc-right-item-link" href="{{ route('front.checkin.index') }}">簽到中心</a><br>
        <a class="pc-right-item-link" href="https://line.me/R/ti/p/%40ulk7423r">客服中心</a><br>
        <a class="pc-right-item-link" href="{{ route('front.shop.charge.index') }}">線上儲值</a>  
    </div>
</div>
@stop

@section('content')


<div id="mycarousel" class="carousel slide hidden-sm hidden-md hidden-lg" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#mycarousel" data-slide-to="0" class="active"></li>
    <li data-target="#mycarousel" data-slide-to="1"></li>
    <li data-target="#mycarousel" data-slide-to="2"></li>
    <li data-target="#mycarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item">
        <img src="{{ asset('front/img/home/phone/P01_04.png') }}"/>
        <a href="{{ route('front.shop.share_transaction.index') }}"><div class="m-link"></div></a>
    </div>
    <div class="item">
        <img src="{{ asset('front/img/home/phone/P01_01.png') }}"/>
    </div>
    <div class="item">
        <img src="{{ asset('front/img/home/phone/P01_02.png') }}"/>
    </div>
    <div class="item">
        <img src="{{ asset('front/img/home/phone/P01_03.png') }}"/>
    </div>
  </div>

</div>

<div id="pccarousel" class="carousel slide hidden-xs" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#pccarousel" data-slide-to="0" class="active"></li>
    <li data-target="#pccarousel" data-slide-to="1"></li>
    <li data-target="#pccarousel" data-slide-to="2"></li>
    <li data-target="#pccarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item">
        <img src="{{ asset('front/img/home/web/P01_04.png') }}"/>
        <a href="{{ route('front.shop.share_transaction.index') }}"><div style="width:100%; height:100%;"></div></a>
    </div>
    <div class="item">
        <img src="{{ asset('front/img/home/web/P01_01.png') }}"/>
    </div>
    <div class="item">
        <img src="{{ asset('front/img/home/web/P01_02.png') }}"/>
    </div>
    <div class="item">
        <img src="{{ asset('front/img/home/web/P01_03.png') }}"/>
    </div>
  </div>

</div>

<!-- PC -->
   
    <!--BANNER
    <div class="home-banner pc_layout">
        <img src="{{ asset('front/img/banner.jpg') }}" style="width:100%;"/>
        <ul class="rslides">
            @foreach($banners as $banner)
              @if($banner->url == '' || $banner->url == ' ')
              <li><img src="{{ env('UPLOAD_URL').$banner->filepath }}" alt=""></li>
              @else
              <li><a href="{{ $banner->url }}" target="_blank"><img src="{{ env('UPLOAD_URL').$banner->filepath }}" alt=""></a></li>
              @endif
            @endforeach
          
        </ul>
    </div>-->
    <!--/.BANNER-->

    <div class="row pc_layout" style="display:none;">
        <div class="col-md-6">
             <h3>最新消息</h3>
            <a href="{{ route('front.news.index') }}">MORE</a>
            <!--最新消息-->
            <table class="table">
                <thead>
                    <th>標題</th>
                    <th>公告日期</th>
                </thead>
                <tbody>
                @foreach($news as $news_item)
                <tr>
                    <td><a href="{{ route('front.news.show',$news_item->id) }}">{{ $news_item->title }}</a></td>
                    <td>{{ $news_item->post_date }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <!--/.最新消息-->
            
        </div>
        <div class="col-md-6">
            <h3>會員留言</h3>
            <a  href="{{ route('front.board_message.index') }}">MORE</a>
             <!--留言板-->
            <table class="table">
                <thead>
                    <th>留言人</th>
                    <th>內容</th>
                    <th>新增日期</th>
                </thead>
                <tbody>
                @foreach($messages as $message)
                <tr>
                    <td>{{ $message->member->name }}</td>
                    <td>{{ $message->content }}</td>
                    <td>{{ $message->created_at }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <!--/.留言版-->

        </div>
      
    </div>
<!-- PC -->


@stop

@section('footer-js')
<!--Slide-->
<script src="{{ asset('plugins/ResponsiveSlides/responsiveslides.min.js') }}"></script>

<script>
  $(function() {
    $(".rslides").responsiveSlides();
  });
</script>

<script>
var $item = $('#mycarousel .item'); 
    
var $wHeight = $(window).height();
$item.eq(0).addClass('active');
$item.height($wHeight); 
$item.addClass('full-screen');

$('#mycarousel img').each(function() {
  var $src = $(this).attr('src');
  var $color = $(this).attr('data-color');
  $(this).parent().css({
    'background-image' : 'url(' + $src + ')',
    'background-color' : $color
  });
  $(this).remove();
});

$(window).on('resize', function (){
  $wHeight = $(window).height();
  $item.height($wHeight);
});

$('#mycarousel').carousel({
  interval: 8000,
  pause: "false"
});
    
$("#mycarousel").swipe({

  swipe: function(event, direction, distance, duration, fingerCount, fingerData) {

    if (direction == 'left') $(this).carousel('next');
    if (direction == 'right') $(this).carousel('prev');

  },
  allowPageScroll:"vertical"

});
    
</script>


<script>
var $pcitem = $('#pccarousel .item'); 
    
var $pcwHeight = $(window).height();
$pcitem.eq(0).addClass('active');
$pcitem.height($pcwHeight); 
$pcitem.addClass('full-screen');

$('#pccarousel img').each(function() {
  var $src = $(this).attr('src');
  var $color = $(this).attr('data-color');
  $(this).parent().css({
    'background-image' : 'url(' + $src + ')',
    'background-color' : $color
  });
  $(this).remove();
});

$(window).on('resize', function (){
  $pcwHeight = $(window).height();
  $pcitem.height($pcwHeight);
});

$('#pccarousel').carousel({
  interval: 8000,
  pause: "false"
});
</script>
@stop
