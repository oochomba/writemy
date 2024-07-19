@extends('layouts.frontend')
@section('canonical','register')
@section('title','Sign Up | Write My Paper for Me')
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
	</style>

    <div class="container">
        <div class="column left-column d-none-mobile">
            <h2>Easy Registration Process</h2>
            <p>Submit your order to create your account automnatically.</p>
            <p><a class="btn_main" href="/order">register here</a></p>
        </div>
        <div class="column right-column">
            <p>Already have an account? Log in here!</p>
            <form method="POST" class="form-horizontal" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="username">E-mail</label><br>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                    @if($errors->has('email'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('email') }}</strong></span>
                    @endif
                </div><br><br>
                <div class="form-group">
                    <label for="userpassword">Password</label><br>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                    @if($errors->has('password'))
                        <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('password') }}</strong></span>
                    @endif
                </div><br>
                <div class="mt-3"><button class="btn btn_main" type="submit">Log In</button></div><br>
                <div class="mt-4"><a href="{{ url('password/reset') }}" style="font-weight:500">Forgot your password?</a></div><br>
            </form>           
        </div>
    </div>
@stop
