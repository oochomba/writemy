@extends('layouts.app')

@section('title','New Order')
@section('content')

@php
$subjects=App\Subject::orderBy('subject','ASC')->get();
$types=App\Type::orderBy('type','ASC')->get();
$levels=App\Academic::orderBy('level','ASC')->get();
$languages=App\Language::orderBy('language','ASC')->get();
$styles=App\Style::orderBy('style','ASC')->get();
@endphp
                    
<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
			
				<form class="form-horizontal"  enctype="multipart/form-data" method="post" action="{{ url('/updated-project') }}">
					{{ csrf_field() }}
					<input type="hidden" value="{{$order->id}}" name="oid"/>
			
					<div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
						<label for="inputAddress"> Order Title</label>
						<input type="text" class="form-control" name="title" id="inputAddress" value="{{$order->title}}" required="true" placeholder="Write about...">
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
							<label for="inputPassword4">Type of Paper</label>
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
							<label for="inputEmail4">Academic Level</label>
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
							<label for="inputPassword4">Language</label>
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
							<label for="inputPassword4">Formating Style</label>
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
							<label for="inputEmail4">Pages</label>
							<input type="number" name="pages" required="true"  value="{{$order->pages}}"  class="form-control" min="0" id="inputAddress2" placeholder="Apartment, studio, or floor">
							@if ($errors->has('pages'))
							<span class="help-block">
								<strong>{{ $errors->first('pages') }}</strong>
							</span>
							@endif
						</div>
						<div class="form-group col-md-4 {{ $errors->has('sources') ? ' has-error' : '' }}">
							<label for="inputPassword4">Sources</label>
							<input type="number" class="form-control"  value="{{$order->sources}}" min="0" name="sources" required="true"  id="inputAddress2" placeholder="Apartment, studio, or floor">
							@if ($errors->has('sources'))
							<span class="help-block">
								<strong>{{ $errors->first('sources') }}</strong>
							</span>
							@endif
						</div>
						<div class="form-group col-md-4 {{ $errors->has('deadline') ? ' has-error' : '' }}">
							<label for="inputPassword4">Deadline</label>
							<input id="datetimepicker" readonly="true" value="{{date("m-d-Y H:i", strtotime($order->duedate))}}"  onclick="calculateTime()" name="deadline" required="true" class="form-control" type="text" >
							@if ($errors->has('deadline'))
							<span class="help-block">
								<strong>{{ $errors->first('deadline') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12 {{ $errors->has('instructions') ? ' has-error' : '' }}">
							<label for="inputEmail4">Paper instructions</label>
							<textarea width="100%" id="detailsee" name="instructions" >{!!$order->instructions!!}</textarea>
						</div>
						@if ($errors->has('instructions'))
						<span class="help-block">
							<strong>{{ $errors->first('instructions') }}</strong>
						</span>
						@endif
       
					</div>
					<button type="submit" class="btn btn-primary shadow-btn">Update Order</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-lg-4">
		<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<h5 class="m-b-0">Quality Work Guaranteed</h5>
				
				</div>
				<div class="m-t-30">
					<div class="overflow-y-auto scrollable relative" style="height: 437px">
						<ul class="timeline p-t-10 p-l-10">
							<li class="timeline-item">
								<div class="timeline-item-head">
									<div class="avatar avatar-text avatar-sm bg-success">
										<span>M</span>
									</div>                                                                
								</div>
								<div class="timeline-item-content">
									<div class="m-l-10">
										<h5 class="m-b-5">Masters and PhD</h5>
										<p class="m-b-0">
											<span class="font-weight-semibold">Verified Scholars </span> 
											<span class="m-l-5"> Get exclusive access to Expert writers.</span>
										</p>
										<span class="text-muted font-size-13">
											<i class="fas fa-graduation-cap text-success"></i>
											<span class="m-l-5">All degrees Verified!</span>
										</span>
									</div>
								</div>
							</li>
							<li class="timeline-item">
								<div class="timeline-item-head">
									<div class="avatar avatar-text avatar-sm bg-warning">
										<span>R</span>
									</div>                                                                
								</div>
								<div class="timeline-item-content">
									<div class="m-l-10">
										<h5 class="m-b-5">Reviews and Rating</h5>
										<p class="m-b-0">
											<span class="font-weight-semibold">Check Scholars  </span> 
											<span class="m-l-5"> reviews from previous clients</span>
										</p>
										<span class="text-muted font-size-13">
											<i class="far fa-star text-warning"></i>
											<span class="m-l-5">All reviews are from verified sales</span>
										</span>
									</div>
								</div>
							</li>
							<li class="timeline-item">
								<div class="timeline-item-head">
									<div class="avatar avatar-text avatar-sm bg-danger">
										<span>P</span>
									</div>                                                                
								</div>
								<div class="timeline-item-content">
									<div class="m-l-10">
										<h5 class="m-b-5">Plagirism Free</h5>
										<p class="m-b-0">
											<span class="font-weight-semibold">0%</span> 
											<span class="m-l-5"> Plagirism tolerance. </span>
										</p>
										<span class="text-muted font-size-13">
											<i class="far fa-check-circle text-danger"></i>
											<span class="m-l-5">100% Original papers</span>
										</span>
									</div>
								</div>
							</li>
						
							<li class="timeline-item">
								<div class="timeline-item-head">
									<div class="avatar avatar-text avatar-sm bg-primary">
										<span>P</span>
									</div>                                                                
								</div>
								<div class="timeline-item-content">
									<div class="m-l-10">
										<h5 class="m-b-5">Page length</h5>
										<p class="m-b-0">
											<span class="font-weight-semibold">Approximately  </span> 
											<span class="m-l-5"> 275 words per page. </span>
										</p>
										<span class="text-muted font-size-13">
											<i class="far fa-clipboard"></i>
											<span class="m-l-5">Free Cover and Reference page</span>
										</span>
									</div>
								</div>
							</li>
						
						
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
                        
</div>
                    
         
           
       
@endsection
