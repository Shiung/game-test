@extends('layouts.front_blank') @section('head')

@stop 

@section('content') 
@inject('ProductPresenter','App\Presenters\Shop\ProductPresenter')
<h3>{{ $data->name }} </h3>
<p><b>用途： </b>{{ $data->description }}</p>
<hr>
<h4>基本資訊</h4>
<ul class="list-group">  
	<li class="list-group-item"><b>商品類型： </b>{{ $data->category->name }}</li>
    <li class="list-group-item"><b>價錢： </b>{{ number_format($data->price) }}</li>
    @if($quantity_show == 1)
    <li class="list-group-item"><b>數量： </b>{{ $ProductPresenter->showQuantity($data) }}</li>
    @endif
</ul>

<h4>參數資訊</h4>

<ul class="list-group">  
    <li class="list-group-item"><b>紅利： </b>{{ $data->info->interest*100 }}%</li>
    <li class="list-group-item"><b>使用者回饋金： </b>{{ number_format($data->info->member_feedback) }}</li>
    <li class="list-group-item"><b>卡片有效天數：</b>{{ $data->info->period or '無限期' }}</li>
    <li class="list-group-item"><b>回饋金領取有效天數： </b>{{ $data->info->feedback_period or '無限期' }}</li>
</ul>


<!-- /.box-body -->
@stop 