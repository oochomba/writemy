@extends('layouts.app')

@section('title',ucfirst($user->name))
@section('content')
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18">{{ ucfirst($user->name) }}</h4>
			
		</div>
	</div>
</div>
@include('partials.profile')
<script>
	var loadFile = function(event) {
		var reader = new FileReader();
		reader.onload = function(){
			var output = document.getElementById('output');
			output.style.height = '75px';
			output.style.width = '75px';
			output.src = reader.result;
		};
		reader.readAsDataURL(event.target.files[0]);
	};
</script>
@stop