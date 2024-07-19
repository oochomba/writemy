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
    .thumbn{max-width:50%;border-radius:50%;border:1px solid;}
</style>

<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-5">
				<div class="d-md-flex">
				 @if($user->role==4||$user->role==2||$user->role==1)
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
						<h3>{{ucfirst($user->name)}}</h3>
					
						<h5 class="font-size-13">Average Rating: <span class="badge badge-success font-size-14">{{round( $meanscore,2) }}</span>
                            @if($newwriter==1)
                                <p>(No Ratings)</p>
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
					@else
					<div>
                        <img alt="profile" class="thumbn" src="/postsimages/z.png">
                    </div>
                    
                    <div>
                        <h3>ID: {{ucfirst($user->name)}}</h3>
                        <p>All updates sent to: <a href>{{ ucfirst(auth::user()->email) }}</a></p>
                    </div>
                        
					@endif
			    </div>
			</div>
			@if($user->role!=3)
			<div class="col-md-6">
				<div class="row">
					<div class="d-md-block d-none border-left"></div>
					<div class="col">
						<ul class="list-unstyled m-t-10">
							<li class="row">
								<p class="col-sm-4 col-6 font-weight-semibold text-dark m-b-5">
									<span>Proven Reliability: </span> 
								</p>
								<p class="col font-weight-semibold text-info"> 100%  on Completed orders </p>
							</li>
							<li class="row">
								<p class="col-sm-4 col-6 font-weight-semibold text-dark m-b-5">
									<i class="m-r-10 text-info anticon anticon-star"></i>
									<span>Customer Satisfaction: </span> 
								</p>
								<p class="col font-weight-semibold text-info"> Over 95%, 5 Stars  Rating</p>
							</li>
							<li class="row">
								<p class="col-sm-4 col-6 font-weight-semibold text-dark m-b-5">
									<i class="m-r-10 text-info anticon anticon-clock-circle"></i>
									<span>Proven Punctuality: </span> 
								</p>
								<p class="col font-weight-semibold text-info"> 100% delivery before deadline.</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-8">
        @include('partials.updateprofile')
        @include('partials.recentorder')
        @include('partials.transactions')
        @include('partials.reviews')
	</div>
	<div class="col-md-4">
		<div class="card">
            <div class="card-header">
                <h4 class="card-title">Change Password</h4>
            </div>
            <div class="card-body">
                <form class="form-horizontal"  enctype="multipart/form-data" method="post" action="{{ url('/change-password') }}">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class=" control-label">Password</label>
                            <div class="">
                                <input id="password" type="password" placeholder="Your new password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password-confirm" class=" control-label">Confirm Password</label>
                            <div class="">
                                <input id="password-confirm" type="password" placeholder="Confirm new password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group ">
                            <button class="btn btn-primary btn-sm">Change</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if($user->role==4||$user->role==2||$user->role==1)
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Change Profile Picture</h4>
            </div>
            <div class="card-body">
                <form class="form-horizontal"  enctype="multipart/form-data" method="post" action="{{ url('/upload-photo') }}">
					{{ csrf_field() }}
					<input type="file" name="photo" accept="image/*" onchange="loadFile(event)">
					<img id="output" />
					<input type="submit" value="Upload Photo" class="btn btn-sm btn-info"/>
				</form>
            </div>
        </div>
          @endif
	</div>
</div>
<script>
	var loadFile = function(event) {
		var reader = new FileReader();
		reader.onload = function(){
			var output = document.getElementById('output');
			output.style.height = '75px';
			output.style.width = '75px';
			output.src = reader.result;
		};
		reader.readAsDataURL(event.target.files[0]);
	};
</script>
@endsection