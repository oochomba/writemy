<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Opayment;
use App\Wallet;
use App\Award;
use App\User;
use App\Cheque;
use App\Bid;
use App\Order;
use App\Mail\ProjectAssigned;
use App\Mail\RefundIssued;
use Carbon\Carbon;
use App\Credit;
use App\Upgrade;
use App\Message;
use App\Refund;
use App\Dispute;
use App\Question;
use App\Pesapal;
use App\Pesawallet;
use DB;
use Mail;
use URL;
use DateTime;
use DateInterval;
use Redirect;
use \OAuth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
require('OAuth.php');
class PesapalController extends Controller{
    
	public function __construct(){
		$this->middleware('auth');
	}
	public function checkOutPesapal($id){
        $bid=Bid::findOrFail($id);
        $order=Order::findOrFail($bid->question_id);
        $user=User::findOrFail($order->user_id);
		return view('orders.pesapal',compact('bid','order','user'));
	}

	public function loadPesa(Request $request){
		$amounts=$request->amount;		
		$emails=auth::user()->email;
		$random = Str::random(10);
		$pesa=new Pesawallet;
		$pesa->refid=$random;
		$pesa->user_id=auth::user()->id;
		$pesa->amount=$amounts;
		$pesa->save();
		return view('orders.loadpesa',compact('amounts','emails','random'));
	}

	public function loadSuccess($id){
		$bidder = Pesawallet::where('refid',$id)->first();
		$amount=$bidder->amount;
		$paypals=Pesapal::findOrFail(1);
			$paypals->total=$paypals->total+$amount;
			$paypals->save();
			$credits= Credit::findOrFail(1);
			$credits->amount=$credits->amount+$amount;
			$credits->save();
			
			
			$sbalance=Wallet::where('user_id',Auth::user()->id)->first();
			
			//write money Transactions
			$spay=new Opayment;
			$spay->user_id=Auth::user()->id;
			$spay->amount=$amount;
			$spay->balance=$sbalance->balance+$amount;
			$spay->order_id="";
			$spay->type=7;
			$spay->status=1;
			$spay->pg=2;
			$spay->narration="You loaded your wallet with $.".$amount;
			$spay->save();
			
			$wallet=Wallet::where('user_id',Auth::user()->id)->first();
			$wallet->balance=$wallet->balance+$amount;
			$wallet->save();

			$mfrom=Auth::user()->id;	
			$mto=Auth::user()->id;
			$message="You have loaded your wallet with $ ".$amount.".";
			$msubject="Wallet Loaded";
			$datecreated=Carbon::now();
			$user_id=Auth::user()->id;		
		 //app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		 
			
			flash('Transaction successful, You have added $'.$amount.' to your wallet.','success');
			$route=URL::to('/financial-transactions');
			return redirect($route);	
	}
    
    public function paymentSuccess($id)
	{
            $bidder = Bid::findOrFail($id);
            //do the rest of the transaction  
    
            $amount = $bidder->price;
            $title = Order::findOrFail($bidder->question_id);
            $authid = $title->user_id;
            $bidder->status = 1;
            $bidder->buyer_id = $authid;
            $bidder->save();
    
            $order = Order::findOrFail($bidder->question_id);
            $order->amount = $amount;
            $order->status = 2;
            $order->paid = 1;
            $order->writerpay = 3 * $order->pages;
            $order->tutor_id = $bidder->user_id;
            $order->save();
    
            $paypals = Pesapal::findOrFail(1);
            $paypals->total = $paypals->total + $amount;
            $paypals->save();
            $credits = Credit::findOrFail(1);
            $credits->amount = $credits->amount + $amount;
            $credits->save();
    
            $awards = Award::where('user_id', $bidder->user_id)->first();
            $awards->award = $awards->award + 1;
            $awards->save();
            $sawards = Award::where('user_id', $authid)->first();
            $sawards->award = $sawards->award + 1;
            $sawards->save();
    
            $sbalance = Wallet::where('user_id', $authid)->first();
            $tbalance = Wallet::where('user_id', $bidder->user_id)->first();
            //write money Transactions
            $spay = new Opayment;
            $spay->user_id = $authid;
            $spay->amount = $amount;
            $spay->balance = $sbalance->balance;
            $spay->order_id = $order->id;
            $spay->type = 1;
            $spay->status = 1;
            $spay->narration = "You have awarded project " . $order->id . " to a scholar.";
            $spay->save();
            $tpay = new Opayment;
            $tpay->user_id = $bidder->user_id;
            $tpay->amount = 3 * $order->pages;
            $tpay->balance = $tbalance->balance;
            $tpay->order_id = $order->id;
            $tpay->type = 1;
            $tpay->pg=2;
            $tpay->status = 1;
            $tpay->narration = "You have won bid on project " . $order->id;
            $tpay->save();
            $mfrom = $authid;
            $mto = $bidder->user_id;
            $message = "You have been assigned order #" . $order->id . ". Ensure you deliver timely quality work.";
            $msubject = "Order Assigned!";
            $datecreated = Carbon::now();
            $user_id = $authid;
            app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom, $mto, $msubject, $message, "", $datecreated, $user_id]);
            flash('Transaction successful, you have awarded the order to a scholar.', 'success');
            $url = "http://127.0.0.1:8000/order/" . $order->id;
            return Redirect::away($url);
        
        
    }
	
	public function buyBid(Request $request){
		$thisbid=$request->norderid;
		$bidder=Bid::where('id',$thisbid)->first();
		if($bidder->status==0){
	
			$amount=$bidder->price;
			$id=$bidder->user_id;
			$tutorial=$bidder->question_id;
			$writer=User::findOrFail($id);

			$adminname=User::findOrFail(1);
			//dd($adminname);
			$tutorpay=(($amount)*($writer->rate/100));		
			$writerpay=$tutorpay;
			$created=Carbon::now();
			$admin = DB::table('accounts')->where('user_id', 1)->first();
			$exists = DB::table('accounts')->where('user_id', $id)->first();
			$system_fee=Account::where('user_id',1)->first();
			$sellerbalance=Account::where('user_id',$writer->id)->first();



		
			if(!$exists){		
		
				$created=Carbon::now();
				$data = array(
				
					'user_id'=>$user_id,
					'balance' => 0,
					'created_at' => $created,
				);
				DB::table('accounts')->insert($data);
			}		
			if(!$admin){
			
		
				$created=Carbon::now();
				$data = array(
				
					'user_id'=>1,
					'balance' => 0,
					'created_at' => $created,
				);
				DB::table('accounts')->insert($data);
			}
	
			$payerbalance=Account::where('user_id', Auth::user()->id)->first();
			if($payerbalance->balance>=$amount){
		
				$record=Account::where('user_id', Auth::user()->id)->first();			
				DB::table('accounts')->where('user_id', Auth::user()->id)->update(['balance' =>($record->balance)-$amount]);
				$newbalance=Account::where('user_id', Auth::user()->id)->first();
				$buybalance=$newbalance->balance;				  
	
				//incrementing number of awarded projects to tutor
				$tutor_awarded=Award::where('user_id', $id)->first();
				DB::table('awards')->where('user_id', $id)->update(['award' =>(($tutor_awarded->award)+1),'created_at' =>$created]);
				//incrementing number of awarded projects by student
				$student_awarded=Award::where('user_id', Auth::user()->id)->first();
				DB::table('awards')->where('user_id', '=', Auth::user()->id)->update(['award' =>(($student_awarded->award)+1),'created_at' =>$created]);
				//update amount paid and writer pay
				DB::table('questions')->where('id', $tutorial)->update(['amount' => $amount,'writerpay'=>$writerpay,'tutor_assigned' =>$writer->username, 'tutor_id' =>$writer->id,'writerpaid'=>0,'completed' => 0,'assigned' => 1,'inbidding' => 0,'revision' => 0,'editting' => 0,'canceled' => 0,'paid' => 1]);
				//update bid bought		
				DB::table('bids')->where('id',$thisbid)->update(['amount' =>$amount,'status' =>'1','buyer_id' =>Auth::user()->id,'buyer' =>Auth::user()->username]);
				$data = array(				
					'user_id'=>Auth::user()->id,
					'payer'=>Auth::user()->username,
					'amount' => $amount,
					'balance' => $buybalance,
					'solution_id' => $tutorial,				
					'recepient' => $writer->username,
					'recepient_id' => $writer->user_id,
					'type' => 'Purchase',
					'narration'=>'You purchased a bid',
					'completed' => '1',				
					'created_at' => $created,
				);	
				$seller = array(				
					'user_id'=>$writer->user_id,
					'payer'=>Auth::user()->username,
					'amount' => $writerpay,
					'balance' => $sellerbalance->balance,
					'solution_id' => $tutorial,				
					'recepient' => $writer->username,
					'recepient_id' =>$writer->id,
					'type' => 'Sale',
					'narration'=>'Writer sold a bid',
					'completed' => '1',				
					'created_at' => $created,
				);
				$sys = array(				
					'user_id'=>$adminname->id,
					'payer'=>Auth::user()->username,
					'amount' => $amount,
					'balance' => $system_fee->balance+$amount,
					'solution_id' => $tutorial,				
					'recepient' => $adminname->username,
					'recepient_id' => $writer->user_id,
					'type' => 'Sale',
					'narration'=>'Bid purchased by client',
					'completed' => '1',				
					'created_at' => $created,
				);
	
				DB::table('payments')->insert($data);
				DB::table('payments')->insert($seller);
				DB::table('payments')->insert($sys);
	
				$updatecredits=Credit::where('id',1)->first();
				DB::table('credits')->where('id',1)->update(['total' =>($updatecredits->total)+$amount]);		
				Mail::to($writer->email)->send(new ProjectAssigned());			
				$notify=array(
					'user_id'=>Auth::user()->id,
					'notify'=>'You have assigned Project ID '.$tutorial.'.'.'The Tutor has been notified.',
					'status'=>1,
					'created_at'=>$created,
				);
				DB::table('notifications')->insert($notify);
				$notify=array(
					'user_id'=>$writer->id,
					'notify'=>'The client has assigned you Project ID '.$tutorial.'.',
					'status'=>1,
					'created_at'=>$created,
				);
				DB::table('notifications')->insert($notify);
				flash('Transaction successful, you have assigned the order to Tutor','success');	
				return Redirect::back();
				
			}else{
				$route=URL::to('/buy-bid',$thisbid);
				return redirect($route);

			}
		}else{
			flash('You have already purchased this bid','danger');	
			return Redirect::back();
			
		}
	}
	
	public function loadWallet(Request $request){
		
			$amount = $request->amounttoload;
			$created=Carbon::now();
			$record=Account::where('user_id', Auth::user()->id)->first();			
			if(DB::table('accounts')->where('user_id', Auth::user()->id)->update(['balance' =>($record->balance)+$amount]) ){
				$totaldeposits=Ndugu::where('id', '=', 1)->first();
				Ndugu::where('id', '=', 1)->update(['total' =>($totaldeposits->total)+$amount]);		
				$depositer = array(			
				'user_id'=>Auth::user()->id,
				'payer'=>Auth::user()->username,
				'amount' => $amount,
				'balance' => ($record->balance)+$amount,
				'type' => 'DooglePay',
				'recepient' => 'System',
				'narration' => 'Loaded wallet via Credit Card',
				'method' => 2,
				'completed' => '1',
				'created_at' => $created,
			);
				
				DB::table('payments')->insert($depositer);
				
						
				flash('Transaction successful. You have credited your wallet.','success');
				return redirect('/mypayment');
			}
	}
	
	public function dooglePayments(){
		$loads=Payment::where('type','DooglePay')->orderBy('created_at', 'desc')->paginate(200);
		$purchases=Payment::where('type','Purchase')->where('method',2)->orderBy('created_at', 'desc')->paginate(200);
		return view('payments.doogle',compact('loads','purchases'));
	}
	
	public function paypalsPayment(){
		$loads=Payment::where('type','Paypal')->orderBy('created_at', 'desc')->paginate(200);
		$purchases=Payment::where('type','Purchase')->where('method',1)->orderBy('created_at', 'desc')->paginate(200);
		return view('payments.paypals',compact('loads','purchases'));
	}
}
