@extends('layouts.app')

@section('title','Compose Message')
@section('content')
<div class="row">
	<div class="col-md-6">
	    <a href="{{ url('/received-messages') }}" class="btn btn-sm btn-info">Go to Inbox</a>
	    <a href="{{ url('/sent-messages') }}" class="btn btn-sm btn-primary">Go to Outbox</a><br><br>
		<div class="card">
		<div class="card-header">
			<h4 class="card-title">Send Message</h4>
		</div>
		<div class="card-body">
		@php
		$rece=App\User::where('role',1)->first();
		$users=App\User::where('role',4)->orWhere('role',3)->orderBy('name','ASC')->get();
		@endphp
			<form  enctype="multipart/form-data" method="post" action="{{ url('/post-compose-message') }}">
			{{ csrf_field() }}

				<div class="form-row">
					<div class="form-group col-md-12 {{ $errors->has('messageto') ? ' has-error' : '' }}">
					<label for="inputEmail4">To</label>
					<select name="messageto" class="form-control">
					@if(Auth::user()->role==3||Auth::user()->role==4)
					<option value="{{$rece->id}}">{{ucfirst($rece->name)}}</option>
					@else
					@if(count($users)>0)
					@foreach($users as $user)
					<option value="{{$user->id}}">{{ucfirst($user->name)}}</option>
					@endforeach
					@endif
					@endif
					</select>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-12 {{ $errors->has('yourmessage') ? ' has-error' : '' }}">
						<label for="inputEmail4">Your Message</label>
						<textarea width="100%" class="form-control"  name="yourmessage" >{{ old('yourmessage') }}</textarea>
					</div>
					@if ($errors->has('yourmessage'))
					<span class="help-block">
						<strong>{{ $errors->first('yourmessage') }}</strong>
					</span>
					@endif
       
				</div>
				<div class="form-row">
					<div class="form-group col-md-12 {{ $errors->has('yourmessage') ? ' has-error' : '' }}">
						<label for="inputEmail4">Attach file(s)</label>
						{!! Form::file('messagefiles[]', array('multiple'=>true,'value'=>'default')) !!}
							
						<p class="errors">{!!$errors->first('messagefiles')!!}</p>
						@if(Session::has('error'))
						<p class="errors">{!! Session::get('error') !!}</p>
																
						@endif
					</div>
					@if ($errors->has('messagefiles'))
					<span class="help-block">
						<strong>{{ $errors->first('messagefiles') }}</strong>
					</span>
					@endif
       
				</div>
				<button class="btn btn-info btn-sm" type="submit">Send</button>	<a data-toggle="collapse" class="btn btn-default btn-sm pull-right" href="#collapseTwoDefault">Close</a>
			</form>
		</div>
	</div>
	</div>
</div>

@endsection