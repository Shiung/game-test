@extends('layouts.blank') @section('head')

@stop 

@section('content') 

<h3>#{{ $data->id }} - {{ $data->name }} ({!! config('shop.product.status.'.$data->status) !!})</h3>
<hr>
<h4>基本資訊</h4>
<ul class="list-group">  
	<li class="list-group-item"><b>商品類型： </b>{{ $data->category->name }}</li>
    <li class="list-group-item"><b>商品名稱： </b>{{ $data->name }}</li>
    <li class="list-group-item"><b>費用： </b>{{ $data->price }}</li>
    <li class="list-group-item"><b>數量： </b>@if($data->subtract == 1){{ $data->quantity }}@else 不限數量 @endif</li>
    <li class="list-group-item"><b>用途： </b>{{ $data->description }}</li>
    <li class="list-group-item"><b>新增時間： </b>{{ $data->created_at }}</li>
</ul>



<!-- /.box-body -->
@stop 