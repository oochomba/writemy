@extends('layouts.app')

@section('title','My Bids')
@section('content')
@php									

function secondsToTime($seconds) {
$dtF = new \DateTime('@0');
$dtT = new \DateTime("@$seconds");
return $dtF->diff($dtT)->format('%ad %hh %imins ');
}
$tutors=App\User::where('role',4)->get();
@endphp

<div class="row">
	<div class="col-md-12">
	
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<h5>My Bids</h5>
				
				</div>
				<div class="m-t-30">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Title</th>
									<th>Due Date</th>
									<th>Subject</th>
									<th>Status</th>
									<th>Date Posted</th>
									
								</tr>
							</thead>
							<tbody>
							@if(count($orders)>0)				
							@foreach($orders as $order)
							@php
							$order=App\Order::where('id',$order->question_id)->first();
				$date = $order->duedate;
				$newDate = date("m-d-Y H:i A", strtotime($date));
				$t=time();
				$str=$order->duedate;
				$timestamp = strtotime($str)-$t;
				$subjects=App\Subject::findOrFail($order->subject);
				$types=App\Type::findOrFail($order->paper_type);
				$date = $order->duedate;
$newDate = date("m-d-Y H:i A", strtotime($date));

$bided=App\Bid::where('question_id',$order->id)->where('user_id',Auth::user()->id)->first();

				@endphp
				
								<tr>
									<td nowrap="true"><a href="{{ url('/order',$order->id) }}"> {{$order->id}}</a> @if($bided!="")
									<i class="far fa-check-circle text-success"></i>${{$bided->price}}
									@endif
									 </span></td>
									<td>
										<div class="d-flex align-items-center">
											<div class="d-flex align-items-center">
											
												<h6 class="m-l-10 m-b-0"><a href="{{ url('/order',$order->id) }}">{{$order->title}}</a></h6>
											</div>
										</div>
									</td>
									<td nowrap="true"> <strong> @if(strtotime($str)>$t)
											<b style="color: #23AF00">{{secondsToTime($timestamp)}}</b>
											@else
											<b style="color: #FF0000"> {{secondsToTime($timestamp)}}</b>
											@endif</strong></td>
									<td>{{$subjects->subject}}</td>
									<td>
										<div class="d-flex align-items-center">
												<span class="text-gray font-weight-semibold">@if($order->status==1)
									<span class=""> <span class="badge badge-pill badge-info">Bidding</span> 
									
									
									@elseif($order->status==2)
									<span class=""> <span class="badge badge-pill badge-warning">Assigned</span></span>
									@elseif($order->status==3)
									<span class=""> <span class="badge badge-pill badge-primary">Editting</span></span>
									@elseif($order->status==4)
									<span class=""> <span class="badge badge-pill badge-secondary">Revision</span></span>
									@elseif($order->status==5)
									<span class=""> <span class="badge badge-pill badge-success">Completed</span></span>
									@elseif($order->status==6)
									<span class=""> <span class="badge badge-pill badge-success">Approved</span></span>
										
									@else
									<span class=""> <span class="badge badge-pill badge-danger">Cancelled</span></span>
									@endif</span>
										</div>
									</td>
									<td nowrap="true">{{$order->created_at->format('m-d-Y')}}</td>
								</tr>
@endforeach
@endif
							
							
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
                        
</div>

	</div>
                        
</div>
@endsection