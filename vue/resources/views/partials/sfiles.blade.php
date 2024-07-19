<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4">Solution Files</h4>
        <div class="accordion" id="accordion-default">
            @if( Auth::user()->role==1||Auth::user()->role==2 || Auth::user()->id==$order->tutor_id)
                <a class=" btn btn-info" data-toggle="collapse" href="#sfiles">Upload Solution Files</a>   
            @endif 
            <div id="sfiles" class="collapse" data-parent="#accordion-default">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Upload Solution Files</h4>
                    </div>
                    <div class="card-body">
                        <form  enctype="multipart/form-data" method="post" action="{{ url('/upload-solution-file') }}">
                            {{ csrf_field() }}
                            <input  type="hidden" value="{{$order->id}}" name="orderid"/>
                            <div class="form-row">
                                <div class="form-group col-md-12 {{ $errors->has('sfiles') ? ' has-error' : '' }}">
                                    <label for="inputEmail4">Attach file(s)</label>
                                    {!! Form::file('sfiles[]', array('multiple'=>true,'value'=>'default')) !!}
                                    <p class="errors">{!!$errors->first('sfiles')!!}</p>
                                    @if(Session::has('error'))
                                    <p class="errors">{!! Session::get('error') !!}</p>
                                    @endif
                                </div>
                                @if ($errors->has('sfiles'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('sfiles') }}</strong>
                                </span>
                                @endif
                            </div>
                            <button class="btn btn-primary btn-sm" type="submit">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if(count($sfiles)>0)
        <div style="float: right;">
            <a class="btn btn-primary" style="margin-bottom: 20px;"  href="{{ url('/download-zip-solution',$order->id) }}">Download All Files</a> 
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <tbody>
                    @foreach($sfiles as $sfile)
                    @php
                        $filecreator=App\User::findOrFail($sfile->user_id);
                    @endphp 
                    <tr style="line-height:1.7;">
                        <td><i class="fa fa-paperclip" style="margin-right: 20px;"></i><a class="file" href="{{ url('/solution-file',$sfile->filename) }}">{{$sfile->filename}}</a></td>
                        <td>By: <a href="{{ url('/profile',$filecreator->id) }}">{{$filecreator->name}}</a></td>
                        <td>At: <a href=""><small>{{ $sfile->created_at->format('m-d-Y, H:i A') }}</small></td>
                        <td>
                            <div class="accordion" id="accordion">
                                @if((Auth::user()->role==1) || Auth::user()->role==4)     
                                    <a class=" btn btn-danger" data-toggle="collapse" href="#sfile">Delete</a> 
                                <div id="sfile" class="collapse" data-parent="#accordion">
                                    <form method="post" action="{{URL::to('/delete-solution-file')}}" role="form" class="form-horizontal ">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="sfile" value="{{$sfile->id}}"/>
                                        <input type="submit" value="Yes" class="btn btn-warning"/>
                                    </form>
                                    <a class=" btn btn-primary" data-toggle="collapse" href="#sfile"> No.</a>
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p>No solution files for this order</p>
        @endif
        <hr><br><br><br>
        @if($order->status==5 && (Auth::user()->role==1||Auth::user()->role==3 ))
        <div class="row" style="background-color:#dcfce3;padding:10px;text-align:center;">
           <div class="col">
               <p><button type="button" class="btn btn-success" data-toggle="modal" data-target="#ratewriter">Rate Writer</button></p>
                <div id="ratewriter" class="modal" role="dialog" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">
						<div class="modal-content">
						    <div class="modal-header"><h4 class="modal-title">Rate Writer</h4></div>
							<div class="modal-body">
							    <form role="form"  method="post" action="{{URL::to('/reviewtutor')}}">
									{{ csrf_field() }}
									<input type="hidden" value="{{$order->id}}" name="order"/>
									<label for="subject" class="lable">How many stars?</label>
										<div class="{{ $errors->has('subject') ? ' has-error' : '' }}">
											<fieldset class="rating">
    											<input type="checkbox" id="star5" name="rating" value="5" checked="true">
    											<label for="star5">5 </label>
    											<input type="checkbox" id="star4" name="rating" value="4">
    											<label for="star4"> 4 </label>
    											<input type="checkbox" id="star3" name="rating" value="3">
    											<label for="star3"> 3 </label>
    											<input type="checkbox" id="star2" name="rating" value="2">
    											<label for="star2"> 2 </label>
    											<input type="checkbox" id="star1" name="rating" value="1">
    											<label for="star1"> 1 </label>
											</fieldset>	
										</div><br>
										<div class="{{ $errors->has('subject') ? ' has-error' : '' }}">
											<label for="subject" class="lable">Subject:</label>
											<input type="text" value="{{$subjects->subject}}" readonly="true">
										</div><br>
										<div class="{{ $errors->has('offer') ? ' has-error' : '' }}">
											<label for="offer" class="lable">Comments:</label>
											<textarea name="comments" value="{{ old('offer') }}" rows="3" maxlength="200" required="true"></textarea>
											@if ($errors->has('offer'))
												<span><strong>{{ $errors->first('offer') }}</strong></span>
											@endif
										</div>
										<label for="offer" class="lable">Recommend this Writer :</label>
										<div class="btn-group" data-toggle="buttons">
											<label class="btn" data-btn="btn-success"><input type="checkbox" name="recommend"  id="option1" value="1" autocomplete="off" checked="true" class="active">Yes</label>
											<label class="btn" data-btn="btn-warning"><input type="checkbox" name="recommend"  id="option2" value="2" autocomplete="off"> No</label>
										</div>
								</form>		
								<div class="modal-footer">
									<input type="submit" value="Submit Review" class="btn btn-success">
								    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="col">
                <p><button type="button" class="btn  btn-danger"  data-toggle="modal" data-target="#rrrr">Request Revision</button></p>
                <div id="rrrr"class="modal" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header"><h4 class="modal-title">Request Revision</h4></div>
                        	<div class="modal-body">
                        		<form class="form-horizontal"  role="form" enctype="multipart/form-data" method="post" action="{{ url('/request-revision') }}">
                        			{{ csrf_field() }}
                        			<input type="hidden" name="id" value="{{$order->id}}">
                        			<label class="lable">Revision Instructions:</label>
                        			<textarea  name="instruction" value="{{ old('instruction') }}" id="detailsee" rows="5"></textarea>
                            			@if ($errors->has('instruction'))
                            			    <span class="help-block"> {{ $errors->first('instruction') }}</span>
                            			@endif <br>
                        			<label class="lable">Revision Deadline:</label>
                        			<input id="datetimepicker" placeholder="Set revision deadline" readonly="true" value="{{ old('deadline') }}" onclick="calculateTime()" name="deadline" required="true" type="text" required="true" >
                        			    @if ($errors->has('deadline'))
                        					<span class="help-block">{{ $errors->first('deadline') }}</span>
                        				@endif	<br>		
                        			<div  style="margin-top:10px">
                        				{!! Form::file('orderfiles[]', array('multiple'=>true,'value'=>'default')) !!}
                        				<p class="errors">{!!$errors->first('orderfiles')!!}</p>
                        				@if(Session::has('error'))
                        				<p class="errors">{!! Session::get('error') !!}</p>
                        	        	@endif
                        	        </div><hr>
                        			<div>
                        				<input type="submit" value="Submit Revision" class="btn btn-sm  btn-success" />
                        				<button type="button" class="btn btn-info" data-dismiss="modal">Close</button> 
                        			</div>
                        		</form>
                        	</div>
                        </div>
                        <input type="hidden" value="{{$order->id}}" name="" id="myOrderID"/>
                    </div>
                </div>
		    </div>
        </div>
    </div>
    @endif
</div>