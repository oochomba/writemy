@extends('layouts.app')

@section('title','Staff')
@section('content')


<div class="row">
    <div class="col-12">
        <div class="d-flex">
            <h3>System Staff</h3>
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
						<thead >
							<tr>
								<th scope="col">#</th>
								<th scope="col">Name</th>
								<th scope="col">Email</th>
								<th scope="col">Role</th>                  
								<th scope="col" >Action</th>
							</tr>
						</thead>
						<tbody>
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
									<p><a href="#">{{ $client->name }}</a></p>
									<p class="text-muted mb-0">{{ $client->phone }}</p>
								</td>
								<td>{{ $client->email }}</td>
							   
								<td>
								@if ($client->role==1)
                                    <span class="badge badge-info">Admin</span>
                                @else
                                <span class="badge badge-warning">Manager</span>
                                @endif
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