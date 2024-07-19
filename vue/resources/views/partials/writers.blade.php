@extends('layouts.app')
@section('title','Clients')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="d-flex">
            <h3>Active Writers</h3>
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
								<th scope="col">Avatar</th>
								<th scope="col">Name</th>
								<th scope="col">Email</th>
								<th scope="col">Status</th>                  
								<th scope="col" >Action</th>
							</tr>
						</thead>
						<tbody>
							@if(count($writers)>0)
							@foreach ( $writers as $key=>$client )
							@php
									$orders=App\Order::where('user_id',$client->id)->count();
									@endphp	
							<tr>
								<td>
									{{ $key+1 }}
								</td>
								<td>
									<img class="rounded-circle" src="{{ URL::asset('vue/public/assets/images/avatars/'.$client->avatar)}}" alt="icon" style="max-width:70px;">
								</td>
								<td>
									<p><a href="{{ url('/profile',$client->id) }}" >{{ $client->name }}</a></p>
								</td>
								<td>{{ $client->email }}</td>
                                <td>
                                    @if($client->verified==1)
                                    <span class="badge badge-pill badge-success">Verified</span>
                                    @else
                                    <span class="badge badge-pill badge-danger">Unverified</span>
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