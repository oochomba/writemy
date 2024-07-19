						<div class="tab-pane" id="profile1" role="tabpanel" >
							<div class="accordion" id="accordion-default">
								<a class=" btn btn-sm btn-info" data-toggle="collapse" href="#collapseTwoDefault">
									Send Message
								</a>    
								<br />       
								<br />       
								<div id="collapseTwoDefault" class="collapse" data-parent="#accordion-default">
            
									<div class="card">
										<div class="card-header">
											<h4 class="card-title">Send Message</h4>
										</div>
										<div class="card-body">
											<form  enctype="multipart/form-data" method="post" action="{{ url('/post-send-message') }}">
												{{ csrf_field() }}
												<input  type="hidden" value="{{$order->id}}" name="orderid"/>
												<div class="form-row">
													<div class="form-group col-md-12 {{ $errors->has('messageto') ? ' has-error' : '' }}">
														<label for="inputEmail4">To</label>
														<select  class="form-control" name="messageto">
										
															@if(Auth::user()->role=='4')
															<option value="87879">System Support</option>	
															@if($order->tutor_id!="")
															<option value="{{$order->user_id}}">Client</option>		
															@endif						
															@elseif(Auth::user()->role=='1'|| Auth::user()->role=='2')
															<option value="{{$order->user_id}}">Client</option>	
															@if($order->tutor_id!="")
															<option value="{{$order->tutor_id}}">Tutor</option>	
															@endif									
															@elseif(Auth::user()->role=='3')
											
															@if($order->tutor_id!="")
															<option value="{{$order->tutor_id}}">Tutor</option>	
															@endif
															<option value="87879">System Support</option>									
															@else
											
															@endif
		

														</select>
													</div>
												</div>
				
												<div class="form-row">
													<div class="form-group col-md-12 {{ $errors->has('yourmessage') ? ' has-error' : '' }}">
														<label for="inputEmail4">Your Message</label>
														<textarea width="100%" class="form-control" name="yourmessage" >{{ old('yourmessage') }}</textarea>
													</div>
													@if ($errors->has('yourmessage'))
													<span class="help-block">
														<strong>{{ $errors->first('yourmessage') }}</strong>
													</span>
													@endif
       
												</div>
												<div class="form-row">
													<div class="form-group col-md-12 {{ $errors->has('yourmessage') ? ' has-error' : '' }}">
														<label for="inputEmail4">Attach file(s)</label>
														{!! Form::file('messagefiles[]', array('multiple'=>true,'value'=>'default')) !!}
							
														<p class="errors">{!!$errors->first('messagefiles')!!}</p>
														@if(Session::has('error'))
														<p class="errors">{!! Session::get('error') !!}</p>
																
														@endif
													</div>
													@if ($errors->has('messagefiles'))
													<span class="help-block">
														<strong>{{ $errors->first('messagefiles') }}</strong>
													</span>
													@endif
       
												</div>
			
		
												<button type="submit" class="btn btn-primary btn-rounded chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block mr-2">Send</span> <i class="mdi mdi-send"></i></button>

			
											</form>
										</div>
									</div>
								</div>
   
  
							</div>
							<hr />
							
							@php
							$messages=App\Message::where('order_id',$order->id)->orderBy('created_at','DESC')->get();
							@endphp  
							<div class="w-100 user-chat">
                                <div class="card">
									@if(count($messages)>0)
									@foreach($messages as $message)
									@php
									$files=App\Messagefile::where('message_id',$message->id)->get();
									$mto=App\User::findOrFail($message->mto);
									$mfrom=App\User::findOrFail($message->mfrom);
									@endphp  
    
                                    <div>
                                        <div class="chat-conversation p-3">
                                            <ul class="list-unstyled" data-simplebar style="max-height: 470px;">
											 
												@if( Auth::user()->id==$message->mto)
												
												<li>
                                                    <div class="conversation-list">
                                                      
                                                        <div class="ctext-wrap">
                                                            <div class="conversation-name">{{ucfirst($mfrom->name)}}</div>
                                                            <p>
                                                                {!!$message->message!!}
                                                            </p>
                                                            <p class="chat-time mb-0"><i class="bx bx-time-five align-middle mr-1"></i> {{$message->created_at->format('m-d-Y H:i A')}}</p> @if( Auth::user()->role==1)
										
															<a class="text-red font-size-18 m-r-20" data-toggle="modal" data-target="#solution{{$message->id}}" data-backdrop="static" data-keyboard="false"><i class="far fa-trash-alt text-danger"></i></a>
															
															
															@endif
															<div class="m-t-30">
																@if(count($files)>0)
																@foreach($files as $file)
																<a class="file" href="{{ url('/message-file',$file->messagefile) }}"style="min-width: 200px">
																	<div class="media align-items-center">
																		<div class="m-r-15 font-size-30">
																			<i class="fa fa-paperclip text-info"></i>
											
																		</div>
																		<div>
																			<h6 class="mb-0">{{$file->messagefile}}</h6>
																			<span class="font-size-13 text-info"><i class="fa fa-cloud-download-alt"></i> Download</span>
																		</div>
																	</div>
																</a>
																@endforeach
																@endif
									
															</div>
                                                        </div>
                                                        
                                                    </div>
                                                </li>
    
												@elseif(Auth::user()->id==$message->mfrom)
												<li class="right">
                                                    <div class="conversation-list">
                                                      
                                                        <div class="ctext-wrap">
                                                            <div class="conversation-name">{{ucfirst($mto->name)}}</div>
                                                            <p>
                                                                {!!$message->message!!}
                                                            </p>
    
                                                            <p class="chat-time mb-0"><i class="bx bx-time-five align-middle mr-1"></i> {{$message->created_at->format('m-d-Y H:i A')}}</p> @if( Auth::user()->role==1)
										
															<a class="text-red font-size-18 m-r-20" data-toggle="modal" data-target="#solution{{$message->id}}" data-backdrop="static" data-keyboard="false"><i class="far fa-trash-alt text-danger"></i></a>
															
														
															@endif
															<div class="m-t-30">
																@if(count($files)>0)
																@foreach($files as $file)
																<a class="file" href="{{ url('/message-file',$file->messagefile) }}"style="min-width: 200px">
																	<div class="media align-items-center">
																		<div class="m-r-15 font-size-30">
																			<i class="fa fa-paperclip text-info"></i>
											
																		</div>
																		<div>
																			<h6 class="mb-0">{{$file->messagefile}}</h6>
																			<span class="font-size-13 text-info"><i class="fa fa-cloud-download-alt"></i> Download</span>
																		</div>
																	</div>
																</a>
																@endforeach
																@endif
									
															</div>
                                                        </div>
                                                    </div>
                                                </li>
    
											
												@endif
                                         
                                                
                                            </ul>
										</div>
														<div id="solution{{$message->id}}" class="modal " role="dialog">
											<div class="modal-dialog">

												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header">
															
														<h4 class="modal-title">Confirm Delete Message</h4>
													</div>
													<div class="modal-body">
														Are you sure you want to delete message and it's files?
															
															
														<div class="modal-footer">
															<form method="post" action="{{URL::to('/delete-message')}}" role="form" class="form-horizontal ">
																{{ csrf_field() }}
																<input type="hidden" name="mid" value="{{$message->id}}"/>
																<input type="submit" value="Yes, Deleted Message" class="btn btn-sm btn-danger"/>
											
															</form>
															
															<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
														</div>
			
													</div>
														
												</div>

											</div>
										</div>
                                        <div id="solution{{$message->id}}" class="modal " role="dialog">
											<div class="modal-dialog">

												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header">
															
														<h4 class="modal-title">Confirm Delete Message</h4>
													</div>
													<div class="modal-body">
														Are you sure you want to delete message and it's files?
															
															
														<div class="modal-footer">
															<form method="post" action="{{URL::to('/delete-message')}}" role="form" class="form-horizontal ">
																{{ csrf_field() }}
																<input type="hidden" name="mid" value="{{$message->id}}"/>
																<input type="submit" value="Yes, Deleted Message" class="btn btn-sm btn-danger"/>
											
															</form>
															
															<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
														</div>
			
													</div>
														
												</div>

											</div>
										</div>
									</div>
									@endforeach
								@else
								<p>No messages found for this order.</p>
								@endif
                                </div>
                            </div>

							  
						
                       
						</div>