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
use App\Opayment;
use App\Paypal;

//use Input;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Pgsetting;
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

class LoadfundsController extends HomeController{

	private $_api_context;
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct(){
		parent::__construct();
        
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
	
	
	
	public function loadfunds(Request $request){
	
		$amountpaid=$request->amount;
		$title="Loaded funds on ".Config('app.name');
		
		
		$payer = new Payer();
		$payer->setPaymentMethod('paypal');

		$item_1 = new Item();

		$item_1->setName($title) // item name
		->setCurrency('USD')
		->setQuantity(1)
		->setPrice($amountpaid); 
		$item_list = new ItemList();
		$item_list->setItems(array($item_1));

		$amount = new Amount();
		$amount->setCurrency('USD')
		->setTotal($amountpaid);
     
		$transaction = new Transaction();
		$transaction->setAmount($amount)
		->setItemList($item_list)
		->setDescription($title);
     
		$redirect_urls = new RedirectUrls();
		$redirect_urls->setReturnUrl(URL::route('complete-load-funds')) // Specify return URL
		->setCancelUrl(URL::route('cancel-load'));
     
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
		//$payment_id = Session::get('paypal_payment_id');
		// clear the session payment ID
		$input = \Request::all();
		$paymentID=$input['paymentId'];
		$token=$input['token'];
		$PayerID=$input['PayerID'];
		
		
		$payment = Payment::get($paymentID, $this->_api_context);
		// PaymentExecution object includes information necessary 
		// to execute a PayPal account payment. 
		// The payer_id is added to the request query parameters
		// when the user is redirected from paypal back to your site
		$execution = new PaymentExecution();
		$execution->setPayerId($PayerID);
		//Execute the payment
		$result = $payment->execute($execution, $this->_api_context);
		//echo '<pre>';print_r($result);echo '</pre>';exit; // DEBUG RESULT, remove it later
        
       
        
		if($result->getState() == 'approved'){ 
			$user_id = auth()->guard('web')->user()->id;		
			$amount = $result->transactions[0]->amount->total;
			
			$paypals=Paypal::findOrFail(1);
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
			$spay->pg=1;
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
			
			
		}else{
			flash('Transaction failed! Try again.','danger');
			$route=URL::to('/home');
			return redirect($route);
		}
		
	}

    
}
