<div id="history_lottery_content">
    <a class="bet-history-close" onclick="m_bet_history_close();setTimeout(m_bet_history_close_animate_end, 1000);">
        <img src="{{ asset('front/img/chess/phone/icon_close.png') }}"/>
    </a>

    <!--歷史開獎近五期紀錄-->
    <div class="reel-title">
        <img src="{{ asset('front/img/chess/phone/title_01.png') }}"/>
    </div>
    
    <table class="table table-record">
        <thead>
            <th style="font-size:10px;">期別</th>
            <th style="font-size:10px;">開獎紀錄</th>
        </thead>
        <tbody id="history_lottery">

        </tbody>
    </table>
    <!--/.歷史開獎近五期紀錄-->
</div>