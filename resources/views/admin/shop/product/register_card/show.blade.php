@extends('layouts.blank') @section('head')

@stop 

@section('content') 

<h3>#{{ $data->id }} - {{ $data->name }} ({!! config('shop.product.status.'.$data->status) !!})</h3>
<hr>
<h4>基本資訊</h4>
<ul class="list-group">  
	<li class="list-group-item"><b>商品類型： </b>{{ $data->category->name }}</li>
    <li class="list-group-item"><b>商品名稱： </b>{{ $data->name }}</li>
    <li class="list-group-item"><b>結構樹級別名稱： </b>{{ $data->info->tree_name }}</li>
    <li class="list-group-item"><b>費用： </b>{{ $data->price }}</li>
    <li class="list-group-item"><b>數量： </b>@if($data->subtract == 1){{ $data->quantity }}@else 不限數量 @endif</li>
    <li class="list-group-item"><b>用途： </b>{{ $data->description }}</li>
    <li class="list-group-item"><b>新增時間： </b>{{ $data->created_at }}</li>
</ul>

<h4>參數資訊</h4>

<ul class="list-group">  
    <li class="list-group-item"><b>紅利： </b>{{ $data->info->interest*100 }}%</li>
    <li class="list-group-item"><b>使用者回饋金： </b>{{ $data->info->member_feedback }}</li>
    <li class="list-group-item" style="display:none;"><b>推薦者回饋金： </b>{{ $data->info->recommender_feedback }}</li>
    <li class="list-group-item"><b>卡片有效天數：</b>{{ $data->info->period or '無限期' }}</li>
    <li class="list-group-item"><b>回饋金領取有效天數： </b>{{ $data->info->feedback_period or '無限期' }}</li>
</ul>


<!-- /.box-body -->
@stop 