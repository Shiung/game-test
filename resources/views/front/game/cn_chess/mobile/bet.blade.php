<!--下注區-->
<div id="bet_chip" class="hidden-sm hidden-md hidden-lg">
    <div class="row">
        <!--投注記錄按鈕-->
        <div class="col-xs-2 chip-col">
            <div class="bet-latest-btn">
                <img id="bet-latest-btn-close" onclick="m_bet_latest_open();setTimeout(m_bet_latest_open_animate, 100);" src="{{ asset('front/img/chess/phone/reel_icon_01.png') }}">
                <img id="bet-latest-btn-open" onclick="m_bet_latest_show();setTimeout(m_bet_record_content_show, 1000);" src="{{ asset('front/img/chess/phone/reel_icon_03.png') }}">
            </div>
            
            <div class="bet-latest-back">
                <img id="bet-latest-btn-back" onclick="m_bet_latest_back();" src="{{ asset('front/img/chess/phone/reel_close_01.png') }}">
            </div>
            
        </div>
        <!--金紅娛禮選擇-->
        <div class="col-xs-2 chip-col">
            <div class="circle_active1 chip circle_bottom_bg1" data-type="1">
                <img class="m-bet-bg" src="{{ asset('front/img/chess/phone/bet_icon/uncheck1.png') }}">
                <img class="m-bet-select display" src="{{ asset('front/img/chess/phone/bet_icon/currency1.png') }}">
            </div>
        </div>
        <div class="col-xs-2 chip-col">
            <div class="circle chip circle_bottom_bg3" data-type="3">
                <img class="m-bet-bg display" src="{{ asset('front/img/chess/phone/bet_icon/uncheck3.png') }}">
                <img class="m-bet-select" src="{{ asset('front/img/chess/phone/bet_icon/currency3.png') }}">
            </div>
        </div>
        <div class="col-xs-2 chip-col">
            <div class="circle chip circle_bottom_bg4" data-type="4">
                <img class="m-bet-bg display" src="{{ asset('front/img/chess/phone/bet_icon/uncheck4.png') }}">
                <img class="m-bet-select" src="{{ asset('front/img/chess/phone/bet_icon/currency4.png') }}">
            </div>
        </div>
        <div class="col-xs-2 chip-col">
            <div class="circle chip circle_bottom_bg2" data-type="2">
                <img class="m-bet-bg display" src="{{ asset('front/img/chess/phone/bet_icon/uncheck2.png') }}">
                <img class="m-bet-select" src="{{ asset('front/img/chess/phone/bet_icon/currency2.png') }}">
            </div>
        </div>
        <div class="col-xs-2 chip-col" style="text-align:right;">
            <img id="cancel_bet_0" class="m-bet-btn" src="{{ asset('front/img/chess/phone/icon_no_G.png') }}">
            <img id="cancel_bet" class="m-bet-btn" src="{{ asset('front/img/chess/phone/icon_no_B.png') }}">
        </div>
    </div>
</div>
<div id="bet_investment" class="hidden-sm hidden-md hidden-lg">
    <div class="row">
        <!--歷史開獎按鈕-->
        <div class="col-xs-2 chip-col">            
            
            <div class="bet-history-btn">
                <img id="bet-history-btn-close" onclick="m_bet_history_open();setTimeout(m_bet_history_open_animate, 100);" src="{{ asset('front/img/chess/phone/reel_icon_05.png') }}">
                <img id="bet-history-btn-open" onclick="m_bet_history_show();setTimeout(m_bet_history_content_show, 1000);" src="{{ asset('front/img/chess/phone/reel_icon_02.png') }}">
            </div>
            
            
            <div class="bet-history-back">
                <img id="bet-history-btn-back" onclick="m_bet_history_back();" src="{{ asset('front/img/chess/phone/reel_icon_04.png') }}">
            </div>
            
        </div>
        <!--幣值選擇-->
        <div class="col-xs-2 chip-col">
            <div class="circle investment circle_bottom_bg" data-amount="{{ $investment_bet_data[1]['amount'] }}" data-type="1">
                <img class="m-bet-bg" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[1]['name'].'_02.png') }}">
                <img class="m-bet-select display" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[1]['name'].'_01.png') }}">
            </div>
        </div>
        <div class="col-xs-2 chip-col">
            <div class="circle investment circle_bottom_bg" data-amount="{{ $investment_bet_data[2]['amount'] }}"  data-type="2">
                <img class="m-bet-bg display" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[2]['name'].'_02.png') }}">
                <img class="m-bet-select" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[2]['name'].'_01.png') }}">
                
            </div>
        </div>
        <div class="col-xs-2 chip-col">
            <div class="circle investment circle_bottom_bg" data-amount="{{ $investment_bet_data[3]['amount'] }}"  data-type="3">
                <img class="m-bet-bg display" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[3]['name'].'_02.png') }}">
                <img class="m-bet-select" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[3]['name'].'_01.png') }}">
            </div>
        </div>
        <div class="col-xs-2 chip-col">
            <div class="circle investment circle_bottom_bg" data-amount="{{ $investment_bet_data[4]['amount'] }}"  data-type="4">
                <img class="m-bet-bg display" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[4]['name'].'_02.png') }}">
                <img class="m-bet-select" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[4]['name'].'_01.png') }}">
            </div>
        </div>
        <div class="col-xs-2 chip-col" style="text-align:right;">
            <!--<button type="button" class="btn btn-info" id="confirm_bet" disabled>確定<br>投注</button>-->
            <img id="confirm_bet_0" class="m-bet-btn" src="{{ asset('front/img/chess/phone/icon_yes_G.png') }}">
            <img id="confirm_bet" class="m-bet-btn" src="{{ asset('front/img/chess/phone/icon_yes_R.png') }}">
        </div>
    </div>
</div>

<input type="hidden" id="config_data" value="{{ $config_data }}">
<!--/.下注區-->
