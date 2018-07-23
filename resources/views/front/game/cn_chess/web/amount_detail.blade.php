<img class="chess-amount-bg" src="{{ asset('front/img/chess/web/user_point_board.png') }}"/>

<!--會員資訊-->
<div class="chess-member">
    <table class="table table-member">
        <tr>
            <td class="member-td1">姓名</td>
            <td class="member-td2">{{ $member->name }}</td>
        </tr>
        <tr>
            <td class="member-td1">帳號</td>
            <td class="member-td2">{{ $user->username }}</td>
        </tr>
        <tr>
            <td class="member-td1">級別</td>
            <td class="member-td2">{{ $level  }}</td>
        </tr>
        <tr>
            <td class="member-td1">ID</td>
            <td class="member-td2">{{ $member->member_number }}</td>
        </tr>
    </table>
</div>
<!--/.會員資訊-->

<!--金幣-->
<div id="virtual_cash"></div>

<!--娛樂幣-->
<div id="share"></div>

<!--紅利-->
<div id="interest"></div>

<!--禮券-->
<div id="manage"></div>

<img id="bet-history-btn-open" onclick="bet_history_show();setTimeout(bet_history_content_show, 1000);" src="{{ asset('front/img/chess/web/reel_icon_01.png') }}">

<img id="bet-latest-btn-open" onclick="bet_latest_show();setTimeout(bet_record_content_show, 1000);" src="{{ asset('front/img/chess/web/reel_icon_02.png') }}">