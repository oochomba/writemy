
<div id="ratewriter" class="modal " role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Rate Tutor</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-horizontal"  role="form"  method="post" action="{{URL::to('/add-reviews')}}">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{$user->id}}" name="tutor"/>
                        <label for="subject" class=" control-label">How many stars?</label>
                        <div class="{{ $errors->has('subject') ? ' has-error' : '' }}">
                            <fieldset class="rating">
                                <input type="radio" id="star5" name="rating" value="5" checked="true" />
                                <label for="star5">5 stars</label>
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4">4 stars</label>
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3">3 stars</label>
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2">2 stars</label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1">1 star</label>
                            </fieldset>	
                        </div>
                        <br />
                        <br />
                    <div class="{{ $errors->has('offer') ? ' has-error' : '' }}">
                            <label for="offer" class=" control-label">Client :</label>
                             @php
                               $clients=App\User::where('role',3)->where('isdeleted',0)->orderBy('created_at','DESC')->get();
                               @endphp
                                        <select class="form-control " name="student">
                                        @if(count($clients)>0)
                                        @foreach($clients as $client)
                                            <option value="{{$client->id}}">{{ucfirst($client->name)}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('offer'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('offer') }}</strong>
                                        </span>
                            @endif
                        </div>
                        <div class="{{ $errors->has('offer') ? ' has-error' : '' }}">
                            <label for="offer" class=" control-label">Comments:</label>
                            <textarea    class="form-control " name="comments" value="{{ old('offer') }}" rows="3" maxlength="200" required="true"></textarea>
                            @if ($errors->has('offer'))
                            <span class="help-block">
                                <strong>{{ $errors->first('offer') }}</strong>
                            </span>
                            @endif
                        </div>
                        <label for="offer" class=" control-label">Recommend this Expert :</label>
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info btn-sm" data-btn="btn-success">
                                <input type="radio" name="recommend"  id="option1" value="1" autocomplete="off" checked="true" class="active">Yes
                            </label>
                            <label class="btn btn-default  btn-sm" data-btn="btn-warning">
                                <input type="radio" name="recommend"  id="option2" value="2" autocomplete="off">No
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Submit Review" class="btn btn-success btn-sm" />
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-default" id="editprofile" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
	
		<form class="modal-content"  role="form" enctype="multipart/form-data" method="post" action="{{ url('/edit-profile') }}">
			{{ csrf_field() }}
			<input type="hidden" name="user" value="{{$user->id}}"/>
			<div class="modal-header">
				<h5 class="modal-title">
					Update User
					<span class="font-weight-light">Profile</span>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
			</div>
			<div class="modal-body">
				<div class="form-row">
				<div class="row">
					<div class="col-md-6"><div class="form-group{{ $errors->has('userole') ? ' has-error' : '' }}">
                            <label for="userole" class=" control-label">User Role</label>
                                <select name="userole" class="form-control">
                                	<option value="1">Admin</option>
                                	<option value="2">Manager</option>
                                	<option value="3">Student</option>
                                	<option value="4">Tutor</option>
                                </select>
                                @if ($errors->has('userole'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('userole') }}</strong>
                                    </span>
                                @endif
                         
                        </div></div>
					<div class="col-md-6"> <div class="form-group{{ $errors->has('level') ? ' has-error' : '' }}">
                            <label for="level" class=" control-label">User Level</label>
                                <select name="level" class="form-control">
                                	<option value="1">New Writer</option>
                                	<option value="2">Junior Writer</option>
                                	<option value="3">Expert Writer</option>
                                	<option value="4">Veteran Writer</option>
                                </select>
                                @if ($errors->has('level'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('level') }}</strong>
                                    </span>
                                @endif
                         
                        </div></div>
				</div>
					
                        
                       
				</div>
				<div class="form-row">
					<div class="form-group col">
						<label class="form-label">Name</label>
						<input type="text" class="form-control" name="name" value="{{ucfirst($user->name)}}" placeholder="User Name">
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col">
						<label class="form-label">Email</label>
						<input type="text" class="form-control" name="email" value="{{($user->email)}}" placeholder="User email">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light  btn-sm waves-effect" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary btn-sm">Update</button>
			</div>
		</form>
	</div>
</div>

<div class="modal modal-default" id="credit" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
	
		<form class="modal-content"  role="form" enctype="multipart/form-data" method="post" action="{{ url('/credit-account') }}">
			{{ csrf_field() }}
			<input type="hidden" name="user" value="{{$user->id}}"/>
			<div class="modal-header">
				<h5 class="modal-title">
					Credit
					<span class="font-weight-light">User</span>
					<br>
					<small class="text-muted">Add Money to user Wallet</small>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
			</div>
			<div class="modal-body">
				
				<div class="form-row">
					<div class="form-group col">
						<label class="form-label">Amount</label>
						<input id="title" type="number" class="form-control" required="true" name="amount" min="1" placeholder=" Amount" value="{{ old('amount') }}">
						@if ($errors->has('amount'))
						<span class="help-block">
							<strong>{{ $errors->first('amount') }}</strong>
						</span>
						@endif
					</div>
					<div class="form-group col">
						<label class="form-label">Order Number</label>
						<input type="number" class="form-control" name="orderid" placeholder="Order Number">
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col">
						<label class="form-label">Narration</label>
						<input type="text" class="form-control" name="narration" placeholder="Reason for Credit">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light  btn-sm waves-effect" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary btn-sm">Credit</button>
			</div>
		</form>
	</div>
</div>
<div class="modal modal-default" id="debit" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">

									
		<form class="modal-content" role="form" enctype="multipart/form-data" method="post" action="{{ url('/debit-account') }}">
			{{ csrf_field() }}
			<input type="hidden" name="user" value="{{$user->id}}"/>
			<div class="modal-header">
				<h5 class="modal-title">
					Debit
					<span class="font-weight-light">User</span>
					<br>
					<small class="text-muted">Deduct Money to user Wallet</small>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
			</div>
			<div class="modal-body">
				
				<div class="form-row">
					<div class="form-group col">
						<label class="form-label">Amount</label>
						<input id="title" type="number" class="form-control" required="true" name="amount" min="1" placeholder=" Amount" value="{{ old('amount') }}">
						@if ($errors->has('amount'))
						<span class="help-block">
							<strong>{{ $errors->first('amount') }}</strong>
						</span>
						@endif
					</div>
					<div class="form-group col">
						<label class="form-label">Order Number</label>
						<input type="number" class="form-control" name="orderid" placeholder="Order Number">
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col">
						<label class="form-label">Narration</label>
						<input type="text" class="form-control" name="narration" placeholder="Reason for Credit">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Debit</button>
			</div>
		</form>
	</div>
</div>
<div class="modal modal-default" id="verify" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<form class="modal-content"  role="form" enctype="multipart/form-data" method="post" action="{{ url('/verify-account') }}">
			{{ csrf_field() }}
								
	
			<input  type="hidden" name="tutor" value="{{$user->id}}" />	
			<div class="modal-header">
				<h5 class="modal-title">
					Verify
					<span class="font-weight-light">User</span>
					<br>
					<small class="text-muted">Verify user account</small>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
			</div>
			<div class="modal-body">
				Are you sure you want to verify this User?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Yes, Verify</button>
			</div>
		</form>
	</div>
</div>
<div class="modal modal-default" id="unverify" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
	
		<form class="modal-content" role="form" enctype="multipart/form-data" method="post" action="{{ url('/unverify-account') }}">
			{{ csrf_field() }}
			<input  type="hidden" name="tutor" value="{{$user->id}}" />	
			<div class="modal-header">
				<h5 class="modal-title">
					Unverify
					<span class="font-weight-light">User</span>
					<br>
					<small class="text-muted">Unverify user account</small>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
			</div>
			<div class="modal-body">
				Are you sure you want to unverify this User?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-warning">Yes, Unverify</button>
			</div>
		</form>
	</div>
</div>


<div class="modal modal-default" id="deactivate" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<form class="modal-content"method="post" action="{{ url('/deactivateaccount') }}">
			{{ csrf_field() }}
			<input  type="hidden" name="tutor" value="{{$user->id}}" />	
			<div class="modal-header">
				<h5 class="modal-title">
					Change 
					<span class="font-weight-light">Account Active Status</span>
					<br>
					<small class="text-muted">Toggle the account Active/Inactive Status</small>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
			</div>
			<div class="modal-body">
				Confirm account Status Change. Use with Caution!
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-warning">Confirm Change Status</button>
			</div>
		</form>
	</div>
</div>