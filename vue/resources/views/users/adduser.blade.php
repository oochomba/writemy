@extends('layouts.app')

@section('title','Add User')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="d-flex">
            <h3>Add User</h3>
            <div class="breadcrumb m-0">
               <a href="javascript: void(0);">{{ date('m-d-Y') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<form method="POST" action="{{ url('/post-add-user') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Name</label>
                        <input id="name" type="text"  name="name" value="{{ old('name') }}" required autofocus>
                        @if ($errors->has('name'))
                            <strong>{{ $errors->first('name') }}</strong>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">E-Mail Address</label>
                        <input id="email" type="email"  name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <strong>{{ $errors->first('email') }}</strong>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class=" control-label">Password</label>
                        <input id="password" type="password" name="password" required>
                        @if ($errors->has('password'))
                            <strong>{{ $errors->first('password') }}</strong>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('userole') ? ' has-error' : '' }}">
                        <label for="userole" >Assign Role</label>
                        <select name="userole">
                            <option value="3">Student</option>
                            <option value="4">Tutor</option>                                
                            <option value="2">Manager</option>
                            <option value="1">Admin</option>
                        </select>
                        @if ($errors->has('userole'))
                            <span class="help-block"><strong>{{ $errors->first('userole') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
			</div>
		</div>
    </div>
</div>
@endsection