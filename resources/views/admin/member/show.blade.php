@extends('layouts.blank') @section('head')

@stop 

@section('content') 

<h3>{{ $data->name }} ({{ $data->user->username }}) - #{{ $data->member_number }}</h3>
<hr>
<h4>基本資訊</h4>
<ul class="list-group">  
    <li class="list-group-item"><b>手機：{{ $data->phone }} </b></li>
    <li class="list-group-item"><b>推薦人： </b>@if($data->recommender){{ $data->recommender->name  }}@else 無 @endif</li>
    <li class="list-group-item"><b>會員等級： </b>{{ $level  }}  (到期時間：{{ $level_expire }})</li>
</ul>

<h4>帳號狀態  @if($data->show_status == '0') <span style="color:red;">(此帳號已刪除隱藏，無法使用)</span> @endif</h4>
<ul class="list-group">
	<li class="list-group-item"><b>帳號登入狀態：</b>{!! config('member.user.login_permission.'.$data->user->login_permission) !!}</li>
    <li class="list-group-item"><b>第一次簡訊認證：</b>{!! config('member.status.'.$data->confirm_status) !!}</li>
    <li class="list-group-item"><b>第一次重設密碼：{!! config('member.status.'.$data->reset_pwd_status) !!} </b></li>
    <li class="list-group-item"><b>是否已被安置：{!! config('member.status.'.$data->place_status) !!} </b></li>
    <li class="list-group-item"><b>是否已同意使用者規範：{!! config('member.status.'.$data->agree_status) !!} </b></li>
    <li class="list-group-item"><b>最後活動時間：{{ $data->user->last_activity_at or '無'}} </b></li>

</ul>

<h4>銀行資訊</h4>
<ul class="list-group">
    <li class="list-group-item"><b>銀行代號：</b>{{ $data->bank_code }} </b></li>
    <li class="list-group-item"><b>銀行帳號：</b>{{ $data->bank_account }} </b></li>
</ul>

<h4>帳戶餘額資訊</h4>
<ul class="list-group">
	@foreach($data->accounts as $account)
	@if($account->type != 5)
    <li class="list-group-item"><b>{!! config('member.account.type.'.$account->type) !!}：</b>{{ number_format($account->amount) }} </b></li>
    @endif
    @endforeach
</ul>

<h4>帳號更名紀錄</h4>
<table class="table">
	<tr>
		<th>變更時間</th>
		<th>變更紀錄</th>
	</tr>
	@foreach($transfer_ownership_records as $t_record)
	<tr>
		<td>{{ $t_record->updated_at }}</td>
		<td>{{ $t_record->old_name }}（{{ $t_record->old_username }}） >>  {{ $t_record->name }}（{{ $t_record->username }}）</td>
	</tr>
	@endforeach
</table>

<!-- /.box-body -->
@stop 