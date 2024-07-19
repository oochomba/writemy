<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Opayment;
use App\Wallet;
use App\User;
use Carbon\Carbon;
use Redirect;
class AccounttransactionsController extends Controller{
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
     
	public function creditAccount(Request $request){
		$user=$request->user;
		$amount=$request->amount;
		$orderid=$request->orderid;
		$narration=$request->narration;
		$sbalance=Wallet::where('user_id',$user)->first();			
		//write money Transactions
		$spay=new Opayment;
		$spay->user_id=$user;
		$spay->amount=$amount;
		$spay->balance=$sbalance->balance+$amount;
		$spay->order_id="";
		$spay->type=5;
		$spay->status=1;
		$spay->narration="Your account has been loaded with $ ".$amount.".";
		$spay->save();
					
		$wallet=Wallet::where('user_id',$user)->first();
		$wallet->balance=$wallet->balance+$amount;
		$wallet->save();
		
		$mfrom=Auth::user()->id;	
		$mto=$user;
		$message="You account wallet has been loaded with $ ".$amount.".";
		$msubject="Wallet Loaded";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
	//app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		flash('Account loaded successfully.','success');
			return Redirect::back();
			
	}
	 
	public function debitAccount(Request $request){
		
	 	$user=$request->user;
		$amount=$request->amount;
		$orderid=$request->orderid;
		$narration=$request->narration;
		$sbalance=Wallet::where('user_id',$user)->first();			
		//write money Transactions
		$spay=new Opayment;
		$spay->user_id=$user;
		$spay->amount=$amount;
		$spay->balance=$sbalance->balance-$amount;
		$spay->order_id="";
		$spay->type=5;
		$spay->status=1;
		$spay->narration="You account wallet has been debited for $ ".$amount.".";
		$spay->save();
					
		$wallet=Wallet::where('user_id',$user)->first();
		$wallet->balance=$wallet->balance-$amount;
		$wallet->save();
		
		$mfrom=Auth::user()->id;	
		$mto=$user;
		$message="You account wallet has been debited for $ ".$amount.".";
		$msubject="Wallet Debited";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
	//app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		flash('Account debited successfully.','success');
			return Redirect::back();
	}
	public function verifyAccount(Request $request){
	 	$user=$request->tutor;
	 	$verify=User::where('id',$user)->first();
	 	if($verify->role==4){
	 	User::where('id',$user)->update(['verified'=>1]);
		$mfrom=Auth::user()->id;	
		$mto=$user;
		$message="Congratulations. We are pleased to inform you that your account has been verified. Ensure you submit high quality work to rise through the academic ranking. ";
		$msubject="Congratulations! Account Verified!";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
	//app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		flash('Account Verified.','success');
			return Redirect::back();
		}else{
			flash('Account Verified.','success');
			return Redirect::back();	
		}
	 	
	 	
	 	
	 		
	}
	public function unverifyAccount(Request $request){
	 		$user=$request->tutor;
	 	$verify=User::where('id',$user)->first();
	 	if($verify->role==4){
	 	User::where('id',$user)->update(['verified'=>0]);
		$mfrom=Auth::user()->id;	
		$mto=$user;
		$message="Regretfully, we are writing to inform you that your account has been unverified.You will need to apply for verification afresh.  ";
		$msubject="Regrets! Account Unverified!";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
	//app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		flash('Account Unverified.','success');
			return Redirect::back();
		}else{
			flash('Account Unverified.','success');
			return Redirect::back();	
		}
	 	
	 	
	}
	 
	public function disableAccount(Request $request){
	 			$user=$request->tutor;
	 	$verify=User::where('id',$user)->first();
	 	if($verify->role==4||$verify->role==3){
	 	User::where('id',$user)->update(['verified'=>0,'isdeleted'=>1]);
		$mfrom=Auth::user()->id;	
		$mto=$user;
		$message="Regretfully, we are writing to inform you that your account has been disabled.You will no longer be able to login into the system. We wish you the very best in your future endervours ";
		$msubject="Regrets! Account Disabled!";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
	//app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		flash('Account Disabled.','success');
			return Redirect::back();
		}else{
			flash('Account Disabled.','success');
			return Redirect::back();	
		}
	}
}