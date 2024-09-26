@extends('layouts.frontend')
@section('title','Set New Password | Write My Paper for Me')
@section('canonical','email')
@section('content')


	<style>
		body {background-color: #dcfce3;}.form-group {line-height:2;font-size:17px;font-weight:500;}.container {display:flex;flex-wrap:wrap;max-width:1200px;margin:0 auto;padding:170px 0;}
        .column {flex:1;padding:20px;box-sizing:border-box;}.right-column {background-color:#fff;margin:0 50px;border-radius:10px;text-align:center;}.left-column{display: flex;justify-content: center;flex-direction: column;text-align: center;}.label{font-size:20px;}
	</style>

    <div class="container">
        <div class="column left-column d-none-mobile">
            <h1>Set New Password</h1>
            <p>Regain access to your account by resetting your password. Follow simple steps to secure your account and continue using our services.</p>
        </div>
        <div class="column right-column">
            @if (session('status'))
                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('password.request') }}" aria-label="{{ __('Reset Password') }}">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                </div> <br>
                <div class="form-group row">
                    <label for="password">New Password</label>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                </div><br>
                <div class="form-group row">
                    <label for="password-confirm">Confirm New Password</label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div><br>
                <div class="mt-3">
                    <button type="submit" class="btn_order">
                        {{ __('Reset Password') }}
                    </button>
                </div>  
            </form> 
            <div class="mt-3">
                <p>Remembered your password? <a href="{{ url('login') }}">Sign in</a></p>
            </div>
        </div>
    </div>
@stop