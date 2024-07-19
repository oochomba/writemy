@extends('layouts.app')

@section('title',$order->id)

@section('page_css')
 
@endsection
<script src="{{ asset('js/app.js') }}" defer></script>
@section('content')
<br/>
@php									
$date = $order->duedate;
$newDate = date("m-d-Y ", strtotime($date));
$t=time();
$str=$order->duedate;
$timestamp = strtotime($str)-$t;
function secondsToTime($seconds) {
$dtF = new \DateTime('@0');
$dtT = new \DateTime("@$seconds");
return $dtF->diff($dtT)->format('%ad %hh %imins ');
}
$client=App\User::findOrFail($order->user_id);
if($order->tutor_id!=""){
$tutor=App\User::findOrFail($order->tutor_id);

}
$types=App\Typesofarticle::findOrFail($order->typeofarticle);
$levels=App\Articleslevel::findOrFail($order->authorrating);
$subjects=App\Subject::findOrFail($order->subject);
$bids=App\Bid::where('question_id',$order->id)->orderBy('created_at','DESC')->get();
$tutors=App\User::where('role',4)->get();
$umessages=App\Message::where('order_id',$order->id)->where('status',0)->where('to',Auth::user()->id)->get();
$ofiles=App\Orderfile::where('question_id',$order->id)->where('is_deleted',0)->get();
$sfiles=App\Solutionfile::where('question_id',$order->id)->where('is_deleted',0)->get();
$revisions=App\Revision::where('question_id',$order->id)->orderBy('created_at','DESC')->get();
@endphp
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
	
				<h4 class="card-title">PROJECT OVERVIEW</h4>
			
	
				<!-- Nav tabs -->
				<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
					<li class="nav-item">
						<a class="nav-link " data-toggle="tab" href="#home1" role="tab">
							<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>

							@php
							$count=count ($bids) ;
							if($count>0){
								$class=1;
							}else {
								$class=0;
							}
							@endphp
							<span class="d-none d-sm-block">Bids 
							@if($class==1)
							<span style="font-size: 13px" class="badge badge-pill badge-danger ">{{ $count }}</span>
							@else
							<span class="badge badge-pill badge-success ">{{ $count }}</span>
							@endif	
							</span> 
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#order" role="tab">
							<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
							<span class="d-none d-sm-block">Project Details</span> 
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#profile1" role="tab">
							<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
							<span class="d-none d-sm-block">Chat Room</span> 
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#messages1" role="tab">
							<span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
							<span class="d-none d-sm-block">Attached Files 
								@php
								$countss=count ($ofiles) ;
								if($countss>0){
									$classs=1;
								}else {
									$classs=0;
								}
								@endphp
								@if($classs==1)
								<span style="font-size: 13px" class="badge badge-pill badge-danger ">{{ $countss }}</span>
								@else
								<span class="badge badge-pill badge-success ">{{ $countss }}</span>
								@endif	
								 </span>   
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#settings1" role="tab">
							<span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
							<span class="d-none d-sm-block">Solution Files
								@php
								$countsssss=count ($sfiles) ;
								if($countsssss>0){
									$classss=1;
								}else {
									$classss=0;
								}
								@endphp
								@if($classss==1)
								<span style="font-size: 13px" class="badge badge-pill badge-danger ">{{ $countsssss }}</span>
								@else
								<span class="badge badge-pill badge-success ">{{ $countsssss }}</span>
								@endif	
							</span>    
						</a>
					</li>
				</ul>
	
				<!-- Tab panes -->
				<div class="tab-content p-3 text-muted">
					<div class="tab-pane active" id="order" role="tabpanel">
					@include('partials.articlesproject')
					</div>
					<div class="tab-pane " id="home1" role="tabpanel">
						<div class="row">
							<div>
								@include('partials.placebid')
							
							</div>
							@include('partials.bids')
						</div>
					</div>
					<div class="tab-pane" id="profile1" role="tabpanel" >
						<div class="container" id="app">
							<chat-app :user="{{ auth::user() }}"></chat-app>
						</div>
					</div>
					<div class="tab-pane" id="messages1" role="tabpanel">
						@include('partials.ofiles')
					</div>
					<div class="tab-pane" id="settings1" role="tabpanel">
						<p class="mb-0">
							@include('partials.sfiles')
						</p>
					</div>
				</div>
	
			</div>
		</div>
	</div>
</div>



	@endsection