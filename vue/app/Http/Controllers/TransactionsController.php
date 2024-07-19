<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Opayment;
use App\Order;
use App\User;
use App\Wallet;
use Carbon\Carbon;
use Redirect;
class TransactionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
  
    
    public function allTransactions(){
    	
    	if(Auth::user()->role==3){
		$transactions=Opayment::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
		}elseif(Auth::user()->role==4){
			$transactions=Opayment::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
		}elseif(Auth::user()->role==2){
			$transactions=Opayment::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
		}else{
			$transactions=Opayment::orderBy('id','DESC')->get();
		}
    	
		 return view('transactions.alltransactions',compact('transactions'));
	}
	public function makeWithdrawal(Request $request){
		$amount=$request->amount;
		$tutor=Wallet::where('user_id',Auth::user()->id)->first();
		
		if($tutor->balance>=$amount){			
	 	$user=Auth::user()->id;
		$amount=$request->amount;
		$orderid=$request->orderid;
		$narration=$request->narration;
		$tutor=Wallet::where('user_id',Auth::user()->id)->first();	
		//write money Transactions
		$spay=new Opayment;
		$spay->user_id=$user;
		$spay->amount=$amount;
		$spay->balance=$tutor->balance-$amount;
		$spay->order_id="";
		$spay->type=8;
		$spay->status=0;
		$spay->narration="You have made a withdrawal of $ ".$amount.".";
		$spay->save();
					
		$wallet=Wallet::where('user_id',$user)->first();
		$wallet->balance=$wallet->balance-$amount;
		$wallet->save();
		
		$mfrom=1;	
		$mto=$user;
		$message="You have made a withdrawal of $ ".$amount.".";
		$msubject="Withdrawal Transaction";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
	app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		flash('Withdrawal successfully.','success');
			return Redirect::back();
		}else{
				flash('Insufficient funds. Your account balance is $'.$tutor->balance.'.','danger');
		return Redirect::back();
		}
		
	}

	public function clientAnalysis(){
		$users=User::where('role',3)->orderBy('name','asc')->get();
		return view('transactions.clientanalysis',compact('users'));
	}

	public function withdrawalTransactions(){
		$transactions=Opayment::where('type',8)->orderBy('id','desc')->get();
		return view('transactions.withdrawals',compact('transactions'));
	}

	public function confirmTransaction(Request $request){
		$tid=$request->tid;
		$transaction=Opayment::where('id',$tid)->first();
		$transaction->status=1;
		$transaction->save();	
		$mfrom=1;	
		$mto=$transaction->user_id;
		$message="Your withdrawal transaction of $ ".$transaction->amount." has been processed.";
		$msubject="Withdrawal Processed";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
	app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		flash('Transaction confirmed successfully.','success');
			return Redirect::back();
	}
	public function declineTransaction(Request $request){
		$tid=$request->tid;
		$transaction=Opayment::where('id',$tid)->first();
		$transaction->status=1;
		$transaction->save();
		$wallet=Wallet::where('user_id',$transaction->user_id)->first();
		
		//write money Transactions
		$spay=new Opayment;
		$spay->user_id=$transaction->user_id;
		$spay->amount=$transaction->amount;
		$spay->balance=$wallet->balance+$transaction->amount;
		$spay->order_id="";
		$spay->type=8;
		$spay->status=1;
		$spay->narration="Withdrawal transaction of amount $ ".$transaction->amount." declined.";
		$spay->save();
		
		$wallet->balance=$wallet->balance+$transaction->amount;
		$wallet->save();						
			
		$mfrom=1;	
		$mto=$transaction->user_id;
		$message="Your withdrawal transaction of $ ".$transaction->amount." has been declined.";
		$msubject="Withdrawal Declined";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
	app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		flash('Transaction confirmed successfully.','success');
			return Redirect::back();
	}
	public function sendInvoice(Request $request){
		$orderid=$request->orderID;
		$amount=$request->amount;
		$order=Order::findOrFail($orderid);
		$clientid=$order->user_id;
		//create invoice and email the invoice
		$invoice=new Invoice();
		$invoice->order_id=$orderid;
		$invoice->client_id=$clientid;
		$invoice->amount=$amount;
		$invoice->save();
		$mfrom=1;	
		$mto=$clientid;
		$url="http://127.0.0.1:8000/invoice-checkout/".$invoice->id;	
		$message="You have received an invoice of $ ".$amount." for order #".$orderid.". Click <a href='$url'>here</a> to pay";
		$msubject="New Invoice";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
	app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		flash('Invoice sent successfully.','success');
		return Redirect::back();

	}

	public function financialAnalysis(){
		if(Auth::user()->role==3){
			$transactions=Opayment::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
			}elseif(Auth::user()->role==4){
				$transactions=Opayment::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
			}elseif(Auth::user()->role==2){
				$transactions=Opayment::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
			}else{
				$transactions=Opayment::orderBy('created_at','DESC')->get();
			}
			
			 return view('transactions.monthly',compact('transactions'));
	}
	
}
