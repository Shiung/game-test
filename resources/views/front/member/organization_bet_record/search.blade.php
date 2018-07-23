@extends('layouts.main')
@section('head')

@stop 

@section('content')

<h1>{{ $page_title }} </h1>

<!--路徑-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">會員專區</li>
    <li class="breadcrumb-item active">{{ $page_title }}</li>
</ol>
<!--/.路徑-->

<hr>
<form id="Form" method="GET" action="{{ route('front.organization_bet_record.index') }}">

    <div class="row">
        <div class="col-sm-6">
            <fieldset class="form-group">
                <label for="range">搜尋區間</label>
                <select class="form-control" id="range" name="range" >
                    @foreach(config('member.range') as $key => $item)
                    <option value="{{ $key }}">{{ $item }}</option>
                    @endforeach
                </select>
            </fieldset>
        </div>
        <div class="col-sm-6">
            <fieldset class="form-group">
                <label for="type">帳戶類型</label>
                <select class="form-control" id="account_type" name="account_type" >
                    <option value="all">全部</option>
                    @for($i=1;$i<5;$i++)
                    <option value="{{ $i }}">{{ config('member.account.type.'.$i) }}</option>
                    @endfor
                </select>
            </fieldset>  
        </div>
    </div>  

    <div class="row">
        <div class="col-sm-6">
            <fieldset class="form-group">
                <label for="range">遊戲類型</label>
                <select class="form-control" id="sport_type" name="sport_type" >
                    <option value="all">全部</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </fieldset>
        </div>
       <!-- <div class="col-sm-6">
            <fieldset class="form-group">
                <label for="type">賭盤類型</label>
                <select class="form-control" id="bet_type" name="bet_type" >
                    <option value="all">全部</option>
                    @foreach(config('game.sport.game.type') as $key => $item)
                    <option value="{{ $key }}">{{ $item }}</option>
                    @endforeach
                </select>
            </fieldset>  
        </div>-->
    </div>
 
    <!-- 額外資訊 -->
    <input type="hidden" id="bet_type" name="bet_type" value="all">
    <input type="hidden" id="user_type" name="user_type" value="own">
    <center>
        <button type="submit" class="btn btn-primary">確認搜尋</button>
    </center>
    
</form>

@stop

@section('footer-js')
<script src="{{ asset('plugins/validate/jquery.validate.min.js') }}"></script>
<script>
    $(document).ready(function() {

    });
</script>

@stop
