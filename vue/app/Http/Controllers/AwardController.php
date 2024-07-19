<?php

namespace App\Http\Controllers;
use DB;
use URL;
use App\Bid;
use Session;
use App\User;
use Redirect;
use App\Award;
use App\Order;
use Validator;
use App\Credit;
use App\Paypal;
use App\Rating;
use App\Wallet;
use App\Account;
//use App\Payment;
use App\Opayment;
use App\Pgsetting;
use Carbon\Carbon;
use PayPal\Api\Item;

//use Input;
use PayPal\Api\Payer;
use App\Http\Requests;

// All Paypal Details class
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use App\Additionalservice;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use Illuminate\Http\Request;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use PayPal\Auth\OAuthTokenCredential;

class AwardController extends Controller{

	private $_api_context;
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct(){
		
        
		$this->moduleTitleS = 'addmoney';
		$this->moduleTitleP = 'themes.userTheme.addMoney';

		view()->share('moduleTitleP',$this->moduleTitleP);
		view()->share('moduleTitleS',$this->moduleTitleS);
		$pp=Pgsetting::where('pg_id',1)->where('active',1)->first();
		// setup PayPal api context
		$paypal_conf = \Config::get('paypal');
		$this->_api_context = new ApiContext(new OAuthTokenCredential($pp->pgclient, $pp->pgsecret));
		$this->_api_context->setConfig($paypal_conf['settings']);
    }
    
    public function payOrderWallet(Request $request){
		
        $thisbid=$request->bid;
		$biddetails=Bid::findOrFail($thisbid);
        $title=Order::findOrFail($biddetails->question_id);
        $authid=$title->user_id;
		$bidamount=$biddetails->price;
		$user_id = $authid;
		$hasmoney=Wallet::where('user_id',$authid)->first();
		$bidder=Bid::findOrFail($thisbid);
		$ucpp=User::findOrFail($bidder->user_id);
		$asum=Additionalservice::where('order_id',$title->id)->sum('price');
		if($hasmoney->balance>=$bidamount+$asum){
			$amount=$bidamount;			
			$bidder->status=1;
			$bidder->buyer_id=$authid;
			$bidder->save();
			
			$order=Order::findOrFail($bidder->question_id);
			$order->amount=$amount;
			$order->status=2;
			$order->paid=1;
			$order->writerpay=$ucpp->cpp*$order->pages;
			$order->tutor_id=$bidder->user_id;
			$order->save();
			
			$awards=Award::where('user_id',$bidder->user_id)->first();
			$awards->award=$awards->award+1;
			$awards->save();
			$sawards=Award::where('user_id',$authid)->first();
			$sawards->award=$sawards->award+1;
			$sawards->save();
			
			//$sbalance=Wallet::where('user_id',$authid)->first();
			$tbalance=Wallet::where('user_id',$bidder->user_id)->first();
			//write money Transactions
			$wallet=Wallet::where('user_id',$authid)->first();
		$wallet->balance=$wallet->balance-$amount;
		$wallet->save();
			$spay=new Opayment;
			$spay->user_id=$authid;
			$spay->amount=$amount;
			$spay->balance=$wallet->balance;
			$spay->order_id=$order->id;
			$spay->type=1;
			$spay->status=1;
			$spay->narration="You have awarded project ".$order->id." to a scholar.";
			$spay->save();
			$tpay=new Opayment;
			$tpay->user_id=$bidder->user_id;
			$tpay->amount=$ucpp->cpp*$order->pages;
			$tpay->balance=$tbalance->balance;
			$tpay->order_id=$order->id;
			$tpay->type=1;
			$tpay->status=1;
			$tpay->narration="You have won bid on project ".$order->id;
			$tpay->save();
			
			
			$mfrom=$authid;	
		$mto=$bidder->user_id;
		$message="You have been assigned order #".$order->id.". Ensure you deliver timely quality work.";
		$msubject="Order Assigned!";
		$datecreated=Carbon::now();
		$user_id=$authid;		
		app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			flash('Transaction successful, you have awarded the order to a scholar.','success');
			$route=URL::to('/order',$order->id);
            return redirect($route);
        }else{
            flash('Not enough money, please top up account.','danger');
			$route=URL::to('/financial-transactions');
            return redirect($route);
        }
    }
	
	
	
	public function assignScholar(Request $request){	
		$thisbid=$request->bid;
		$biddetails=Bid::findOrFail($thisbid);
		$title=Order::findOrFail($biddetails->question_id);
		$asum=Additionalservice::where('order_id',$title->id)->sum('price');
        $authid=$title->user_id;
		$bidamount=$biddetails->price+$asum;
		$user_id = $authid;
		$hasmoney=Wallet::where('user_id',$authid)->first();
		$bidder=Bid::findOrFail($thisbid);
		$ucpp=User::findOrFail($bidder->user_id);
		$payer = new Payer();
		$payer->setPaymentMethod('paypal');

		$item_1 = new Item();

		$item_1->setName($thisbid.'|'.$title->id) // item name
		->setCurrency('USD')
		->setQuantity(1)
		->setPrice($bidamount); 
	

		
		$item_list = new ItemList();
		$item_list->setItems(array($item_1));

		$amount = new Amount();
		$amount->setCurrency('USD')
		->setTotal($bidamount);
     
		$transaction = new Transaction();
		$transaction->setAmount($amount)
		->setItemList($item_list)
		->setDescription($thisbid.'|'.$title->title);
     
		$redirect_urls = new RedirectUrls();
		$redirect_urls->setReturnUrl(URL::route('complete-order-pay')) // Specify return URL
		->setCancelUrl(URL::route('cancel-order-pay'));
     
		$payment = new Payment();
		$payment->setIntent('Sale')
		->setPayer($payer)
		->setRedirectUrls($redirect_urls)
		->setTransactions(array($transaction));
		// dd($payment->create($this->_api_context));exit;
		try{
			$payment->create($this->_api_context);
		} catch(\PayPal\Exception\PPConnectionException $ex){
			if(\Config::get('app.debug')){
				notificationMsg('error','Connection timeout');
				return Redirect::route('addmoney.paywithpaypal');
				// echo "Exception: " . $ex->getMessage() . PHP_EOL;
				// $err_data = json_decode($ex->getData(), true);
				// exit;
			} else{
				notificationMsg('error','Some error occurred, sorry for the Inconvenience');
				//return Redirect::route('addmoney.paywithpaypal');
				// die('Some error occur, sorry for inconvenient');
			}
		}
     
		foreach($payment->getLinks() as $link){
			if($link->getRel() == 'approval_url'){
				$redirect_url = $link->getHref();
				break;
			}
		}
     
		// add payment ID to session
		Session::put('paypal_payment_id', $payment->getId());
     
		if(isset($redirect_url)){
			// redirect to paypal
			return Redirect::away($redirect_url);
		}

		//notificationMsg('error','Unknown error occurred');
		return Redirect::route('addmoney.paywithpaypal');	
		
	}
	
	public function getCancel(){
		$route=URL::to('/home');
			return redirect($route);
	}

	public function getPaymentStatus(){
		// Get the payment ID before session clear
		$payment_id = Session::get('paypal_payment_id');
		// clear the session payment ID
		Session::forget('paypal_payment_id');
		if(empty(Input::get('PayerID')) || empty(Input::get('token'))){
			//notificationMsg('error','Payment failed');
			// return Redirect::route('addmoney.paywithpaypal');
		}
		$payment = Payment::get($payment_id, $this->_api_context);
		// PaymentExecution object includes information necessary 
		// to execute a PayPal account payment. 
		// The payer_id is added to the request query parameters
		// when the user is redirected from paypal back to your site
		$execution = new PaymentExecution();
		$execution->setPayerId(Input::get('PayerID'));
		//Execute the payment
		$result = $payment->execute($execution, $this->_api_context);
		//echo '<pre>';print_r($result);echo '</pre>';exit; // DEBUG RESULT, remove it later
        
       
        
		if($result->getState() == 'approved'){ 
		
			$amount = $result->transactions[0]->amount->total;
			$thisbid = $result->transactions[0]->description;
			$bidTitle = $thisbid;
			$bidID = explode('|',$bidTitle);
			$bid = $bidID[0];
            $bidder=Bid::findOrFail($bid);
            $title=Order::findOrFail($bidder->question_id);
            $authid=$title->user_id;
			$bidder->status=1;
			$bidder->buyer_id=$authid;
			$bidder->save();
			
			$order=Order::findOrFail($bidder->question_id);
			$order->amount=$amount;
			$order->status=2;
			$order->paid=1;
			$order->writerpay=3*$order->pages;
			$order->tutor_id=$bidder->user_id;
			$order->save();
			
			$paypals=Paypal::findOrFail(1);
			$paypals->total=$paypals->total+$amount;
			$paypals->save();
			$credits= Credit::findOrFail(1);
			$credits->amount=$credits->amount+$amount;
			$credits->save();
			
			$awards=Award::where('user_id',$bidder->user_id)->first();
			$awards->award=$awards->award+1;
			$awards->save();
			$sawards=Award::where('user_id',$authid)->first();
			$sawards->award=$sawards->award+1;
			$sawards->save();
			
			$sbalance=Wallet::where('user_id',$authid)->first();
			$tbalance=Wallet::where('user_id',$bidder->user_id)->first();
			//write money Transactions
			$spay=new Opayment;
			$spay->user_id=$authid;
			$spay->amount=$amount;
			$spay->balance=$sbalance->balance;
			$spay->order_id=$order->id;
			$spay->type=1;
			$spay->pg=1;
			$spay->status=1;
			$spay->narration="You have awarded project ".$order->id." to a scholar.";
			$spay->save();
			$tpay=new Opayment;
			$tpay->user_id=$bidder->user_id;
			$tpay->amount=3*$order->pages;
			$tpay->balance=$tbalance->balance;
			$tpay->order_id=$order->id;
			$tpay->type=1;
			$spay->pg=1;
			$tpay->status=1;
			$tpay->narration="You have won bid on project ".$order->id;
			$tpay->save();
			$mfrom=$authid;	
		$mto=$bidder->user_id;
		$message="You have been assigned order #".$order->id.". Ensure you deliver timely quality work.";
		$msubject="Order Assigned!";
		$datecreated=Carbon::now();
		$user_id=$authid;		
		app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			flash('Transaction successful, you have awarded the order to a scholar.','success');
			$route=URL::to('/order',$order->id);
            return redirect($route);   			
			
		}else{
			flash('Transaction failed! Try again.','danger');
			$route=URL::to('/payment-failed');
			return redirect($route);
		}
		
	}

    
}
