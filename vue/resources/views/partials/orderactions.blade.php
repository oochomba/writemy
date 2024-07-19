@if( Auth::user()->role=="1"||Auth::user()->role=="2" )
	<a href="{{ url('/edit',$order->id) }}" class="btn  btn-primary">Edit Order</a>
	@elseif($order->status==1 && ($order->user_id==Auth::user()->id))
	<a href="{{ url('/edit',$order->id) }}" class="btn btn-primary">Edit Order</a>
	@endif
	@if(Auth::user()->role=="1"||Auth::user()->role=="2")
    	@if(Auth::user()->role=="1")
    	<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#markpaid" data-backdrop="static" data-keyboard="false">Mark as Paid</button>
    	@endif
		<button type="button" class="btn btn-success"  data-toggle="modal" data-target="#myModal">Assign Writer</button>
		<button type="button" class="btn  btn-warning" data-toggle="modal"  data-target="#changesstatus1" data-backdrop="static" data-keyboard="false">Change Status</button>
		<button type="button" class="btn  btn-primary" data-toggle="modal"  data-target="#sendinvoice" data-backdrop="static" data-keyboard="false">Send Invoice</button>
	@if( Auth::user()->role=='1' && $order->status==1)         
		@if(Auth::user()->role=="1")
		<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteOrder" data-backdrop="static" data-keyboard="false">Delete Order</button>
		@endif
		@endif
		@endif
	@if( Auth::user()->role=='1'||Auth::user()->role=='2')
		<div id="myModal" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header"><h4 class="modal-title">Assign Order</h4></div>
						<div class="modal-body">
							<p><b>Select Writer</b></p>
							@if(count($tutors)>0)
							<form method="post" action="{{URL::to('/assign-tutor')}}" role="form" class="form-horizontal">
									{{ csrf_field() }}
								<input type="hidden" name="orderID" value="{{$order->id}}"/>
							<select  class="form-control" name="tutor">
								@foreach($tutors as $tutor)
								<option value="{{$tutor->id}}">{{ucfirst($tutor->name)}}</option>
								@endforeach
							</select>
							<p><b>Writer Pay</b></p>
							<input type="" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="writerpay" class="form-control" value="{{ old('writerpay') }}"/>
							@endif
						</div>
						<div class="modal-footer">
							<input type="submit" value="Assign" class="btn btn-success"/>
							</form>
							<button type="button" class="btn  btn-default" data-dismiss="modal">Close</button>
						</div>
				</div>
			</div>
		</div>
		<div id="sendinvoice" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">Send Invoice</h4>
										</div>
										<div class="modal-body">
											<form method="post" action="{{URL::to('/send-invoice')}}" role="form" class="form-horizontal ">
											{{ csrf_field() }}
											<input type="hidden" name="orderID" value="{{$order->id}}"/>
											
											<label for="language" class=" control-label"><strong>Invoice Amount</strong></label>
											<input type="text" name="amount" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required="true" class="form-control" placeholder="New Pay"/>
										</div>
										<div class="modal-footer">
											<input type="submit" value="Send" class="btn  btn-success"/>
											</form>
											<button type="button" class="btn  btn-default" data-dismiss="modal">Close</button>
										</div>
				</div>
			</div>
		</div>
		<div id="changesstatus1" class="modal " role="dialog">
			<div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">Change Order Status</h4>
										</div>
										<div class="modal-body">
											<strong>Change Status</strong>
											<form method="post" action="{{URL::to('/change-status')}}" role="form" class="form-horizontal ">
											{{ csrf_field() }}
											<input type="hidden" name="orderID" value="{{$order->id}}"/>
											<select  class="form-control" name="status">
												<option value="1">Bidding</option>
												<option value="2">Assigned</option>
												<option value="3">Editing</option>
												<option value="4">Revision</option>
												<option value="5">Completed</option>
												<option value="7">Canceled</option>
											</select>
										</div>
										<div class="modal-footer">
											<input type="submit" value="Change Order Status" class="btn  btn-warning"/>
											</form>
											<button type="button" class="btn  btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>
			</div>
		</div>
						
							<div id="deleteOrder" class="modal " role="dialog">
								<div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
															
											<h4 class="modal-title">Delete Order</h4>
										</div>
										<div class="modal-body">
											<p style="color:#000000;">Are you sure you want to delete this order?</p>
										</div>
										<div class="modal-footer">
											<form method="post" action="{{URL::to('/delete-order')}}" role="form" class="form-horizontal ">
												{{ csrf_field() }}
												<input type="hidden" name="orderID" value="{{$order->id}}"/>
												<input type="submit" value="Delete Order" class="btn  btn-danger"/>
											
											</form>
											<button type="button" class="btn  btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>

								</div>
							</div>
							<div id="markpaid" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
								<div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
															
											<h4 class="modal-title">Mark Order Paid</h4>
										</div>
										<div class="modal-body">
															
											@if(count($tutors)>0)
											<form method="post" action="{{URL::to('/mark-paid')}}" role="form" class="form-horizontal ">
											{{ csrf_field() }}
											<input type="hidden" name="orderID" value="{{$order->id}}"/>
											<label for="language" class=" control-label"><strong>Amount Paid</strong></label>
											<input type="text" name="amount" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required="true" class="form-control" placeholder="Amount Paid "/>
											<br/>
											<label for="language" class=" control-label"><strong>Paid Through</strong></label>
											<select name="paidvia" class="form-control">
												<option value="1">PayPal</option>
												<option value="2">PesaPal</option>
												<option value="3">FlutterWave</option>
												<option value="4">Wallet</option>
												<option value="5">Payoneer</option>
												<option value="6">Wave</option>
												<option value="7">Others</option>
											</select>
											@endif
										</div>
										<div class="modal-footer">
											<input type="submit" value="Mark Paid" class="btn  btn-success"/>
											</form>
											<button type="button" class="btn  btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>

								</div>
							</div>
						@endif
							<br><br><br>
							
					
    <div id="mail-content">
		@if(count($revisions)>0)
		<hr>
		@foreach($revisions as $revision)
		@php
    		$rfiles=App\Revision_file::where('revision_id',$revision->id)->get();
    		$createdby=App\User::findOrFail($revision->user_id);
    		$daterrr = $revision->deadline;
    		$newDater = date("m-d-Y H:i A", strtotime($daterrr));
    		$teee=time();
    		$stree=$revision->deadline;
    		$timestampee = strtotime($stree)-$teee;
		@endphp  
		<div class="lable">Created By: <a href="{{ url('/profile',$client->id) }}">{{ ucfirst($client->name) }}</a></div>
		<div class="lable">Due Date: <a href="">{{ $newDater }} </a> &nbsp;&nbsp;&nbsp;
		    <span>(
                @if(strtotime($stree)>$teee) 
                    (<span style="color:#23AF00">{{secondsToTime($timestampee)}}</span>
                @else
                    <span style="color:#FF0000"> {{secondsToTime($timestampee)}}</span>
                @endif
            </span> left )
		</div><br>
		<h4>Revision Instructions</h4>
		<p>{!!$revision->instructions!!}</p>
		
	    <div>
			@if(count($rfiles)>0)
			<h4>Revision Files</h4>
			@foreach($rfiles as $rfile)
			<i class="fa fa-paperclip" style="margin-right: 20px;"></i>
			<a class="file" href="{{ url('/revision-file',$rfile->filename) }}">{{$rfile->filename}}</a>&nbsp;&nbsp;&nbsp;
				@if(Auth::user()->role=="1"||Auth::user()->role=="3")
				<a data-toggle="modal" data-target="#solution{{$rfile->id}}" data-backdrop="static" data-keyboard="false"><i class="far fa-trash-alt"></i></a>
					<div id="solution{{$rfile->id}}" class="modal " role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header"><h4 class="modal-title">Confirm Delete Revision File</h4></div>
								<div class="modal-body">
									<p>Are you sure you want to delete this revision file?</p>
									<div class="modal-footer">
										<form method="post" action="{{URL::to('/delete-revision-file')}}" role="form" class="form-horizontal ">
											{{ csrf_field() }}
											<input type="hidden" name="sfile" value="{{$rfile->id}}"/>
											<input type="submit" value="Yes, Delete Revision file" class="btn  btn-danger">
										</form>
										<button type="button" class="btn  btn-warning" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif
				@endforeach
				@endif
		</div>
		    <hr>
		@endforeach
		@endif
    </div>  