<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Message;
use App\User;
use App\Award;
use App\Rating;
use App\Wallet;
use App\Qmailer;
use App\Messagefile;
use Session;
use Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
class UseraccountsController extends Controller{
	public function __construct(){
    	
		$this->middleware('auth');
	}
    
    
	public function addUser(){
		return view('users.adduser');
	}
	public function viewClients(){
		$clients=User::where('role',3)->where('isdeleted',0)->orderBy('created_at','DESC')->get();
		return view('users.clients',compact('clients'));
	}

	public function staff(){
		$clients=User::where('role',1)->OrWhere('role',2)->orderBy('created_at','DESC')->get();
		return view('users.staff',compact('clients'));
	}
	
	public function viewWriters(){
		$writers=User::where('role',4)->where('isdeleted',0)->orderBy('created_at','DESC')->get();
		return view('users.writers',compact('writers'));
	}
	
	public function deactivatedAccounts(){
		$inactives=User::where('isdeleted',1)->orderBy('created_at','DESC')->get();
		return view('users.deleted',compact('inactives'));
	}
	
	public function postUser(Request $request){		

		$name=$request->name;	
		$email=$request->email;
		$pass=$request->password;
		$role=$request->userole;
		
		
		
		$emailexists=User::where('email',$email)->first();
		if($emailexists==""){
			$lastuser=User::latest()->first();
			if(count($lastuser)>0){
				$rand=rand(11111,111111);
				$id=$lastuser->id+12000+$rand;
			}else{
				$rand=rand(11111,111111);
				$id=12000+$rand;
			}
			$user=new User;
			$user->id=$id;
			$user->name=$name;
			$user->email=$email;
			$user->password=bcrypt($pass);
			$user->role=$role;
			$user->save();
		
			$wallet=new Wallet;
			$wallet->user_id=$id;
			$wallet->balance=0;
			$wallet->save();
			
			$awards=new Award;
			$awards->user_id=$id;
			$awards->award=0;
			$awards->save();
			
			$ratings=new Rating;
			$ratings->user_id=$id;
			$ratings->score=0;
			$ratings->reviews=0;
			$ratings->save();
		
			$mfrom=Auth::user()->id;	
			// dd($mfrom);
			$mto=$id;
			$message="You account has been created. Your email is ".$email." and your password is ".$pass.". Change password on login. ";
			$msubject="Account Created";
			$datecreated=Carbon::now();
			$user_id=Auth::user()->id;
		
			app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			flash('User registered successfully.','success');
			return Redirect::back();
		}else{
			flash('This email is already registered!','danger');
			return Redirect::back();
		}
	}
	
	public function changePassword(Request $request){
		$pass=$request->password;
		$cpass=$request->confirmpassword;
		$validator = Validator::make($request->all(), [
				'password' => 'required|confirmed|min:6',
			]);

		if($validator->fails()){
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
			->withErrors($validator)
			->withInput();
		}else{
			$user=User::findOrFail(Auth::user()->id);
			$user->password=bcrypt($pass);
			$user->save();
			$mfrom=Auth::user()->id;	
			$mto=Auth::user()->id;
			$message="You account password has been changed. The new password is ".$pass." .";
			$msubject="Password Changed!!";
			$datecreated=Carbon::now();
			$user_id=Auth::user()->id;
		
			//app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,$datecreated,$user_id]);
	
			flash('Password changed successfully','success');
			return Redirect::back();
		}
	}
	
	public function impersonate($id){
		$user = User::find($id);

		// Guard against administrator impersonate
		if(($user->role==3||$user->role==4 ||$user->role==2)&& Auth::user()->role==1){
			if ($user->id !== ($original = Auth::user()->id)) {
            session()->put('original_user', $original);
            auth()->login($user);
            Session::put('imposter', 1);
        }
			flash()->success('Your are logged in as '.$user->name);
        return redirect('/home');
		}
		else{
			flash()->error('Impersonate disabled for this user.');
		}

		return redirect()->back();
	}


	public function stopImpersonate(){
		auth()->loginUsingId(session()->get('original_user'));

        session()->forget('original_user');

Session::put('imposter', 0);
flash()->success('Welcome Back');
		return redirect()->back();
	}
}