<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4">Attached Files</h4>
        <div class="accordion" id="accordion-default">
            @if((Auth::user()->role==3) || Auth::user()->role==1||Auth::user()->role==2)     
                <a class=" btn btn-sm btn-info" data-toggle="collapse" href="#orderfiles">Add Order File(s)</a> 
            @endif   
            <br>    
            <div id="orderfiles" class="collapse" data-parent="#accordion-default">
                <div class="card">
                    <div class="card-body">
                        <form  enctype="multipart/form-data" method="post" action="{{ url('/upload-order-file') }}">
                            {{ csrf_field() }}
                            <input  type="hidden" value="{{$order->id}}" name="orderid"/>
                            <div class="form-row">
                                <div class="form-group col-md-12 {{ $errors->has('yourmessage') ? ' has-error' : '' }}">
                                    <label for="inputEmail4">Attach File</label>
                                    {!! Form::file('orderfiles[]', array('multiple'=>true,'value'=>'default')) !!}
                                    <p class="errors">{!!$errors->first('orderfiles')!!}</p>
                                    @if(Session::has('error'))
                                    <p class="errors">{!! Session::get('error') !!}</p>
                                    @endif
                                </div>
                                @if ($errors->has('orderfiles'))
                                <span class="help-block"><strong>{{ $errors->first('orderfiles') }}</strong></span>
                                @endif
                            </div>
                            <button class="btn btn-primary btn-sm" type="submit">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if(count($ofiles)>0)
        <div style="float: right;">
            <a class=" btn btn-sm btn-warning " style="margin-bottom: 20px;"  href="{{ url('/download-zip',$order->id) }}">Download Zipped Files</a> 
        </div><br>
        <div class="table-responsive">
            <table class="table  table-centered table-hover mb-0">
                <tbody>
                    @foreach($ofiles as $ofile)
                    @php
						$filecreator=App\User::findOrFail($ofile->user_id);
					@endphp 
                    <tr style="line-height:1.7;">
                        <td>
                            <i class="fa fa-paperclip" style="margin-right: 20px;"></i>
                            <a class="file" href="{{ url('/order-file',$ofile->filename) }}">{{$ofile->filename}}</a>
                            <p> By: <a href="{{ url('/profile',$filecreator->id) }}">{{$filecreator->name}}</a></p>
                        </td>
                        <td><small>{{$ofile->created_at->format('m-d-Y, H:i A')}}</small></td>
                        <td>
                            @if((Auth::user()->role==3) || Auth::user()->role==1)  
            				<a data-toggle="modal" href="#ofile" class=" btn btn-danger" data-backdrop="static" data-keyboard="false"><i class="far fa-trash-alt"></i>&nbsp;&nbsp;Delete</a>
            					<div id="ofile" class="modal " role="dialog">
            						<div class="modal-dialog">
            							<div class="modal-content">
            								<div class="modal-header"><h4 class="modal-title">Confirm Delete File</h4></div>
            								<div class="modal-body">
            									<p>Are you sure you want to delete this file?</p>
            									<div class="modal-footer">
            										<form method="post" action="{{URL::to('/delete-order-file')}}" role="form" class="form-horizontal ">
            											{{ csrf_field() }}
            											<input type="hidden" name="ofile" value="{{$ofile->id}}">
            											<input type="submit" value="Yes, Delete file" class="btn btn-danger">
            										</form>
            										<button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
            									</div>
            								</div>
            							</div>
            						</div>
            					</div>
            				@endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p>No attached files for this order</p>
        @endif
    </div>
</div>