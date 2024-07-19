@extends('layouts.app')

@section('title','Inbox')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="d-flex">
            <h3>Inbox</h3>
            <div class="breadcrumb m-0">
               <a href="javascript: void(0);">{{ date('m-d-Y') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table- mb-0 table-hover">
					    <thead class="thead-light">
								<tr>
									<th>Received From:</th>
									<th>Message:</th>
									<th>Order ID:</th>
									<th>Date/Time:</th>
								</tr>
						</thead>
						<tbody >
							@if(count($messages)>0)
							@foreach($messages as $message)
							@php
							$files=App\Messagefile::where('message_id',$message->id)->get();
							$mto=App\User::findOrFail($message->mto);
							$mfrom=App\User::findOrFail($message->mfrom);
							@endphp 
							<tr>
								<th>{{ucfirst($mfrom->name)}}</th>
								<td><a href="{{ url('/order',$message->order_id) }}">{!! \Illuminate\Support\Str::limit($message->message, $limit = 65, $end = '...') !!}</a></td>
								<td>{{$message->order_id}}</a></td>
								<td nowrap>{{$message->created_at->format('m-d-Y, H:i A')}}</td>
							</tr>
							@endforeach
							@else 
							<p>No Messages Found</p>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
</div>
@endsection