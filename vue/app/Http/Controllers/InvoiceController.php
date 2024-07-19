<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Carbon\Carbon;
use App\Bid;
use App\Order;
use App\Wallet;
use App\Credit;
use App\Award;
use App\Rating;
//use App\Payment;
use App\User;
use App\Account;
use App\Invoice;
use App\Opayment;
use App\Paypal;
use App\Pgsetting;

//use Input;
use DB;
use Illuminate\Support\Facades\Auth;

// All Paypal Details class
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class InvoiceController extends Controller{

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
	
	
	public function payInvoice(Request $request){		
        $order=$request->invid;
     
		if($order!=""){		
        $vid=Invoice::findOrFail($order);
        $title=Order::findOrFail($vid->order_id);
		$tip=$vid->amount;
		$user_id = $vid->client_id;		
		$payer = new Payer();
		$payer->setPaymentMethod('paypal');
		$item_1 = new Item();
		$item_1->setName($vid->id.'|'.$title->id) // item name
		->setCurrency('USD')
		->setQuantity(1)
		->setPrice($tip); 
		$item_list = new ItemList();
		$item_list->setItems(array($item_1));

		$amount = new Amount();
		$amount->setCurrency('USD')
		->setTotal($tip);
     
		$transaction = new Transaction();
		$transaction->setAmount($amount)
		->setItemList($item_list)
		->setDescription($vid->id.'|'.$title->id);
     
		$redirect_urls = new RedirectUrls();
		$redirect_urls->setReturnUrl(URL::route('complete-invoice-payment')) // Specify return URL
		->setCancelUrl(URL::route('cancel-invoice'));
     
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
	}
	
	public function getCancel(){
			$route=URL::to('/');
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
            $bidder=Invoice::findOrFail($bid);
            $user_id = $bidder->client_id;
			$id=Order::findOrFail($bidder->order_id);
			$writerid=$id->tutor_id;
			$paypals=Paypal::findOrFail(1);
			$paypals->total=$paypals->total+$amount;
			$paypals->save();
			$credits= Credit::findOrFail(1);
			$credits->amount=$credits->amount+$amount;
			$credits->save();
			
			$sbalance=Wallet::where('user_id',$user_id)->first();	
			//write money Transactions
			$spay=new Opayment;
			$spay->user_id=Auth::user()->id;
			$spay->amount=$amount;
			$spay->balance=$sbalance->balance;
			$spay->order_id=$id->id;
			$spay->type=1;
			$spay->status=1;
			$spay->narration="Invoice paid for order # ".$id->id.".";
            $spay->save();
            $vid=Invoice::findOrFail($bid);
            $vid->status=1;
            $vid->save();
						
			$updatewallet=Wallet::where('user_id',$writerid)->first();
			$updatewallet->balance=$updatewallet->balance+$amount;
			$updatewallet->save();

			$mfrom=Auth::user()->id;	
			$mto=Auth::user()->id;
			$message="Your invoice payment has been received";
			$msubject="Invoice Paid";
			$datecreated=Carbon::now();
			$user_id=Auth::user()->id;		
		 app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		 

			flash('Payment Successful.','success');
			$route=URL::to('/payment-successful');
			return redirect($route);
			
			
		}else{
			flash('Transaction failed! Try again.','danger');
			$route=URL::to('/home');
			return redirect($route);
		}
		
	}

    
}
