@extends('layouts.main')
@section('head')
@stop

@section('content')

<h1>會員專區</h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item active">會員專區</li>
</ol>
<!--/.路徑-->

<div class="row'">
    <div class="col-md-3">
        <h3>個人&社群</h3>
        <ul class="list-group">  
            <li class="list-group-item"><a href="{{ route('front.member.info') }}">個人資料瀏覽</a></li>
            <li class="list-group-item"><a href="{{ route('front.member.info_edit') }}">個人資料編輯</a></li>
            <li class="list-group-item"><a href="{{ route('front.member.reset_pwd') }}">重設密碼</a></li>   
            <li class="list-group-item"><a href="{{ route('front.login_record.search') }}">登入紀錄</a></li>
            <li class="list-group-item"><a href="{{ route('front.member.tree') }}">社群</a></li>
            <li class="list-group-item"><a href="{{ route('front.member.subs') }}">好友列表</a></li>
            
            
        </ul>
    </div>
    <div class="col-md-3">
        <h3>商城</h3>
        <ul class="list-group">  
            <li class="list-group-item"><a href="{{ route('front.shop.my_product') }}">我的商品</a></li>
            <li class="list-group-item"><a href="{{ route('front.shop.transaction') }}">商品取得紀錄</a></li>
            <li class="list-group-item"><a href="{{ route('front.shop.product_use_record') }}">商品使用紀錄</a></li>
            <li class="list-group-item"><a href="{{ route('front.shop.share_transaction.index') }}">交易平台</a></li>
        </ul>
    </div>
    <div class="col-md-3">
        <h3>帳戶</h3>
        <ul class="list-group">  
            <li class="list-group-item"><a href="{{ route('front.checkin.index') }}">簽到中心</a></li>
            <li class="list-group-item"><a href="{{ route('front.account.search') }}">帳戶明細</a></li>
            <li class="list-group-item"><a href="{{ route('front.shop.charge.index') }}">線上儲值</a></li>
            <li class="list-group-item"><a href="{{ route('front.shop.withdrawal.index') }}">紅包群發紀錄</a></li>
            <li class="list-group-item"><a href="{{ route('front.member.transfer_ownership_record.index') }}">會員帳號更名申請</a></li>
            <li class="list-group-item"><a href="{{ route('front.member.subs_delete_record.index') }}">好友帳戶刪除申請</a></li>
       
        </ul>

    </div>
    <div class="col-md-3">
        <h3>遊戲</h3>
        <ul class="list-group">  
            <li class="list-group-item"><a href="{{ route('front.page.show','game_instructions') }}">玩法說明</a></li>
            <li class="list-group-item"><a href="{{ route('front.bet_record.search') }}">個人遊戲歷程</a></li>
            <li class="list-group-item"><a href="{{ route('front.organization_bet_record.search') }}">社群遊戲歷程</a></li>   
            <li class="list-group-item"><a href="{{ route('front.cn_chess_history.index') }}">象棋開獎結果</a></li>
        </ul>
    </div>
</div>

@stop

@section('footer-js')

@stop
