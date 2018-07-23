<!--餘額-->
<div class="row hidden-xs" style="padding: 0px 10%;">
    <!--金幣-->
    <div class="col-xs-6 col-sm-3 col-account">
        <div class="amount-area">
            <div class="account-amount-icon">
                <img src="{{ asset('front/img/icon/usercoin/user_bg_gold_01.png') }}"/>
            </div>
            <div class="account-amount-font">
                {{ number_format($account_amount['cash']) }}
            </div>
        </div>

    </div>
    
    <!--娛樂幣-->
    <div class="col-xs-6 col-sm-3 col-account">
        <div class="amount-area">
            <div class="account-amount-icon">
                <img src="{{ asset('front/img/icon/usercoin/user_bg_ulg_01.png') }}"/>
            </div>
            <div class="account-amount-font">
                {{ number_format($account_amount['right']) }}
            </div>
        </div>
    </div>
    
    <!--紅利-->
    <div class="col-xs-6 col-sm-3 col-account">
        <div class="amount-area">
            <div class="account-amount-icon">
                <img src="{{ asset('front/img/icon/usercoin/user_bg_bonus_01.png') }}"/>
            </div>
            <div class="account-amount-font">
                {{ number_format($account_amount['interest']) }}
            </div>
        </div>
    </div>
    
    <!--禮券-->
    <div class="col-xs-6 col-sm-3 col-account">
        <div class="amount-area">
            <div class="account-amount-icon">
                <img src="{{ asset('front/img/icon/usercoin/user_bg_gift_01.png') }}"/>
            </div>
            <div class="account-amount-font">
                {{ number_format($account_amount['run']) }}
            </div>
        </div>
    </div>
</div>
<!--/.餘額-->
