@extends('layouts.app')

@section('title','Clients')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="d-flex">
            <h3>Recent Clients</h3>
            <div class="breadcrumb m-0">
               <a href="javascript: void(0);">{{ date('m-d-Y') }}</a>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->role==1)                 
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table  table-hover">
						<thead class="thead-light">
							<tr>
								<th scope="col" style="width: 70px;">#</th>
								<th scope="col">Name</th>
								<th scope="col">Email</th>
								<th scope="col">Orders</th>                  
								<th scope="col" >Action</th>
							</tr>
						</thead>
						<tbody style="font-size:14px">
							@if(count($clients)>0)
							@foreach ( $clients as $key=>$client )
							@php
									$orders=App\Order::where('user_id',$client->id)->count();
									@endphp	
							<tr>
								<td>
									{{ $key+1 }}
								</td>
								<td>
									<p><a href="#" class="text-dark">{{ $client->name }}</a></p>
									<p class="text-muted mb-0">{{ $client->phone }}</p>
								</td>
								<td>{{ $client->email }}</td>
							   
								<td>
									{{$orders}}
								</td>
								<td>
									<a href="{{ url('/profile',$client->id) }}">View Profile</a>
								</td>
							   
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