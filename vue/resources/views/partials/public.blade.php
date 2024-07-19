@extends('layouts.app')

@section('title',ucfirst($user->name))
@section('content')

@php
    $tutor=App\Wallet::where('user_id',$user->id)->first();
    $accbal=App\Credit::where('id',1)->first();
    $orders=App\Order::where('status',2)->where('user_id',$user->id)->where('is_deleted',0)->get();
    $completed=App\Order::where('status',5)->where('user_id',$user->id)->where('is_deleted',0)->get();
    $first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
    $last_day_this_month  = date('Y-m-t');
    $sumbymonth=App\Opayment::whereBetween('created_at', [$first_day_this_month, $last_day_this_month])->where('type',1)->where('user_id',$user->id)->sum('amount');
    $arecent=App\Order::where('user_id',$user->id)->orderBy('created_at','DESC')->get();  
    function secondsToTime($seconds) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%ad %hh %imins ');
    }
    $tutors=App\User::where('role',4)->get();
@endphp

@php
$userrating=App\Rating::where('user_id',$user->id)->first();
if($userrating==""){
	$ratings=new App\Rating;
			$ratings->user_id=$user->id;
			$ratings->score=0;
			$ratings->reviews=0;
			$ratings->save();
}
$scores=$userrating->score;
$reviews=$userrating->reviews;
if($reviews!=0){
    $meanscore=$scores/$reviews;						
    $newwriter=0;
    }
else{
    $meanscore=0;
    $newwriter=1;
    }

$totalamt=App\Order::where('amount', '>', 0)->sum('amount');
$speciality=App\Specialization::where('user_id',$user->id)->first();
$bio=App\Profile::where('user_id',$user->id)->first();				
$balance=App\Wallet::where('user_id',$user->id)->first();
if($user->role==4||$user->role==1||$user->role==2){	
    $ureviews=App\Review::where('tutor_id',$user->id)->orderBy('created_at','DESC')->get();	
    $orders=App\Order::where('tutor_id',$user->id)->where('is_deleted',0)->orderBy('created_at','DESC')->get();	
    $totalpaid=App\Order::where('tutor_id',$user->id)->where('writer_paid',1)->sum('writerpay');							
    }	
elseif($user->role==3){
	$ureviews=App\Review::where('student_id',$user->id)->orderBy('created_at','DESC')->get();	
    $orders=App\Order::where('user_id',$user->id)->where('is_deleted',0)->orderBy('created_at','DESC')->get();
    $totalpaid=App\Order::where('user_id',$user->id)->where('paid',1)->sum('amount');		
    }	
elseif($user->role==1||$user->role==2){
	$orders=App\Order::where('user_id',$user->id)->orWhere('tutor_id',$user->id)->where('is_deleted',0)->orderBy('created_at','DESC')->get();	
    }
else{}		
	$transactions=App\Opayment::where('user_id',$user->id)->orderBy('created_at','DESC')->get();		
@endphp

<style>
    .text-muted{font-size:14px;}
    p{padding-bottom:10px;font-weight:400;}
    .badge-pill{margin-bottom:10px;}
	.font-size-13{ font-size:14px;font-weight:500;}
	.rowz {display:flex;flex-wrap:wrap;width:100%;padding-left:10px;}
    .thumbnail{max-width:80%;border-radius:50%;border:1px solid;}
</style>

<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-5">
				<div class="d-md-flex">
					<div class="col-sm-4">
                        <img class="thumbnail" src="{{ URL::asset('vue/public/assets/images/avatars/'.$user->avatar)}}" alt="icon">
                        @php
                        $userrating=App\Rating::where('user_id',$user->id)->first();
                        $scores=$userrating->score;
                        $reviews=$userrating->reviews;											
                        if($reviews==0){
                            $meanscore=0;
                            }
                        else {
                            $meanscore=$scores/$reviews;	
                            }
                        @endphp 
                    </div>
					<div class="col-sm-7">
						<h3>{{ucfirst($user->name)}}</h3><br>
						<h5 class="font-size-13">Average Rating: <span class="badge badge-success font-size-14">{{round( $meanscore,2) }}</span>
                            @if($newwriter==1)
                                <p>(Not Yet Rated)</p>
                                @else
                                @if(round($meanscore, 2)>=5)
                                    <span class="text-warning"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
                                @elseif(round($meanscore, 2)>=4.5&& round($meanscore, 2)<=4.9)
                                    <span class="text-warning"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="far fa-star"></i></span>
                                @elseif(round($meanscore, 2)>=4&& round($meanscore, 2)<=4.5)
                                    <span class="text-warning"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
                                @else
                                    <span class="text-warning"><i class="far fa-star"></i></span>
                                @endif
                            @endif
                        </h5><br>
                        <h5 class="font-size-13">Current Rank:  
                            <span class="badge badge-success font-size-14"> 
    						    @if($user->role!=3)
        							@if($user->level==1)
        							    <span>New Writer</span>
        							@elseif($user->level==2)
        							    <span>Junior Writer</span>
        							@elseif($user->level==3)
        						    	<span>Expert Writer</span>
        							@elseif($user->level==4)
        							    <span>Veteran Writer</span>
        							@else
    							@endif
						    </span>
						</h5><br>
						<h5 class="font-size-13">Writer Status: 
						    <span class="badge badge-success font-size-14"> 
    						    @if($user->verified==1)							
    							    <span class="badge-pill badge-default badge-success"> <i class="fas fa-user-graduate"></i> Verified</span>
    							@else
    						    	<span class="badge-pill badge-default badge-danger">Unverified</span>
    							@endif
						    </span>
                        </h5>
						@endif
					</div>
			    </div>
			</div>
			@if($user->role!=3)
			<div class="col-md-6">
				<div class="row border-left">
					<div class="rowz">
						<p class="col-sm-4 col-6"><span>Proven Reliability:</span></p>
						<p class="text-info">100%  on Completed orders</p>
					</div>
					<div class="rowz">
						<p class="col-sm-4 col-6"><span>Customer Satisfaction: </span></p>
						<p class="text-info">Over 95%, 5 Stars  Rating</p>
					</div>
					<div class="rowz">
						<p class="col-sm-4 col-6"><span>Proven Punctuality:</span></p>
						<p class="text-info"> 100% delivery before deadline.</p>
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>

<div class="row">
    <div class="col-xl-4">
        @if(Auth::user()->role==1)   
        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-4">MANAGE USER</h3><br>
                <div class="d-flex">
                    <div>
                        @if($user->role==4||$user->role==2||$user->role==1)
                        <h4>Total Eanings: <span class="btn  btn-warning">${{$totalamt}}</span></h4>
                        @else
                        <h4>Total Contribution: <span class="btn  btn-warning">${{$totalpaid}}</span></h4>
                        @endif
                    </div>
                </div>
                <br>
                <ul class="menu nav flex-column">
                    @if($user->role==4)
                    <li><button id="trigger-loading-1" data-toggle="modal" data-target="#verify" data-dismiss="modal"  class="btn  btn-secondary">Verify Account</button></li>
                    <li><button id="trigger-loading-1" data-toggle="modal" data-target="#unverify" data-dismiss="modal" class="btn  btn-danger">Unverify Account</button></li>
                    @endif
                    <li><button id="trigger-loading-1" data-toggle="modal" data-target="#deactivate" data-dismiss="modal"  class="btn btn-danger">Deactivate Account</button></li>
                    <li><button id="trigger-loading-1" data-toggle="modal" data-target="#editprofile" data-dismiss="modal"  class="btn btn-success">Edit Profile</button></li>
                    <li><a href="{{ url('/impersonate',$user->id) }}" class="btn  btn-warning">Impersonate</a></li>
                    <li><button type="button" class="btn btn-success"  data-toggle="modal" data-target="#ratewriter">Add Rating</button></li>
                </ul>
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
                                                <label for="subject" class=" control-label"><b>How many stars?</b></label>
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
                                                </div>
                                                <br><br>
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
                                                <label for="offer" class=" control-label">Recommend this Scholar :</label>
                                                <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-info " data-btn="btn-success">
                                                        <input type="radio" name="recommend"  id="option1" value="1" autocomplete="off" checked="true" class="active">Yes
                                                    </label>
                                                    <label class="btn btn-default  " data-btn="btn-warning">
                                                        <input type="radio" name="recommend"  id="option2" value="2" autocomplete="off">No
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" value="Submit Review" class="btn btn-success " />
                                                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>     
            </div>
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">My Stats</h3><br>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Orders Completed :</th>
                                <td><p class="text-muted mb-0 badge badge-pill badge-info"><b>{{ $user->awarded }}</b></p></td>
                            </tr>
                            <tr>
                                <th>Students Served :</th>
                                <td><p class="text-muted mb-0 badge badge-pill badge-info"><b>{{ $user->students_helped }}</b></p></td>
                            </tr>
                            <tr>
                                <th scope="row">My Current Rating : </th>
                                <td><p class="text-muted mb-0 badge badge-pill badge-info">{{round( $meanscore,2) }}/5</span></span></p></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>       
        </div>
    </div>
    <div class="col-xl-8">
        @if(Auth::user()->role==1)	
        <div class="row">
            <div class="col-6">
                
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body"><h3>Completed Orders</h3></div>
                                <div><h3 class="badge badge-warning">{{ count($orders) }}</h3></div>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>
        @endif
        <!-- end row -->
        @if(Auth::user()->role==1)		
        @include('partials.recentorder')
         @endif
         @if(Auth::user()->role==3)		
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3>My Profile</h3>
                        <p>{!!($bio!="") ? $bio->bio:''!!}</p><br>
                    <h3>My Majors</h3>
                    <p> 
    					@if($speciality!="")
        					<?php
        					$categories = '';
        					$cats = explode(",",(string)$speciality->course);
        					foreach($cats as $cat) {
        					$cat = trim($cat);
        					$cat ;
        					echo('<span class=" badge badge-pill badge-info">'.$cat.'</span>'."&nbsp;");
        					}
        					?>
    					@else
    					<span class="badge badge-pill badge-info">General Writer</span>
    					@endif
			        </p>
                </div>
            </div>
            </div>
        </div>
        @endif
        @include('partials.reviews')
        @if(Auth::user()->role==1)		
        @include('partials.transactions')
        @endif
        @if(Auth::user()->role==1)		
        @include('partials.actions')
        @endif
    </div>
</div>

@endsection