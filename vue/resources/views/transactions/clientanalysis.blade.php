@extends('layouts.app')

@section('title','Client Analysis')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="d-flex">
            <h3>Client Analysis</h3>
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
			@if(count($users)>0)
				<div class="table-responsive">
					<table class="table table-centered table-nowrap mb-0">
                        <thead class="thead-light">
							<tr>
								<th>No.</th>
								<th>Client </th>
								<th>Orders </th>
								<th>Amount</th>
							
							</tr>
						</thead>
						<tbody>
							@foreach($users as $key=> $user)
							    @php
							        $totalpaid=App\Order::where('user_id',$user->id)->where('paid',1)->sum('amount');
                                    $orders=App\Order::where('user_id',$user->id)->count();
                                @endphp
							<tr>
								<td>{{$key+1}}</td>	
								<td><a href="{{ url('/profile',$user->id) }}">{{ucfirst($user->name)}}</a></td>							
								<td>{{$orders}}</td>
								<td>${{$totalpaid}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
            @else
            <p>No transactions found.</p>
            @endif
            </div>
		</div>
	</div>
</div>
                        
</div>
@endsection