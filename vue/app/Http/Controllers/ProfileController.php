<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Rating;
use App\Review;
use Carbon\Carbon;
use App\Specialization;
use App\Profile;
use App\Order;
use App\Wallet;
use App\Award;
use Redirect;
use Validator;
class ProfileController extends Controller{
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct(){
		$this->middleware('auth');
	}

	/**
	* Show the application dashboard.
	*
	* @return \Illuminate\Http\Response
	*/
	public function getProfile($id){
		$user=User::findOrFail($id);

		$uwallet=Wallet::where('user_id',$id)->first();
		$uawards=Award::where('user_id',$id)->first();
		$uratings=Rating::where('user_id',$id)->first();
		
		if($uwallet==""){
			$wallet=new Wallet;
			$wallet->user_id=$id;
			$wallet->balance=0;
			$wallet->save();
		}
		if($uawards==""){
			$awards=new Award;
			$awards->user_id=$id;
			$awards->award=0;
			$awards->save();
		}
		if($uratings==""){
			$ratings=new Rating;
			$ratings->user_id=$id;
			$ratings->score=0;
			$ratings->reviews=0;
			$ratings->save();
		}
		return view('profile.public',compact('user'));
	}
    
	public function reviewScholar(Request $request){
		$order=$request->order;
		$oreview=Review::where('order_id',$order)->first();
		if($oreview==""){
			$order=$request->order;
			$rating=$request->rating;
			$comments=$request->comments;
			$recommend=$request->recommend;
			$orderid=Order::findOrfail($order);
			$review=new Review;
			$review->student_id=Auth::user()->id;
			$review->tutor_id=$orderid->tutor_id;
			$review->review=$comments;
			$review->rating=$rating;
			$review->recommend=$recommend;
			$review->order_id=$order;
			$review->save();
		
			$scores=Rating::where('user_id',$orderid->tutor_id)->first();
			$scores->score=$scores->score+$rating;
			$scores->reviews=$scores->reviews+1;
			$scores->save();
			$mfrom=Auth::user()->id;	
		$mto=$orderid->tutor_id;
		$message="You order #".$order." has received a rating of ".$rating.". Check your scholary progress.";
		$msubject="You have been Reviewed";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;
		
	app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			flash('Thank you for the review.','success');
			return Redirect::back();
		}else{
			flash('You have already reviewed this scholar.','danger');
			return Redirect::back();
		}
	}
	
	public function adminReview(Request $request){
				if(Auth::user()->role==1){
			$student=$request->student;
			$tutor=$request->tutor;
			$rating=$request->rating;
			$comments=$request->comments;
			$recommend=$request->recommend;
			$review=new Review;
			$review->student_id=$student;
			$review->tutor_id=$tutor;
			$review->review=$comments;
			$review->rating=$rating;
			$review->recommend=$recommend;
			$review->save();
		
			$scores=Rating::where('user_id',$tutor)->first();
			$scores->score=$scores->score+$rating;
			$scores->reviews=$scores->reviews+1;
			$scores->save();
			
			flash('Thank you for the review.','success');
			return Redirect::back();
				}else{
					flash('Invalid request.','danger');
					return redirect()->back();
				}
			
		
	}
	
	public function viewProfile(){
		$user=Auth::user()->id;
		$uwallet=Wallet::where('user_id',$user)->first();
		$uawards=Award::where('user_id',$user)->first();
		$uratings=Rating::where('user_id',$user)->first();
		
		if($uwallet==""){
			$wallet=new Wallet;
			$wallet->user_id=$user;
			$wallet->balance=0;
			$wallet->save();
		}
		if($uawards==""){
			$awards=new Award;
			$awards->user_id=$user;
			$awards->award=0;
			$awards->save();
		}
		if($uratings==""){
			$ratings=new Rating;
			$ratings->user_id=$user;
			$ratings->score=0;
			$ratings->reviews=0;
			$ratings->save();
		}
		$user=User::findOrFail(Auth::user()->id);
		return view('profile.profile',compact('user'));
	}
	
	public function uploadPhoto(Request $request){
		
		if($request->hasFile('photo')){    
			$files = $request->photo;
			$rules = array('file' => 'required|mimes:gif,jpg,jpeg,png|max:20000'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
			$validator = Validator::make(array('file'=> $files), $rules);
			if($validator->passes()){
				$destinationPath = public_path('/assets/images/avatars/');						
				$upload_filename=time().' '.$files->getClientOriginalName();
				$upload_success = $files->move($destinationPath, $upload_filename);
						
				$user=User::findOrFail(Auth::user()->id);
				$user->avatar = $upload_filename;
				$user->save();
					
					
			}else{
				flash('Check your image.','success');
				return Redirect::back();
			}
			
			flash('Uploaded','success');
			return Redirect::back();
		}
			
		flash('failed','danger');
		return Redirect::back();
	}
	
	public function updateSpecialization(Request $request){
		$vehicleString = implode(",", $request->get('specialization'));
		$update=Specialization::where('user_id',Auth::user()->id)->first();
		if($update==""){
			$special=new Specialization;
			$special->user_id=Auth::user()->id;
			$special->course=$vehicleString;
			$special->save();
		}else{
			$special=Specialization::where('user_id',Auth::user()->id)->first();
			$special->user_id=Auth::user()->id;
			$special->course=$vehicleString;
			$special->save();
		}
		flash('Speciality updated.', 'success');
		return Redirect::back();
	}
	
	public function updateProfile(Request $request){
	$update=Profile::where('user_id',Auth::user()->id)->first();
	$edu=$request->education;
	$major=$request->major;
	$bio=$request->bio;
		if($update==""){
			$special=new Profile;
			$special->user_id=Auth::user()->id;
			$special->education=$edu;
			$special->major=$major;
			$special->bio=$bio;
			$special->save();
		}else{
			$special=Profile::where('user_id',Auth::user()->id)->first();
			$special->user_id=Auth::user()->id;
			$special->education=$edu;
			$special->major=$major;
			$special->bio=$bio;
			$special->save();
		}
		flash('Profile updated!', 'success');
		return Redirect::back();
	}
	
	public function admineditProfile(Request $request){
			$user=$request->user;
			$role=$request->userole;
			$level=$request->level;
			$name=$request->name;
			$email=$request->email;
			$special=User::where('id',$user)->first();
			$special->role=$role;
			$special->level=$level;
			$special->name=$name;
			$special->email=$email;
			$special->save();
			flash('Profile updated!', 'success');
		return Redirect::back();
	}
	
	public function addReviews(Request $request){
		$order=$request->order;
		$oreview=Review::where('order_id',$order)->first();
		if($oreview==""){
			$order=$request->order;
			$rating=$request->rating;
			$comments=$request->comments;
			$recommend=$request->recommend;
			$orderid=Order::findOrfail($order);
			$review=new Review;
			$review->student_id=Auth::user()->id;
			$review->tutor_id=$orderid->tutor_id;
			$review->review=$comments;
			$review->rating=$rating;
			$review->recommend=$recommend;
			$review->order_id=$order;
			$review->save();
		
			$scores=Rating::where('user_id',$orderid->tutor_id)->first();
			$scores->score=$scores->score+$rating;
			$scores->reviews=$scores->reviews+1;
			$scores->save();
			$mfrom=Auth::user()->id;	
		$mto=$orderid->tutor_id;
		$message="You order #".$order." has received a rating of ".$rating.". Check your scholary progress.";
		$msubject="You have been Reviewed";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;
		
	app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			flash('Thank you for the review.','success');
			return Redirect::back();
		}else{
			flash('You have already reviewed this scholar.','danger');
			return Redirect::back();
		}
	}
	
	
   
	
}
