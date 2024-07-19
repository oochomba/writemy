@extends('layouts.app')

@section('title','Withdrawal Transactions')
@section('content')
@php
$tutor=App\Wallet::where('user_id',Auth::user()->id)->first();
@endphp
      <div class="row">
                         <div class="col-md-12">
					
				
	<div class="card">
		<div class="card-body">
			<div class="d-flex justify-content-between align-items-center">
				<h5>Withdrawal Transactions</h5>
				
			</div>
			<div class="m-t-30">
			@if(count($transactions)>0)
				<div class="table-responsive">
					<table class="table table-centered table-nowrap mb-0">
                        <thead class="thead-light">
							<tr>
								<th>No.</th>
								<th>User</th>
								<th>Amount</th>
                                <th>Wallet balance</th>		
                                <th>Status</th>				
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
								<td>{{$pay->balance}}</td>
								
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
                    
                    	<div id="makewith" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
															
						<h4 class="modal-title">Withdraw Funds</h4>
					</div>
					<div class="modal-body">
					
					<p>Your available balance is $<b>{{$tutor->balance}}</b></p>
															
											
						<form method="post" action="{{URL::to('/make-withdrawal')}}" role="form" class="form-horizontal ">
						{{ csrf_field() }}
											
						<label for="language" class=" control-label"><strong>Amount</strong></label>
						<input type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="amount" class="form-control" placeholder="Amount Paid " required="true"/>
											
									
					</div>
					<div class="modal-footer">
						<input type="submit" value="Withdraw Funds" class="btn btn-sm btn-success"/>
						</form>
						<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</div>
		</div>
@endsection