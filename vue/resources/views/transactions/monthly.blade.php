@extends('layouts.app')

@section('title','All Transactions')
@section('content')
@php
$tutor=App\Wallet::where('user_id',Auth::user()->id)->first();
$accbal=App\Credit::where('id',1)->first();
@endphp

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<br>
<div class="row">
    <div class="col-md-12">
	<div class="card">
		<div class="card-body">
			<div class="m-t-30">
			@if(count($transactions)>0)
				<div class="table-responsive">
					<table class="table table-centered table-nowrap mb-0">
                        <thead class="thead-light">
							<tr>
								<th>No.</th>
								<th>Billing Name</th>
								<th>Amount</th>
								<th>Order #</th>
								<th>Type</th>
								<th>Narration</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							@foreach($transactions as $key=> $pay)
							  @php
                                            $cname=App\User::where('id',$pay->user_id)->first();
                                            @endphp
							<tr>
								<td>{{$key+1}}</td>	
								<td><a href="{{ url('/profile',$cname->id) }}">{{ucfirst($cname->name)}}</a></td>							
								<td>{{$pay->amount}}</td>
								
								
								<td><a href="{{ url('/order',$pay->order_id) }}">{{$pay->order_id}}</a></td>
								<td>
									@if($pay->type==1)
									Bid Purchased
									@elseif($pay->type==2)
									Sold Bid
									@elseif($pay->type==3)
									Tip
									@elseif($pay->type==4)
									Debit
									@elseif($pay->type==5)
									Credit
									@elseif($pay->type==6)
									Payment Released
									@elseif($pay->type==7)
									Loaded Wallet
									@elseif($pay->type==8)
									Withdrawal
									@else
									@endif
								</td>
								<td>{{$pay->narration}}</td>
								<td nowrap="true">{{$pay->created_at->format('m-d-Y')}}</td>
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