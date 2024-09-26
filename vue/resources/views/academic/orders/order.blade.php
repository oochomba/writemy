@extends('layouts.app')
@section('title',$order->id)
@section('page_css')
@endsection

@section('content')

@php									
$date = $order->duedate;
$newDate = date("m-d-Y ", strtotime($date));
$t=time();
$str=$order->duedate;
$timestamp = strtotime($str)-$t;
function secondsToTime($seconds) {
$dtF = new \DateTime('@0');
$dtT = new \DateTime("@$seconds");
return $dtF->diff($dtT)->format('%ad %hh %imins ');
}
$client=App\User::findOrFail($order->user_id);
if($order->tutor_id!=""){
$tutor=App\User::findOrFail($order->tutor_id);

}
$subjects=App\Subject::findOrFail($order->subject);
$bids=App\Bid::where('question_id',$order->id)->orderBy('created_at','DESC')->get();
$types=App\Type::findOrFail($order->paper_type);
$levels=App\Academic::findOrFail($order->academic);
$languages=App\Language::findOrFail($order->language);
$styles=App\Style::findOrFail($order->style);
$tutors=App\User::where('role',4)->get();
//$umessages=App\Message::where('order_id',$order->id)->where('status',0)->where('to',Auth::user()->id)->get();
$umessages=App\Message::where('order_id',$order->id)->where('status',0)->where('mto',Auth::user()->id)->get();
$ofiles=App\Orderfile::where('question_id',$order->id)->where('is_deleted',0)->get();
$sfiles=App\Solutionfile::where('question_id',$order->id)->where('is_deleted',0)->get();
$revisions=App\Revision::where('question_id',$order->id)->orderBy('created_at','DESC')->get();
$aservices=App\Additionalservice::where('order_id',$order->id)->get();
$asum=App\Additionalservice::where('order_id',$order->id)->sum('price');
$ureviews=App\Review::where('student_id',$user->id)->orderBy('created_at','DESC')->get();
						
@endphp

<script src="https://cdn.tiny.cloud/1/w75xwosb7fak6zrt4r2hs4wjnvc53o7luvz03yuivs0rjwvv/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
//   tinymce.init({
//     selector: 'textarea',
//     plugins: 'charmap emoticons image link table lists linkchecker',
//     toolbar: 'blocks fontsize | numlist bullist',
//   });
</script>


<style>
	.tile {width:100%;background:#fff;border-radius:5px;float:left;transform-style:preserve-3d;margin:10px 5px;}
    .lable{line-height:1.5em; font-size: 16px;font-weight:500;}
    .ctext-wrap{background-color:#dcfce3;padding:10px;cursor:pointer;margin-left:40px;border-radius:.25rem;}
    .rtext-wrap{background-color:#c5f3fa;padding:10px;cursor:pointer;margin-right:50px;border-radius:.25rem;}
    .c-name{font-size:14px;font-weight:500;}
    .chat-time{font-size:11px;border-top:1px solid #b3b1b1;}
</style>

	<div class="row">
		<div class="col-lg-4">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">ORDER DETAILS</h4>
					<div class="mt-5">
					@include('partials.sideorder')
					</div>
		        </div>
		    </div>
		</div>
		<div class="col-lg-8">
			<div class="card">
				<div class="card-body">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
						<li class="nav-item">
							<a class="nav-link " data-toggle="tab" href="#home1" role="tab">
								<span class="d-block d-sm-none"><i class="fa fa-users"></i></span>
								@php
								$count=count ($bids) ;
								if($count>0){
									$class=1;
								}else {
									$class=0;
								}
								@endphp
								<span class="d-sm-block">Bids
								@if($class==1)
								<span class="badge badge-pill badge-success">{{ $count }}</span>
								@else
								<span class="badge badge-pill badge-dark">{{ $count }}</span>
								@endif	
								</span> 
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#order" role="tab">
								<span class="d-block d-sm-none"><i class="fa fa-home"></i></span>
								<span class="d-sm-block">Details</span> 
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#profile1" role="tab">
								<span class="d-block d-sm-none"><i class="fa fa-envelope"></i></span>
								<span class="d-sm-block">Messages <span class="badge badge-pill badge-danger">{{ count($umessages) }}</span> </span> 
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#messages1" role="tab">
								<span class="d-block d-sm-none"><i class="fa fa-briefcase"></i></span>
								<span  class="d-sm-block">Files <span class="badge badge-pill badge-danger">{{ count($ofiles) }}</span></span>   
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#settings1" role="tab">
								<span class="d-block d-sm-none"><i class="fa fa-file"></i></span>
								<span  class="d-sm-block">Solutions <span class="badge badge-pill badge-primary">{{ count($sfiles) }}</span></span>    
							</a>
						</li>
					</ul>
		
					<!-- Tab panes -->
					<div class="tab-content p-3 text-muted">
						<div class="tab-pane active" id="order" role="tabpanel">
						@include('partials.project') <br>
                    		@if(count($aservices))
                    		<div class="card">
                    			<div class="card-body">
                    				<h4 class="card-title">Additional Services</h4>
                    				<div class="table-responsive">
                    					<table class="table table table- mb-0 table-hover">
                    						<thead class="thead-light">
                    							<tr>
                    								<th>#</th>
                    								<th>Service</th>
                    								<th>Cost</th>							
                    							</tr>
                    						</thead>
                    						<tbody>
                    							@foreach ($aservices as $key=> $service )
                    							<tr>
                    								<th scope="row">{{ $key+1 }}</th>
                    								<td>{{ $service->service }}</td>
                    								<td>$ {{ $service->price }}</td>				
                    							</tr>	
                    							@endforeach
                    						</tbody>
                    					</table>
                    				</div>
                    			</div>
                    		</div>
                    		@endif
                            <br>
						@include('partials.orderactions')
						</div>
						<div class="tab-pane " id="home1" role="tabpanel">
							<div>
								@include('partials.placebid')
							</div>
							@include('partials.bids')
						</div>
						
						<div class="tab-pane" id="profile1" role="tabpanel">
							<div class="accordion" id="accordion-default"><br>
								<a class=" btn btn-info" data-toggle="collapse" href="#collapseTwoDefault">Send New Message</a>    
								<div id="collapseTwoDefault" class="collapse" data-parent="#accordion-default">
									<div class="card">
										<div class="card-body">
											<form  enctype="multipart/form-data" method="post" action="{{ url('/post-send-message') }}">
												{{ csrf_field() }}
												<input  type="hidden" value="{{$order->id}}" name="orderid"/>
												<div class="form-row">
													<div class="form-group col-md-12 {{ $errors->has('messageto') ? ' has-error' : '' }}">
														<label class="lable" for="inputEmail4">To: </label>
														<select  class="form-control" name="messageto">
															@if(Auth::user()->role=='4')
															<option value="87879">Admin</option>	
															@if($order->tutor_id!="")
															<option value="{{$order->user_id}}">Client</option>		
															@endif						
															@elseif(Auth::user()->role=='1'|| Auth::user()->role=='2')
															<option value="{{$order->user_id}}">Client</option>	
															@if($order->tutor_id!="")
															<option value="{{$order->tutor_id}}">Assigned Writer</option>	
															@endif									
															@elseif(Auth::user()->role=='3')
															@if($order->tutor_id!="")
															<option value="{{$order->tutor_id}}">Assigned Writer</option>	
															@endif
															<option value="87879">Admin</option>									
															@else
															@endif
														</select>
													</div>
												</div>
												<div class="form-row">
													<div class="form-group col-md-12 {{ $errors->has('yourmessage') ? ' has-error' : '' }}">
														<label class="lable" for="inputEmail4">Your Message:</label>
														<textarea name="yourmessage" >{{ old('yourmessage') }}</textarea>
													</div>
													@if ($errors->has('yourmessage'))
													<span class="help-block">{{ $errors->first('yourmessage') }}</span>
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
														{{ $errors->first('messagefiles') }}
													</span>
													@endif
												</div>
												<button type="submit" class="btn btn-primary">Send</button>
											</form>
										</div>
									</div>
								</div>
							</div>

							@php
							$messages=App\Message::where('order_id',$order->id)->orderBy('created_at','DESC')->get();
							@endphp  
							
                            <div class="card">
								@if(count($messages)>0)
									@foreach($messages as $message)
									@php
									$files=App\Messagefile::where('message_id',$message->id)->get();
									$mto=App\User::findOrFail($message->mto);
									$mfrom=App\User::findOrFail($message->mfrom);
									@endphp  
                                <div class="card-body">
									@if( Auth::user()->id==$message->mto)
                                        <div class="ctext-wrap">
                                            <div class="c-name">From: {{ucfirst($mfrom->name)}}</div>
                                            <p>{!!$message->message!!}</p>
                                            @if( Auth::user()->role==1)
											<p><a data-toggle="modal" data-target="#solution{{$message->id}}" data-backdrop="static" data-keyboard="false"></a></p>
											@endif
											<div>
												@if(count($files)>0)
												@foreach($files as $file)
												<a class="file" href="{{ url('/message-file',$file->messagefile) }}">
												    <div class="media">
														<div><i class="fa fa-paperclip" style="margin-right: 20px;"></i></div>
														<div>{{ $file->messagefile }}</div>
													</div>
												</a>
												@endforeach
												@endif
											</div>
											<p class="chat-time">({{ $message->created_at->format('m-d-Y, H:i A') }})</p> 
                                        </div>
										@elseif(Auth::user()->id==$message->mfrom)
                                        <div class="rtext-wrap">
                                            <div class="c-name">To: {{ucfirst($mto->name)}}</div>
                                            <p>{!!$message->message!!}</p>
                                            @if( Auth::user()->role==1)
											<p><a data-toggle="modal" data-target="#solution{{$message->id}}" data-backdrop="static" data-keyboard="false"></a></p>
											@endif
											<div>
												@if(count($files)>0)
												@foreach($files as $file)
												<a class="file" href="{{ url('/message-file',$file->messagefile) }}">
												    <div class="media">
														<div><i class="fa fa-paperclip" style="margin-right: 20px;"></i></div>
														<div>{{ $file->messagefile }}</div>
													</div>
												</a>
												@endforeach
												@endif
											</div>
											<p class="chat-time">({{$message->created_at->format('m-d-Y, H:i A')}})</p> 
                                        </div>
									@endif
								</div>
								@endforeach
								@else
								<p>No messages found for this order.</p>
								@endif
                            </div>
						</div>
						<div class="tab-pane" id="messages1" role="tabpanel">
							@include('partials.ofiles')
						</div>
						<div class="tab-pane" id="settings1" role="tabpanel">
							@include('partials.sfiles')
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection