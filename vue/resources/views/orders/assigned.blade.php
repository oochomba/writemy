@extends('layouts.app')

@section('title','Assigned Orders')
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
            <h3>Available Orders</h3>
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
				<div class="m-t-30">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead class="thead-light">
								<tr>
									<th>#</th>
									<th>Title</th>
									<th>Due Date</th>
									<th>Subject</th>
									<th>Cost</th>
									<th>Posted</th>
									
								</tr>
							</thead>
							<tbody style="font-size:15px">
						@if(count($orders)>0)				
							@foreach($orders as $order)
							@php
                				$date = $order->duedate;
                				$newDate = date("m-d-Y H:i A", strtotime($date));
                				$t=time();
                				$str=$order->duedate;
                				$timestamp = strtotime($str)-$t;
                				$subjects=App\Subject::findOrFail($order->subject);
                				$date = $order->duedate;
                                $newDate = date("m-d-Y H:i A", strtotime($date));
                                $bided=App\Bid::where('question_id',$order->id)->where('user_id',Auth::user()->id)->first();
                			@endphp
								<tr>
									<td nowrap="true"><a> {{$order->id}}</a></td>
									<td><a href="{{ url('/order',$order->id) }}">{{$order->title}}</a></td>
									<td nowrap="true"> @if(strtotime($str)>$t)
										<b style="color: #23AF00">{{secondsToTime($timestamp)}}</b>
											@else
										<b style="color: #FF0000"> {{secondsToTime($timestamp)}}</b>
											@endif
									</td>
									<td>{{$subjects->subject}}</td>
									<td>
										<div class="d-flex align-items-center">
											<span class="text-gray font-weight-semibold">
											   ${{$order->amount}}
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
			{!!$orders->links('pagination::bootstrap-4')!!}
		</div>
	</div>
</div>


                        

@endsection