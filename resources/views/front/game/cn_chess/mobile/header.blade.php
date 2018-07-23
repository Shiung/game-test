<!--期別&倒數-->
<div class="row">
    <div class="col-xs-6">
        <img class="chess-header-bg" src="{{ asset('front/img/chess/phone/reel_open_01.png') }}">
        <div class="chess-header-text">
            <span>NO. </span><span id="sport_number">{{ $chessService->info("sport_number") }}</span>
            <br><input type="hidden" id="sport_id" value="{{ $chessService->info("sport_id") }}" />
        </div>
        
    </div>

    <div class="col-xs-6">
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
