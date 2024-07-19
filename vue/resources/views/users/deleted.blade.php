@extends('layouts.app')

@section('title','Deactivated Users')
@section('content')

@if(Auth::user()->role==1)  

<div class="row">
    <div class="col-12">
        <div class="d-flex">
            <h3>Deactivated Users</h3>
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
						<thead>
							<tr>
								<th>Client</th>
								<th>Email</th>
								<th>Role</th>
								<th>Orders Placed</th>
								<th>Join Date</th>
							</tr>
						</thead>
						<tbody>
							@if(count($inactives)>0)				
							@foreach($inactives as $client)	
							@php
    							if($client->role==3){
    							$orders=App\Order::where('user_id',$client->id)->count();	
    							}else{
    								$orders=App\Order::where('tutor_id',$client->id)->count();
    							}
							@endphp					
							<tr>
							    <td><a href="{{ url('/profile',$client->id) }}">{{ucfirst($client->name)}}</a></td>
								<td>{{$client->email}}</td>
								<td>@if($client->role==3) Student @else Tutor @endif</td>
								<td>{{$orders}}</td>
								<td nowrap="true">{{$client->created_at->format('m-d-Y')}}</td>
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
@endif
@endsection