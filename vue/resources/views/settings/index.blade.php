@extends('layouts.app')

@section('title','System Settings')
@section('content')

@php
$subjects=App\Subject::orderBy('subject','ASC')->get();
$types=App\Type::orderBy('type','ASC')->get();
$levels=App\Academic::orderBy('level','ASC')->get();
$languages=App\Language::orderBy('language','ASC')->get();
$styles=App\Style::orderBy('style','ASC')->get();
$budgets=App\Budget::orderBy('pages','ASC')->get();
@endphp


@if(Auth::user()->role=="1"||Auth::user()->role=="2")

<div class="row">
<div class="col-md-6">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Order Budgets</h4>
		</div>
		<div class="card-body">
		
			<div class="">
				<button type="button" class="btn btn-sm btn-secondary shadow-btn" data-toggle="modal" data-target="#budgets" data-backdrop="static" data-keyboard="false">View Budgets</button>
				
				<button type="button" class="btn btn-sm btn-success shadow-btn" data-toggle="modal" data-target="#create-budge" data-backdrop="static" data-keyboard="false">Create </button>
				
				<button type="button" class="btn btn-sm btn-danger shadow-btn" data-toggle="modal" data-target="#delete-budget" data-backdrop="static" data-keyboard="false">Delete</button>
				
			</div>
			
		</div>
	</div> 
</div> 
<div class="col-md-6">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Order Subjects</h4>
		</div>
		<div class="card-body">
		
			<div class="">
				<button type="button" class="btn btn-sm btn-info shadow-btn"  data-toggle="modal" data-target="#subjects" >Subjects </button>
				
				<button type="button" class="btn btn-sm btn-success shadow-btn" data-toggle="modal" data-target="#create-subject" data-backdrop="static" data-keyboard="false">Create </button>
				
				<!--<button type="button" class="btn btn-sm btn-danger shadow-btn" data-toggle="modal" data-target="#delete-subjects" data-backdrop="static" data-keyboard="false">Delete</button>-->
				
			</div>
			
		</div>
	</div> 
</div> 
<div class="col-md-6">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Order Types</h4>
		</div>
		<div class="card-body">
		
			<div class="">
				<button type="button" class="btn btn-sm btn-secondary shadow-btn" data-toggle="modal" data-target="#types" data-backdrop="static" data-keyboard="false">View Types</button>
				
				<button type="button" class="btn btn-sm btn-success shadow-btn" data-toggle="modal" data-target="#create-type" data-backdrop="static" data-keyboard="false">Create </button>
				
			<!--	<button type="button" class="btn btn-sm btn-danger shadow-btn" data-toggle="modal" data-target="#delete-type" data-backdrop="static" data-keyboard="false">Delete</button>-->
				
			</div>
			
		</div>
	</div> 
</div> 
<div class="col-md-6">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Order Academic Level</h4>
		</div>
		<div class="card-body">
		
			<div class="">
				<button type="button" class="btn btn-sm btn-info shadow-btn"  data-toggle="modal" data-target="#levels" >View Academic Levels </button>
				
				<button type="button" class="btn btn-sm btn-success shadow-btn" data-toggle="modal" data-target="#create-level" data-backdrop="static" data-keyboard="false">Create </button>
				
				<!--<button type="button" class="btn btn-sm btn-danger shadow-btn" data-toggle="modal" data-target="#delete-level" data-backdrop="static" data-keyboard="false">Delete</button>-->
				
			</div>
			
		</div>
	</div> 
</div>
<div class="col-md-6">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Language of Writing</h4>
		</div>
		<div class="card-body">
		
			<div class="">
				<button type="button" class="btn btn-sm btn-secondary shadow-btn" data-toggle="modal" data-target="#language" data-backdrop="static" data-keyboard="false">View Language of Writing</button>
				
				<button type="button" class="btn btn-sm btn-success shadow-btn" data-toggle="modal" data-target="#create-language" data-backdrop="static" data-keyboard="false">Create </button>
				
			<!--	<button type="button" class="btn btn-sm btn-danger shadow-btn" data-toggle="modal" data-target="#delete-language" data-backdrop="static" data-keyboard="false">Delete</button>-->
				
			</div>
			
		</div>
	</div> 
</div> 
<div class="col-md-6">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Styles of Writing</h4>
		</div>
		<div class="card-body">
		
			<div class="">
				<button type="button" class="btn btn-sm btn-info shadow-btn"  data-toggle="modal" data-target="#styles" >View Styles of Writing</button>
				
				<button type="button" class="btn btn-sm btn-success shadow-btn" data-toggle="modal" data-target="#create-styles" data-backdrop="static" data-keyboard="false">Create </button>
				
			<!--	<button type="button" class="btn btn-sm btn-danger shadow-btn" data-toggle="modal" data-target="#delete-styles" data-backdrop="static" data-keyboard="false">Delete</button>-->
				
			</div>
			
		</div>
	</div> 
</div>

<div class="col-md-6">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Types of Articles</h4>
		</div>
		<div class="card-body">
		
			<div class="">
				<button type="button" class="btn btn-sm btn-info shadow-btn"  data-toggle="modal" data-target="#articlestypes" >View Articles Types</button>
				
				<button type="button" class="btn btn-sm btn-success shadow-btn" data-toggle="modal" data-target="#create-articlestypes" data-backdrop="static" data-keyboard="false">Create Articles Types </button>
				
			<!--	<button type="button" class="btn btn-sm btn-danger shadow-btn" data-toggle="modal" data-target="#delete-styles" data-backdrop="static" data-keyboard="false">Delete</button>-->
				
			</div>
			
		</div>
	</div> 
</div>
<div class="col-md-6">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Writers Levels</h4>
		</div>
		<div class="card-body">
		
			<div class="">
				<button type="button" class="btn btn-sm btn-info shadow-btn"  data-toggle="modal" data-target="#arleveels" >View Article Writers Levels</button>
				
				<button type="button" class="btn btn-sm btn-success shadow-btn" data-toggle="modal" data-target="#create-arleveels" data-backdrop="static" data-keyboard="false">Create Articles Levels </button>
				
			<!--	<button type="button" class="btn btn-sm btn-danger shadow-btn" data-toggle="modal" data-target="#delete-styles" data-backdrop="static" data-keyboard="false">Delete</button>-->
				
			</div>
			
		</div>
	</div> 
</div>
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Active Payment Gateway</h4>
		</div>
		<div class="card-body">
		
			<div class="">
			<div>	<button type="button" class="btn btn-sm btn-info shadow-btn"  data-toggle="modal" data-target="#pgs" >Payment Gateways </button>
			
			</div>
			<br/>
			@php
				$setpg=App\Pgsetting::orderBy('pgname','ASC')->get();
				@endphp
<div class="table-responsive">


	<table class="table table-striped">
		<tr>
			<th nowrap>#</th>
			<th nowrap>Gateway Name</th>
			<th nowrap>Client ID</th>
			<th nowrap>Client Secret</th>
			<th nowrap>Actions</th>
		</tr>
		@if(count($setpg)>0)
		@foreach($setpg as $key=> $pg)
			<tr>
				<th>{{ $key+1}}</th>
				<th>{{ ucfirst($pg->pgname) }}
					<br/>
				@if($pg->active==1)
				<span class="badge badge-success">Active</span>
				@else 
				<span class="badge badge-danger">Deactivated</span>
				@endif
				</th>
				<td>{{ $pg->pgclient }}</td>
				<td>{{ $pg->pgsecret }}</td>
				<td nowrap>
					<a href="{{ url('/edit-gateway', $pg->id) }}" class="btn btn-primary">Edit</a>
					<a href="{{ url('/delete-gateway', $pg->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</a>
				   
					@if($pg->active==0)
					<a href="{{ url('/activate-gateway', $pg->id) }}" class="btn btn-success">
					Activate
					</a>
					@else 
					<a href="{{ url('/activate-gateway', $pg->id) }}" class="btn btn-warning">Deactivate</a>
					@endif
					
				</td>
			</tr>
		@endforeach
		@endif
	</table>
</div>

				
				
				<!--<button type="button" class="btn btn-sm btn-danger shadow-btn" data-toggle="modal" data-target="#delete-level" data-backdrop="static" data-keyboard="false">Delete</button>-->
				
			</div>
			
		</div>
	</div> 
</div>
</div>

@endif
<div id="create-arleveels" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Create Article Levels</h4>
			</div>
			<div class="modal-body">	
				<form method="post" action="{{URL::to('/create-article-levels')}}" role="form" >
					{{ csrf_field() }}
		
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Article Writers Levels</label>
							<input type="text" class="form-control" name="rating" required="true"  placeholder="Article Writer Level">
						</div>
						<div class="form-group col">
							<label class="form-label" style="visibility: hidden"> Article Writers Levels</label>
							<input type="submit" value="Create Level" class="btn btn-success  btn-success"/>
						</div>
					</div>
				</form>
				
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="create-articlestypes" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Create Article Type</h4>
			</div>
			<div class="modal-body">	
				<form method="post" action="{{URL::to('/create-articlestypes')}}" role="form" >
					{{ csrf_field() }}
		
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Article Type</label>
							<input type="text" class="form-control" name="article" required="true"  placeholder="Article Type">
						</div>
						<div class="form-group col">
							<label class="form-label" style="visibility: hidden"> Article Type</label>
							<input type="submit" value="Create Article Type" class="btn btn-success  btn-success"/>
						</div>
					</div>
				</form>
				
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!--create-->
<div id="pgs" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Payment Gateways</h4>
			</div>
			<div class="modal-body">
					
						<div class="form-group col">
							<label class="">Select Gateway</label>
					<select name="paymentgateway" onChange="getData(this);" class="form-control">
						<option value="0">Select Payment Gateway</option>
						<option value="1">Paypal</option>
						<option value="2">Pesapal</option>
						<option value="3">Flutterwave</option>
						
					</select>
							@if ($errors->has('paymentgateway'))
							<span class="help-block">
								<strong>{{ $errors->first('paymentgateway') }}</strong>
							</span>
							@endif
						</div>

						@include('pgsets')
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="create-budge" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Create Budget</h4>
			</div>
			<div class="modal-body">	
				<form method="post" action="{{URL::to('/create-budget')}}" role="form" >
					{{ csrf_field() }}
		
					<div class="form-row">
					
						<div class="form-group col">
							<label class="form-label">Amount Payable</label>
							<input type="text" class="form-control" name="amount" required="true"  placeholder="Amount Payable">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Create Budget" class="btn btn-success  btn-success"/>
						</div>
					</div>
				</form>
				
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!--update-->
<div id="budgets" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Budgets</h4>
			</div>
			<div class="modal-body">
				@if(count($budgets)>0)
				@foreach($budgets as $budget)
										
				<form method="post" action="{{URL::to('/adjust-budget')}}" role="form" >
					{{ csrf_field() }}
					<input type="hidden" name="budget" value="{{$budget->id}}"/>
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Amount Payable</label>
							<input type="text" class="form-control" name="amount" value="{{$budget->amount}}" placeholder="Amount Payable">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Update Budget" class="btn btn-success  btn-success"/>
						</div>
					</div>
				</form>
				@endforeach
				@endif
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!--delete-->
<div id="delete-budget" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Delete Budget</h4>
			</div>
			<div class="modal-body">
				@if(count($budgets)>0)
				@foreach($budgets as $budget)
										
				<form method="post" action="{{URL::to('/delete-budget')}}" role="form" >
					{{ csrf_field() }}
		<input type="hidden" name="budget" value="{{$budget->id}}"/>
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Amount Payable</label>
							<input type="text" class="form-control" name="amount" readonly="true" value="{{$budget->amount}}" placeholder="Amount Payable">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Delete Budget" class="btn btn-danger  btn-success"/>
						</div>
					</div>
				</form>
				@endforeach
				@endif
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

<!--subjects start here-->
<div id="subjects" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Subjects</h4>
			</div>
			<div class="modal-body">
				@if(count($subjects)>0)
				@foreach($subjects as $subject)
										
				<form method="post" action="{{URL::to('/update-subject')}}" role="form" >
					{{ csrf_field() }}
					<input type="hidden" name="subjectid" value="{{$subject->id}}"/>
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Subject</label>
							<input type="text" class="form-control" name="subject" value="{{$subject->subject}}" placeholder="Subject">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Update Subject" class="btn btn-success  btn-success"/>
						</div>
					</div>
				</form>
				@endforeach
				@endif
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="create-subject" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Create Subject</h4>
			</div>
			<div class="modal-body">	
				<form method="post" action="{{URL::to('/create-subject')}}" role="form" >
					{{ csrf_field() }}
		
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Subject</label>
							<input type="text" class="form-control" name="subject" required="true"  placeholder="Order Subject">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Create Subject" class="btn btn-success  btn-success"/>
						</div>
					</div>
				</form>
				
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="delete-subjects" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Delete Subjects</h4>
			</div>
			<div class="modal-body">
				@if(count($subjects)>0)
				@foreach($subjects as $subject)
										
				<form method="post" action="{{URL::to('/delete-subject')}}" role="form" >
					{{ csrf_field() }}
					<input type="hidden" name="subjectid" value="{{$subject->id}}"/>
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Subject</label>
							<input type="text" class="form-control" name="subject" readonly="true" value="{{$subject->subject}}" placeholder="Subject">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Delete Subject" class="btn btn-danger  btn-success"/>
						</div>
					</div>
				</form>
				@endforeach
				@endif
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

<!--subjects end here-->

<!--types start here-->
<div id="types" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Types</h4>
			</div>
			<div class="modal-body">
				@if(count($types)>0)
				@foreach($types as $type)
										
				<form method="post" action="{{URL::to('/update-type')}}" role="form" >
					{{ csrf_field() }}
					<input type="hidden" name="typeid" value="{{$type->id}}"/>
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Type of Writing</label>
							<input type="text" class="form-control" name="type" value="{{$type->type}}" placeholder="Type">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Update Type" class="btn btn-success  btn-success"/>
						</div>
					</div>
				</form>
				@endforeach
				@endif
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="create-type" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Create Type</h4>
			</div>
			<div class="modal-body">	
				<form method="post" action="{{URL::to('/create-type')}}" role="form" >
					{{ csrf_field() }}
		
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Type</label>
							<input type="text" class="form-control" name="type" required="true"  placeholder="Order Type">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Create Type" class="btn btn-success  btn-success"/>
						</div>
					</div>
				</form>
				
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="delete-type" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Delete Type</h4>
			</div>
			<div class="modal-body">
				@if(count($types)>0)
				@foreach($types as $type)
										
				<form method="post" action="{{URL::to('/delete-type')}}" role="form" >
					{{ csrf_field() }}
					<input type="hidden" name="typeid" value="{{$type->id}}"/>
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Type</label>
							<input type="text" class="form-control" name="type" readonly="true" value="{{$type->type}}" placeholder="type">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Delete Type" class="btn btn-danger "/>
						</div>
					</div>
				</form>
				@endforeach
				@endif
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

<!--type end here-->

<!--Academic levels-->
<div id="levels" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Academic Levels</h4>
			</div>
			<div class="modal-body">
				@if(count($levels)>0)
				@foreach($levels as $level)
										
				<form method="post" action="{{URL::to('/update-level')}}" role="form" >
					{{ csrf_field() }}
					<input type="hidden" name="levelid" value="{{$level->id}}"/>
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Type of Writing</label>
							<input type="text" class="form-control" name="academic" value="{{$level->level}}" placeholder="Academic Level">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Update Academic Level" class="btn btn-success  btn-success"/>
						</div>
					</div>
				</form>
				@endforeach
				@endif
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="create-level" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Create Academic Level</h4>
			</div>
			<div class="modal-body">	
				<form method="post" action="{{URL::to('/create-level')}}" role="form" >
					{{ csrf_field() }}
		
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Academic Level</label>
							<input type="text" class="form-control" name="academic" required="true"  placeholder="Academic Level">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Create Academic Level" class="btn btn-success  btn-success"/>
						</div>
					</div>
				</form>
				
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="delete-level" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Delete Level</h4>
			</div>
			<div class="modal-body">
				@if(count($levels)>0)
				@foreach($levels as $level)
										
				<form method="post" action="{{URL::to('/delete-level')}}" role="form" >
					{{ csrf_field() }}
					<input type="hidden" name="academicid" value="{{$level->id}}"/>
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Academic Level</label>
							<input type="text" class="form-control" name="type" readonly="true" value="{{$level->level}}" placeholder="type">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Delete Academic Level" class="btn btn-danger "/>
						</div>
					</div>
				</form>
				@endforeach
				@endif
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!--End Academic levels-->

<!--Language of writing levels-->
<div id="language" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Language of Writing</h4>
			</div>
			<div class="modal-body">
				@if(count($languages)>0)
				@foreach($languages as $language)
										
				<form method="post" action="{{URL::to('/update-language')}}" role="form" >
					{{ csrf_field() }}
					<input type="hidden" name="languageid" value="{{$language->id}}"/>
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Language of Writing</label>
							<input type="text" class="form-control" name="language" value="{{$language->language}}" placeholder="Language of Writing">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Update Language" class="btn btn-success  btn-success"/>
						</div>
					</div>
				</form>
				@endforeach
				@endif
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="create-language" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Create Language</h4>
			</div>
			<div class="modal-body">	
				<form method="post" action="{{URL::to('/create-language')}}" role="form" >
					{{ csrf_field() }}
		
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Language of Writing</label>
							<input type="text" class="form-control" name="language" required="true"  placeholder="Language">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Create Language" class="btn btn-success  btn-success"/>
						</div>
					</div>
				</form>
				
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="delete-language" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Delete Language</h4>
			</div>
			<div class="modal-body">
				@if(count($languages)>0)
				@foreach($languages as $language)
										
				<form method="post" action="{{URL::to('/delete-language')}}" role="form" >
					{{ csrf_field() }}
					<input type="hidden" name="languageid" value="{{$language->id}}"/>
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Academic Level</label>
							<input type="text" class="form-control" name="language" readonly="true" value="{{$language->language}}" placeholder="Language">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Delete Academic Level" class="btn btn-danger "/>
						</div>
					</div>
				</form>
				@endforeach
				@endif
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!--End Language of writing levels-->

<!--Style of writing levels-->
<div id="styles" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Style of Writing</h4>
			</div>
			<div class="modal-body">
				@if(count($styles)>0)
				@foreach($styles as $style)
										
				<form method="post" action="{{URL::to('/update-style')}}" role="form" >
					{{ csrf_field() }}
					<input type="hidden" name="styleid" value="{{$style->id}}"/>
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Style of Writing</label>
							<input type="text" class="form-control" name="style" value="{{$style->style}}" placeholder="Style of Writing">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Update Style" class="btn btn-success  btn-success"/>
						</div>
					</div>
				</form>
				@endforeach
				@endif
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="create-styles" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Create Language</h4>
			</div>
			<div class="modal-body">	
				<form method="post" action="{{URL::to('/create-style')}}" role="form" >
					{{ csrf_field() }}
		
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Language of Writing</label>
							<input type="text" class="form-control" name="style" required="true"  placeholder="Language">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Create Language" class="btn btn-success  btn-success"/>
						</div>
					</div>
				</form>
				
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div id="delete-styles" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
															
				<h4 class="modal-title">Delete Style</h4>
			</div>
			<div class="modal-body">
					@if(count($styles)>0)
				@foreach($styles as $style)
										
				<form method="post" action="{{URL::to('/delete-style')}}" role="form" >
					{{ csrf_field() }}
					<input type="hidden" name="styleid" value="{{$style->id}}"/>
					<div class="form-row">
						
						<div class="form-group col">
							<label class="form-label">Academic Level</label>
							<input type="text" class="form-control" name="language" readonly="true" value="{{$style->style}}" placeholder="Style">
						</div>
						<div class="form-group col">
							<br />
							<input type="submit" value="Delete Style" class="btn btn-danger "/>
						</div>
					</div>
				</form>
				@endforeach
				@endif
											
			</div>
			<div class="modal-footer">
											
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!--End Style of writing levels-->

@endsection