@if($mybid=="")
	@if((Auth::user()->role=="1"||Auth::user()->role=="4")&&$order->status==1)
	<a data-toggle="modal" data-target="#editbid" class="btn btn-primary">Place Bid</a>
	@endif
	<div id="editbid" class="modal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header"><h4 class="modal-title">Place Bid</h4></div>
				<div class="modal-body">
					<form class="form-horizontal" role="form"  method="post" action="{{ url('/updated-bid') }}">
						{{ csrf_field() }}
						<input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
						<input type="hidden" name="question_id" value="{{$order->id}}"/>
						<div class="{{ $errors->has('amount') ? ' has-error' : '' }}">
							<label for="amount" class="lable">Bid Amount</label>
							<div class="input-group">
							    <input id="amount" type="number" min="1"  class="form-control" name="amount" value="{{$order->amount}}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required="true">
							</div>
							@if ($errors->has('amount'))
							    <span class="help-block"><strong>{{ $errors->first('amount') }}</strong></span>
					    	@endif
						</div>
						<div class="{{ $errors->has('offer') ? ' has-error' : '' }}">
							<label for="offer" class="lable">Bid Message</label>
							<textarea    class="form-control " name="offer" value="{{$order->offer}}"  rows="3" maxlength="300" required="true"></textarea>
							@if ($errors->has('offer'))
								<span class="help-block"><strong>{{ $errors->first('offer') }}</strong></span>
							@endif
						</div>
						<div><input type="submit" value="Submit Bid" class="btn btn-success"></div>
					</form>
				</div>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div><br><br>
@endif