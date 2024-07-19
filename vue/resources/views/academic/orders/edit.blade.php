@extends('layouts.app')
@section('title','New Order')
@section('content')

@section('content')
<link href="timepicker/jquery.datetimepicker.css"rel="stylesheet">


<script src="https://cdn.tiny.cloud/1/w75xwosb7fak6zrt4r2hs4wjnvc53o7luvz03yuivs0rjwvv/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'charmap emoticons image link table lists linkchecker',
    toolbar: 'blocks fontsize | numlist bullist',
  });
</script>

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

<style>
    .form-group{
        margin-bottom: 1px;
        margin-top: 1px;
        text-align:left;
        padding: 5px 5px;
        width: 100%;
    }
    .form-control{
        margin-bottom: 1px;
        margin-top: 1px;
        text-align:left;
        border: 1px solid #ddd;
    }
    .lable{
        line-height: 1.5em;
        font-size: 16px;
        font-weight:500;
    }
    .row1{line-height:2;}
    .advantages__itemq{
        margin:8px 20px;
        border:1px solid #ddd;
        border-radius:10px;
        cursor: pointer;
        background: #fff;
        padding:20px;
        text-align: center;
        box-shadow: 0 0 16px #ddd;
    }
    .form-row{
        display:flex;
        margin-top:11px;
    }

    .card {
        border: 1px solid #ddd;
        padding:14px 14px; 
        background: #ffff;
        border-radius: 10px;
    }
     .container {
        padding-top:15px;
    }
    .section-v2__heading {
       font-size:22px; 
       font-weight:bold;
       text-align:center;
    }
    .as_checkbox_wrapper label {
    	padding: 14px 18px 14px 22px;
    } 
    .as_checkbox_wrapper .as_checkbox {
    	display: flex;justify-content:space-around;
    }
    .as_checkbox_wrapper .as_checkbox .as_input {
	    padding: 0 1rem;
    }
    .as_checkbox_wrapper .as_body {
    	width: 70%;
    }
    .as_checkbox_wrapper .as_body .as_header {
    	display: flex;
    	justify-content: space-between;
    }
    .as_checkbox_wrapper .as_body .as_desc {
    	text-align: left;
    	font-size: 14px;
    }
</style>

                    
<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<form class="form-horizontal"  enctype="multipart/form-data" method="post" action="{{ url('/updated-project') }}">
					{{ csrf_field() }}
					<input type="hidden" value="{{$order->id}}" name="oid"/>
					<div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
						<label class="lable"  for="inputAddress">Order Title or Topic</label>
						<input type="text" class="form-control" name="title" id="inputAddress" value="{{$order->title}}" required="true" placeholder="Write about...">
						@if ($errors->has('title'))
						<span class="help-block">
							<strong>{{ $errors->first('title') }}</strong>
						</span>
						@endif
					</div>
					<div class="form-row">
						<div class="form-group col-md-6 {{ $errors->has('subject') ? ' has-error' : '' }}">
							<label class="lable" for="inputEmail4">Subject</label>
							<select name="subject" class="form-control">
								@if(count($subjects)>0)
								@foreach($subjects as $subject)
								<option value="{{$subject->id}}" {{($order->subject ==$subject->id) ? 'selected':''}}>{{ $subject->subject}}</option>
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
							<label class="lable" for="inputPassword4">Type of Paper</label>
							<select name="typeofpaper" class="form-control">
								@if(count($types)>0)
								@foreach($types as $type)
	                                <option value="{{$type->id}}" {{($order->paper_type ==$type->id) ? 'selected':''}}>{{$type->type}}</option>
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
							<label class="lable" for="inputEmail4">Academic Level</label>
							<select name="academic" class="form-control">
								@if(count($levels)>0)
								@foreach($levels as $level)
								<option value="{{$level->id}}" {{($order->academic ==$level->id) ? 'selected':''}}>{{$level->level}}</option>
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
							<label class="lable" for="inputPassword4">Language</label>
							<select name="language" class="form-control">
								@if(count($languages)>0)
								@foreach($languages as $language)
								<option value="{{$language->id}}" {{($order->language ==$language->id) ? 'selected':''}}>{{$language->language}}</option>
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
							<label class="lable" for="inputPassword4">Format</label>
							<select name="style" class="form-control">
								@if(count($styles)>0)
								@foreach($styles as $style)
								<option value="{{$style->id}}" {{($order->style ==$style->id) ? 'selected':''}}>{{$style->style}}</option>
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
							<label class="lable" for="inputEmail4">Pages</label>
							<input type="number" name="pages" required="true"  value="{{$order->pages}}"  class="form-control" min="0" id="inputAddress2" placeholder="No. of Pages">
							@if ($errors->has('pages'))
							<span class="help-block">
								<strong>{{ $errors->first('pages') }}</strong>
							</span>
							@endif
						</div>
						<div class="form-group col-md-4 {{ $errors->has('sources') ? ' has-error' : '' }}">
							<label class="lable" for="inputPassword4">Sources</label>
							<input type="number" class="form-control"  value="{{$order->sources}}" min="0" name="sources" required="true"  id="inputAddress2" placeholder="No. of Sources">
							@if ($errors->has('sources'))
							<span class="help-block">
								<strong>{{ $errors->first('sources') }}</strong>
							</span>
							@endif
						</div>
						<div class="form-group col-md-4 {{ $errors->has('deadline') ? ' has-error' : '' }}">
							<label class="lable" for="inputPassword4">Deadline</label>
							<input id="datetimepicker" readonly="true" value="{{date("m-d-Y H:i", strtotime($order->duedate))}}"  onclick="calculateTime()" name="deadline" required="true" class="form-control" type="text" >
							@if ($errors->has('deadline'))
							<span class="help-block">
								<strong>{{ $errors->first('deadline') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-row">
                        <div class="form-group col-md-6 {{ $errors->has('budget') ? ' has-error' : '' }}">
                            <label class="lable" class="lable" for="inputEmail4">Budget</label>
                            <select name="budget" class="form-control">
                                @if(count($budgets)>0)
                                @foreach($budgets as $budget)
                                <option value="{{$budget->amount}}">$ {{$budget->amount}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('budget'))
                            <span class="help-block">
                                <strong>{{ $errors->first('budget') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
					<div class="form-row">
						<div class="form-group col-md-12 {{ $errors->has('instructions') ? ' has-error' : '' }}">
							<label class="lable" for="inputEmail4">Paper Instructions</label>
							<textarea width="100%" id="detailsee" name="instructions" >{!!$order->instructions!!}</textarea>
						</div>
						@if ($errors->has('instructions'))
						<span class="help-block">
							<strong>{{ $errors->first('instructions') }}</strong>
						</span>
						@endif
					</div>
					<button type="submit" class="btn btn-primary">Update Order</button>
				</form>
			</div>
		</div>
	</div>
	
	<div class="col-lg-4">
            <div class="advantages__itemq">
                <div class="advantages__description">
                    <h2 style="font-size:22px">Free Services</h2>
                    <p>Draft Papers</p>
                    <p>Plagiarism Report</p>
                    <p>Grammarly Report</p>
                    <p>Bibliography /References</p>
                    <p>Title Page & Format</p>
                    <p>Table of Contents</p>
                    <P>Revisions on Request</P> 
                    <p>Links to Sources</p>
                    <p>24/7 Instant Chat</p>
                </div>
            </div>
            <div class="advantages__itemq">
                <div class="advantages__description">
                    <h2 style="font-size:20px">Money-Back Guarantee</h2>
                    <p>What you order is what you get! If not, you get a refund as stated in this <a href="/refund-policy" target="_blank">Refund Policy.</a></p>
                </div>
            </div>
    </div>
</div> 

<script src="timepicker/jquery.js"></script>

@endsection
