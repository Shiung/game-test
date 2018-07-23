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