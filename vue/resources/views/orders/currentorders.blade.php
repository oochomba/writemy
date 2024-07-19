@extends('layouts.app')

@section('title','Current Orders')
@section('content')
@php									

function secondsToTime($seconds) {
$dtF = new \DateTime('@0');
$dtT = new \DateTime("@$seconds");
return $dtF->diff($dtT)->format('%ad %hh %imins ');
}
$tutors=App\User::where('role',4)->get();
@endphp

				<div class="d-flex justify-content-between align-items-center">
					<h5>Recent Orders</h5>
				
				</div>
				@if(count($orders)>0)
				
				@foreach($orders as $order)
				@php
				$date = $order->duedate;
				$newDate = date("m-d-Y H:i A", strtotime($date));
				$t=time();
				$str=$order->duedate;
				$timestamp = strtotime($str)-$t;
				$subjects=App\Subject::findOrFail($order->subject);
				$types=App\Type::findOrFail($order->paper_type);
				$date = $order->duedate;
$newDate = date("m-d-Y H:i A", strtotime($date));

				@endphp
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<h6 class=""><a href="{{ url('/order',$order->id) }}"># {{$order->id}}</a></h6>
		
					
					<div class="">
						<span class="text-gray font-weight-semibold">@if($order->status==1)
									<span class=""> <span class="badge badge-pill badge-info">Bidding</span></span>
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
						<span class="m-h-5 text-gray">|</span>
						
						<span class="badge badge-pill badge-warning timer">Due Date <strong>{{$newDate}}</strong></span>
						<span class="badge badge-pill  timer">Timer <strong> @if(strtotime($str)>$t)
											<b style="color: #23AF00">{{secondsToTime($timestamp)}}</b>
											@else
											<b style="color: #FF0000"> {{secondsToTime($timestamp)}}</b>
											@endif</strong></span>
						
					</div>
			
				<p class="m-b-20"><a href="{{ url('/order',$order->id) }}">{{$order->title}}</a></p>
				
				<strong >Subject: </strong><span class="badge-pill badge-success badge-cyan">{{$subjects->subject}}</span>  <strong >Type of Paper: </strong> <span class="badge badge-info badge-default">{{$types->type}}</span> <strong >Pages: </strong> <span class="badge badge-pill badge-warning">{{$order->pages}}</span>
				
				 <div class="text-right">
                                            <a class="btn btn-hover font-weight-semibold" <a href="{{ url('/order',$order->id) }}">
                                                <span>Bids </span> <span class="badge badge-pill badge-warning pull-right">{{$order->bids}}</span>
                                            </a>
                                        </div>
			</div>
		</div>
	</div>
</div>			
				@endforeach
							
							
			
		@else
		<p class="text-center">No orders found.</p>
		@endif
	
@endsection