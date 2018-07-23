<div id="bet_record_content">
    <a class="bet-record-close" onclick="m_bet_record_close();setTimeout(m_bet_record_close_animate_end, 1000);">
        <img src="{{ asset('front/img/chess/phone/icon_close.png') }}"/>
    </a>
    <!--近十筆下注紀錄-->
    <div class="reel-title">
        <img src="{{ asset('front/img/chess/phone/title_02.png') }}"/>
    </div>
    
    <div class="table-record-area">
        <table class="table table-record">
            <thead>
                <th>期別</th>
                <th>幣別</th>
                <th>金額</th>
                <th>下注棋</th>
            </thead>
            <tbody id="bets">

            </tbody>
        </table>    
    </div>

    <!--/.近十筆下注紀錄-->
</div>