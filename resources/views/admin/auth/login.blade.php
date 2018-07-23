@extends('layouts.blank')
@section('title','娛樂家管理系統')
@section('content')
<center>
<img src="{{ asset('front/img/logo.png') }}" height="50px">
<h3>{{ env("COMPANY_NAME") }}後台管理</h3>
</center>
<div class="login-box">
    <div class="panel panel-warning">
        <div class="panel-heading">
            系統登入
        </div>
        <div class="panel-body">
            <div class="login-box-body">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif {!! Form::open([ 'route' => 'admin.login.process', 'method' => 'post']) !!}

                <div class="form-group has-feedback">
                    <label for="username">帳號*</label> {!! Form::text('username', null, array( 'class'=>'form-control' ) ) !!}
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <label for="password">密碼*</label> {{ Form::password('password', array('class'=>'form-control' ) ) }}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <label for="captcha">記住我</label> {{ Form::checkbox('remember', 1, true) }}
                </div>
                
                


                <div class="row">
                    <center>
                        <input type="submit" class="btn btn-warning" value="登入">
                    </center>
                </div>

                {{ Form::close() }}

            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel-->
</div>
<!-- /.login-box--> 
@stop
