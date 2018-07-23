<!--期別&倒數-->
<div class="row header-row">
    <div class="col-sm-2">
        <img class="chess-header-bg" src="{{ asset('front/img/chess/phone/reel_open_01.png') }}">
        <div class="chess-header-text" style="text-align:center;">
            <span>NO. </span><span id="sport_number">{{ $chessService->info("sport_number") }}</span>
            <br><input type="hidden" id="sport_id" value="{{ $chessService->info("sport_id") }}" />
        </div>
        
    </div>

    <!--最新開獎-->
    <div class="col-sm-6">
        <div id="latest_lottery_part">
			@include('front.game.cn_chess.web.latest_lottery')
		</div>
    </div>
   
    <div class="col-sm-2">
        <img class="chess-time-bg" src="{{ asset('front/img/chess/phone/reel_open_01.png') }}">
        <div class="chess-header-text">
                <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                    <span class="sr-only"></span>
                  </div>
                </div>

                <div class="text-right">
                    <span id="js_count"></span>  
                </div>    

        </div>
    </div>

</div>
<!--/.期別&倒數-->





<!--
<div id="result">SSE count</div>
<div id="showbox">SSE count</div>
<div id="showbox2">SSE count</div>
-->
<!--/.期別&倒數-->

