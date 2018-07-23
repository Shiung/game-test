<!--下注區-->
<div class="row">
    <div class="col-sm-5" style="padding-left: 0px; padding-right: 0px;">
        <div id="bet_chip">
            <div class="row">
                <!--金紅娛禮選擇-->
                <div class="col-sm-10 chip-col">
                    <div class="circle_active1 chip circle_bottom_bg1" data-type="1">
                        <img class="bet-bg" src="{{ asset('front/img/chess/phone/bet_icon/uncheck1.png') }}">
                        <img class="bet-select display" src="{{ asset('front/img/chess/phone/bet_icon/currency1.png') }}">
                    </div>
                </div>
                <div class="col-sm-10 chip-col">
                    <div class="circle chip circle_bottom_bg3" data-type="3">
                        <img class="bet-bg display" src="{{ asset('front/img/chess/phone/bet_icon/uncheck3.png') }}">
                        <img class="bet-select" src="{{ asset('front/img/chess/phone/bet_icon/currency3.png') }}">
                    </div>
                </div>
                <div class="col-sm-10 chip-col">
                    <div class="circle chip circle_bottom_bg4" data-type="4">
                        <img class="bet-bg display" src="{{ asset('front/img/chess/phone/bet_icon/uncheck4.png') }}">
                        <img class="bet-select" src="{{ asset('front/img/chess/phone/bet_icon/currency4.png') }}">
                    </div>
                </div>
                <div class="col-sm-10 chip-col">
                    <div class="circle chip circle_bottom_bg2" data-type="2">
                        <img class="bet-bg display" src="{{ asset('front/img/chess/phone/bet_icon/uncheck2.png') }}">
                        <img class="bet-select" src="{{ asset('front/img/chess/phone/bet_icon/currency2.png') }}">
                    </div>
                </div>
                <div class="col-sm-10 chip-col" style="text-align:center;">
                    <img id="cancel_bet_0" class="bet-btn" src="{{ asset('front/img/chess/web/icon_no_G.png') }}">
                    <img id="cancel_bet" class="bet-btn" src="{{ asset('front/img/chess/web/icon_no_B.png') }}">
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-5" style="padding-left: 0px; padding-right: 0px;">
        <div id="bet_investment">
            <div class="row">
                <!--幣值選擇-->
                <div class="col-sm-10 chip-col">
                    <div class="circle investment circle_bottom_bg" data-amount="{{ $investment_bet_data[1]['amount'] }}" data-type="1">
                        <img class="bet-bg" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[1]['name'].'_02.png') }}">
                        <img class="bet-select display" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[1]['name'].'_01.png') }}">
                    </div>
                </div>
                <div class="col-sm-10 chip-col">
                    <div class="circle investment circle_bottom_bg" data-amount="{{ $investment_bet_data[2]['amount'] }}"  data-type="2">
                        <img class="bet-bg display" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[2]['name'].'_02.png') }}">
                        <img class="bet-select" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[2]['name'].'_01.png') }}">
                    </div>
                </div>
                <div class="col-sm-10 chip-col">
                    <div class="circle investment circle_bottom_bg" data-amount="{{ $investment_bet_data[3]['amount'] }}"  data-type="3">
                        <img class="bet-bg display" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[3]['name'].'_02.png') }}">
                        <img class="bet-select" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[3]['name'].'_01.png') }}">
                    </div>
                </div>
                <div class="col-sm-10 chip-col">
                    <div class="circle investment circle_bottom_bg" data-amount="{{ $investment_bet_data[4]['amount'] }}"  data-type="4">
                        <img class="bet-bg display" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[4]['name'].'_02.png') }}">
                        <img class="bet-select" src="{{ asset('front/img/chess/phone/coin_bet_'.$investment_bet_data[4]['name'].'_01.png') }}">
                    </div>
                </div>
                <div class="col-sm-10 chip-col" style="text-align:center;">
                    <!--<button type="button" class="btn btn-info" id="confirm_bet" disabled>確定<br>投注</button>-->
                    <img id="confirm_bet_0" class="bet-btn" src="{{ asset('front/img/chess/web/icon_yes_G.png') }}">
                    <img id="confirm_bet" class="bet-btn" src="{{ asset('front/img/chess/web/icon_yes_R.png') }}">
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="config_data" value="{{ $config_data }}">
<!--/.下注區-->
