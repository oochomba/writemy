@extends('layouts.frontend')
@section('title','Recover Account | Write My Paper for Me')
@section('canonical','password/reset')
@section('content')

	<style>
		body {
			background-color: #dcfce3;
		}
		.form-group {
		    line-height:2;
		    font-size:17px;
            font-weight:500;
		}
        .container {
            display: flex;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
            padding:170px 0;
        }
        .column {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
        }
        .right-column {
            background-color: #fff;
            margin: 0 50px;
            border-radius: 10px;
            text-align: center;
        }
        .left-column{
            display: flex;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }
        .label{
            font-size:20px;
        }
        .alert {
		    font-weight:500;
		    color:rgb(15, 128, 222);
		}
	</style>

    <div class="container">
        <div class="column left-column d-none-mobile">
            <h2>Reset Your Password</h2>
            <p>Forgot your password? Set a new one in easy steps!</p>
            <p><a class="btn_main" href="/order">register here</a></p>
        </div>
        <div class="column right-column">
            @if (session('status'))
                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                {{ csrf_field() }}
                <p>Enter your email address. You will receive a link to create a new password.</p><br>
                <div class="form-group">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('email') }}</strong></span>
                    @endif
                </div><br>
                <div class="form-group">
                    <button type="submit" class="btn_main">{{ __('Send Password Reset Link') }}</button>
                </div><br>
                <p>Remembered your password?<a href="{{ url('login') }}"> Log In</a></p>
            </form><br>
        </div>
    </div>
@stop