@extends('layouts.app')

@section('title','Completed Orders')
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
    <div class="col-12">
        <div class="d-flex">
            <h3>Completed Orders</h3>
            <div class="breadcrumb m-0">
               <a href="javascript: void(0);">{{ date('m-d-Y') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead class="thead-light">
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Due Date</th>
								<th>Subject</th>
								<th>Status</th>
								<th>Posted</th>
							</tr>
						</thead>
						<tbody style="font-size:15px;">
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
							<tr>
								<td><a href="{{ url('/order',$order->id) }}">{{ $order->id }}</a></td>
								<td>{!! \Illuminate\Support\Str::limit($order->title,80) !!}</td>
								<td nowrap="true"> @if(strtotime($str)>$t)
									<b style="color: #23AF00">{{secondsToTime($timestamp)}}</b>
									@else
									<b style="color: #FF0000"> {{secondsToTime($timestamp)}}</b>
									@endif
								</td>
								<td>{{$subjects->subject}}</td>
								<td>
    							    <div class="d-flex align-items-center">
    									<span class="text-gray font-weight-semibold">@if($order->status==1)
    									<span class=""> <span class="badge badge-pill badge-info">Bidding</span></span>
    									@elseif($order->status==2)
    									<span class=""> <span class="badge badge-pill badge-warning">Assigned</span></span>
    									@elseif($order->status==3)
    									<span class=""> <span class="badge badge-pill badge-primary">Editing</span></span>
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
			{!!$orders->links('pagination::bootstrap-4')!!}
		</div>
	</div>
</div>
@endsection