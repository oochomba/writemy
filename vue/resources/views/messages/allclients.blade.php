@extends('layouts.app')

@section('title','Compose Message')
@section('content')
<div class="row">
	<div class="col-md-6">
	
			@php
                $clients=App\User::where('role',3)->count();
            @endphp					
									
		<div class="card">
		<div class="card-header">
			<h4 class="card-title">Send Message To All Clients: <b>{{ $clients }}</b></h4>
		</div>
		<div class="card-body">
		
			<form  enctype="multipart/form-data" method="post" action="{{ url('/post-all-clients') }}">
			{{ csrf_field() }}

				<div class="form-row">
					<div class="form-group col-md-12 {{ $errors->has('subject') ? ' has-error' : '' }}">
					<label for="inputEmail4">Subject</label>
					<input type="text" name="subject" class="form-control" value="{{ old('subject') }}"/>
					
						
					</div>
				</div>
				
				<div class="form-row">
					<div class="form-group col-md-12 {{ $errors->has('yourmessage') ? ' has-error' : '' }}">
						<label for="inputEmail4">Your Message</label>
						<textarea width="100%" class="form-control" id="texteditor"  name="yourmessage" >{{ old('yourmessage') }}</textarea>
					</div>
					@if ($errors->has('yourmessage'))
					<span class="help-block">
						<strong>{{ $errors->first('yourmessage') }}</strong>
					</span>
					@endif
       
				</div>
			
		
			
				<button class="btn btn-info" type="submit">Send</button>	<a data-toggle="collapse" class="btn btn-default btn-sm pull-right" href="#collapseTwoDefault">Close</a>
			
			</form>
		</div>
	</div>
	</div>
</div>

@endsection