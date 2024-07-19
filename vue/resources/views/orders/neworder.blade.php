<!DOCTYPE html>
@extends('layouts.app')

@section('title','New Order')
@section('content')

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
     <style>
       
.dropzone, .dropzone * {
    box-sizing: border-box;
}
.dropzone {
    min-height: 150px;
    border: 2px solid rgba(0, 0, 0, 0.3);
    border-radius: 5px;
    background: white;
    padding: 54px 54px;
}
.dropzone.dz-clickable {
    cursor: pointer;
}
.dropzone.dz-clickable * {
    cursor: default;
}
.dropzone.dz-clickable .dz-message, .dropzone.dz-clickable .dz-message * {
    cursor: pointer;
}
.dropzone.dz-started .dz-message {
    display: none;
}
.dropzone.dz-drag-hover {
    border-style: solid;
}
.dropzone.dz-drag-hover .dz-message {
    opacity: 0.5;
}
.dropzone .dz-message {
    text-align: center;
    margin: 2em 0;
}
.dropzone .dz-preview {
    position: relative;
    display: inline-block;
    vertical-align: top;
    margin: 16px;
    min-height: 100px;
}
.dropzone .dz-preview:hover {
    z-index: 1000;
}
.dropzone .dz-preview:hover .dz-details {
    opacity: 1;
}
.dropzone .dz-preview.dz-file-preview .dz-image {
    border-radius: 20px;
    background: #999;
    background: linear-gradient(to bottom, #eee, #ddd);
}
.dropzone .dz-preview.dz-file-preview .dz-details {
    opacity: 1;
}
.dropzone .dz-preview.dz-image-preview {
    background: white;
}
.dropzone .dz-preview.dz-image-preview .dz-details {
    -webkit-transition: opacity 0.2s linear;
    -moz-transition: opacity 0.2s linear;
    -ms-transition: opacity 0.2s linear;
    -o-transition: opacity 0.2s linear;
    transition: opacity 0.2s linear;
}
.dropzone .dz-preview .dz-remove {
    font-size: 14px;
    text-align: center;
    display: block;
    cursor: pointer;
    border: none;
}
.dropzone .dz-preview .dz-remove:hover {
    text-decoration: underline;
}
.dropzone .dz-preview:hover .dz-details {
    opacity: 1;
}
.dropzone .dz-preview .dz-details {
    z-index: 20;
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    font-size: 13px;
    min-width: 50%;
    max-width: 50%;
    padding: 2em 1em;
    text-align: center;
    color: rgba(0, 0, 0, 0.9);
    line-height: 150%;
}
.dropzone .dz-preview .dz-details .dz-size {
    margin-bottom: 1em;
    font-size: 16px;
}
.dropzone .dz-preview .dz-details .dz-filename {
    white-space: nowrap;
}
.dropzone .dz-preview .dz-details .dz-filename:hover span {
    border: 1px solid rgba(200, 200, 200, 0.8);
    background-color: rgba(255, 255, 255, 0.8);
}
.dropzone .dz-preview .dz-details .dz-filename:not(:hover) {
    overflow: hidden;
    text-overflow: ellipsis;
}
.dropzone .dz-preview .dz-details .dz-filename:not(:hover) span {
    border: 1px solid transparent;
}
.dropzone .dz-preview .dz-details .dz-filename span, .dropzone .dz-preview .dz-details .dz-size span {
    background-color: rgba(255, 255, 255, 0.4);
    padding: 0 0.4em;
    border-radius: 3px;
}
.dropzone .dz-preview:hover .dz-image img {
    -webkit-transform: scale(1.05, 1.05);
    -moz-transform: scale(1.05, 1.05);
    -ms-transform: scale(1.05, 1.05);
    -o-transform: scale(1.05, 1.05);
    transform: scale(1.05, 1.05);
    -webkit-filter: blur(8px);
    filter: blur(8px);
}
.dropzone .dz-preview .dz-image {
    border-radius: 20px;
    overflow: hidden;
    width: 220px;
    height: 220px;
    position: relative;
    display: block;
    z-index: 10;
}
.dropzone .dz-preview .dz-image img {
    display: block;
}
.dropzone .dz-preview.dz-success .dz-success-mark {
    -webkit-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    -moz-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    -ms-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    -o-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
}
.dropzone .dz-preview.dz-error .dz-error-mark {
    opacity: 1;
    -webkit-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    -moz-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    -ms-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    -o-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
}
.dropzone .dz-preview .dz-success-mark, .dropzone .dz-preview .dz-error-mark {
    pointer-events: none;
    opacity: 0;
    z-index: 500;
    position: absolute;
    display: block;
    top: 50%;
    left: 50%;
    margin-left: -27px;
    margin-top: -27px;
}
.dropzone .dz-preview .dz-success-mark svg, .dropzone .dz-preview .dz-error-mark svg {
    display: block;
    width: 54px;
    height: 54px;
}
.dropzone .dz-preview.dz-processing .dz-progress {
    opacity: 1;
    -webkit-transition: all 0.2s linear;
    -moz-transition: all 0.2s linear;
    -ms-transition: all 0.2s linear;
    -o-transition: all 0.2s linear;
    transition: all 0.2s linear;
}
.dropzone .dz-preview.dz-complete .dz-progress {
    opacity: 0;
    -webkit-transition: opacity 0.4s ease-in;
    -moz-transition: opacity 0.4s ease-in;
    -ms-transition: opacity 0.4s ease-in;
    -o-transition: opacity 0.4s ease-in;
    transition: opacity 0.4s ease-in;
}
.dropzone .dz-preview:not(.dz-processing) .dz-progress {
    -webkit-animation: pulse 6s ease infinite;
    -moz-animation: pulse 6s ease infinite;
    -ms-animation: pulse 6s ease infinite;
    -o-animation: pulse 6s ease infinite;
    animation: pulse 6s ease infinite;
}
.dropzone .dz-preview .dz-progress {
    opacity: 1;
    z-index: 1000;
    pointer-events: none;
    position: absolute;
    height: 16px;
    left: 50%;
    top: 50%;
    margin-top: -8px;
    width: 80px;
    margin-left: -40px;
    background: rgba(255, 255, 255, 0.9);
    -webkit-transform: scale(1);
    border-radius: 8px;
    overflow: hidden;
}
.dropzone .dz-preview .dz-progress .dz-upload {
    background: #333;
    background: linear-gradient(to bottom, #666, #444);
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    width: 0;
    -webkit-transition: width 300ms ease-in-out;
    -moz-transition: width 300ms ease-in-out;
    -ms-transition: width 300ms ease-in-out;
    -o-transition: width 300ms ease-in-out;
    transition: width 300ms ease-in-out;
}
.dropzone .dz-preview.dz-error .dz-error-message {
    display: block;
}
.dropzone .dz-preview.dz-error:hover .dz-error-message {
    opacity: 1;
    pointer-events: auto;
}
.dropzone .dz-preview .dz-error-message {
    pointer-events: none;
    z-index: 1000;
    position: absolute;
    display: block;
    display: none;
    opacity: 0;
    -webkit-transition: opacity 0.3s ease;
    -moz-transition: opacity 0.3s ease;
    -ms-transition: opacity 0.3s ease;
    -o-transition: opacity 0.3s ease;
    transition: opacity 0.3s ease;
    border-radius: 8px;
    font-size: 13px;
    top: 130px;
    left: -10px;
    width: 140px;
    background: #be2626;
    background: linear-gradient(to bottom, #be2626, #a92222);
    padding: 0.5em 1.2em;
    color: white;
}
.dropzone .dz-preview .dz-error-message:after {
    content:'';
    position: absolute;
    top: -6px;
    left: 64px;
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 6px solid #be2626;
}
    </style>
@php

$subjects=App\Subject::orderBy('subject','ASC')->get();
$types=App\Type::orderBy('type','ASC')->get();
$levels=App\Academic::orderBy('level','ASC')->get();
$languages=App\Language::orderBy('language','ASC')->get();
$styles=App\Style::orderBy('style','ASC')->get();
$budgets=App\Budget::orderBy('pages','ASC')->get();
$string=rand(10000,100000);
$tempid=md5($string);
@endphp


                    
<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
			
				<form class="form-horizontal"  enctype="multipart/form-data" method="post" action="{{ url('/create-project') }}">
					{{ csrf_field() }}
					<input type="hidden" value="{{$tempid}}" name="tempid"/>
					<div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
						<label for="inputAddress"> Order Title</label>
						<input type="text" class="form-control" name="title" id="inputAddress" value="{{ old('title') }}" required="true" placeholder="Write about...">
						@if ($errors->has('title'))
						<span class="help-block">
							<strong>{{ $errors->first('title') }}</strong>
						</span>
						@endif
					</div>
					
					<div class="form-row">
						<div class="form-group col-md-6 {{ $errors->has('subject') ? ' has-error' : '' }}">
							<label for="inputEmail4">Subject</label>
							<select name="subject" class="form-control">
								@if(count($subjects)>0)
								@foreach($subjects as $subject)
								<option value="{{$subject->id}}">{{$subject->subject}}</option>
								@endforeach
								@endif
							</select>
							@if ($errors->has('subject'))
							<span class="help-block">
								<strong>{{ $errors->first('subject') }}</strong>
							</span>
							@endif
						</div>
						<div class="form-group col-md-6 {{ $errors->has('typeofpaper') ? ' has-error' : '' }}">
							<label for="inputPassword4">Type of Paper</label>
							<select name="typeofpaper" class="form-control">
								@if(count($types)>0)
								@foreach($types as $type)

								<option value="{{$type->id}}">{{$type->type}}</option>
								@endforeach
								@endif
							</select>
							@if ($errors->has('typeofpaper'))
							<span class="help-block">
								<strong>{{ $errors->first('typeofpaper') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4 {{ $errors->has('academic') ? ' has-error' : '' }}">
							<label for="inputEmail4">Academic Level</label>
							<select name="academic" class="form-control">
								@if(count($levels)>0)
								@foreach($levels as $level)
								<option value="{{$level->id}}">{{$level->level}}</option>
								@endforeach
								@endif
							</select>
							@if ($errors->has('academic'))
							<span class="help-block">
								<strong>{{ $errors->first('academic') }}</strong>
							</span>
							@endif
						</div>
						<div class="form-group col-md-4 {{ $errors->has('language') ? ' has-error' : '' }}">
							<label for="inputPassword4">Language</label>
							<select name="language" class="form-control">
								@if(count($languages)>0)
								@foreach($languages as $language)

								<option value="{{$language->id}}">{{$language->language}}</option>
								@endforeach
								@endif
							</select>
							@if ($errors->has('language'))
							<span class="help-block">
								<strong>{{ $errors->first('language') }}</strong>
							</span>
							@endif
						</div>
						<div class="form-group col-md-4 {{ $errors->has('style') ? ' has-error' : '' }}">
							<label for="inputPassword4">Formating Style</label>
							<select name="style" class="form-control">
								@if(count($styles)>0)
								@foreach($styles as $style)

								<option value="{{$style->id}}">{{$style->style}}</option>
								@endforeach
								@endif
							</select>
							@if ($errors->has('styles'))
							<span class="help-block">
								<strong>{{ $errors->first('style') }}</strong>
							</span>
							@endif
						</div>
					</div>
					
					<div class="form-row">
						<div class="form-group col-md-4 {{ $errors->has('pages') ? ' has-error' : '' }}">
							<label for="inputEmail4">Pages</label>
							<input type="number" name="pages" required="true"  value="{{ old('pages') }}"  class="form-control" min="0" id="inputAddress2" placeholder="No. of pages">
							@if ($errors->has('pages'))
							<span class="help-block">
								<strong>{{ $errors->first('pages') }}</strong>
							</span>
							@endif
						</div>
						<div class="form-group col-md-4 {{ $errors->has('sources') ? ' has-error' : '' }}">
							<label for="inputPassword4">Sources</label>
							<input type="number" class="form-control"  value="{{ old('sources') }}" min="0" name="sources" required="true"  id="inputAddress2" placeholder="No. of citations ">
							@if ($errors->has('sources'))
							<span class="help-block">
								<strong>{{ $errors->first('sources') }}</strong>
							</span>
							@endif
						</div>
						<div class="form-group col-md-4 {{ $errors->has('deadline') ? ' has-error' : '' }}">
                            <label for="inputPassword4">Deadline</label>
                            
							@if ($errors->has('deadline'))
							<span class="help-block">
								<strong>{{ $errors->first('deadline') }}</strong>
							</span>
							@endif
						</div>
					</div>
				
					<div class="form-group {{ $errors->has('budget') ? ' has-error' : '' }}">
						<label for="inputAddress"> Order Budget</label>
						<select name="budget" class="form-control" required="true">
								@if(count($budgets)>0)
								@foreach($budgets as $budget)
								<option value="{{$budget->amount}}">{{$budget->pages}} - $ {{$budget->amount}}</option>
								@endforeach
								@endif
							</select>
						@if ($errors->has('budget'))
						<span class="help-block">
							<strong>{{ $errors->first('budget') }}</strong>
						</span>
						@endif
					</div>
					<div class="form-row">
						<div class="form-group col-md-12 {{ $errors->has('instructions') ? ' has-error' : '' }}">
							<label for="inputEmail4">Paper instructions</label>
							<textarea width="100%" id="detailsee" name="instructions" >{{ old('instructions') }}</textarea>
						</div>
						@if ($errors->has('instructions'))
						<span class="help-block">
							<strong>{{ $errors->first('instructions') }}</strong>
						</span>
						@endif
       
					</div>
						
							
    
  

 
					<button type="submit" class="btn btn-primary  shadow-btn">Submit Order</button>
				</form>
			</div>
		</div>
	</div>

