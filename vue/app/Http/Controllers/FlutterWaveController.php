<?php
namespace App\Http\Controllers;

use DB;
//require_once '/home/tigauici9/public_html/src/Unirest.php';


use URL;
use Mail;
use Rave;
use App\Bid;
use App\User;
use DateTime;
use Redirect;
use App\Award;
use App\Order;
use App\Cheque;
use App\Credit;
use App\Paypal;
use App\Refund;
use App\Wallet;
use App\Account;
use App\Dispute;
use App\Flutter;
use App\Message;
use App\Payment;
use App\Pesapal;
use App\Upgrade;
use App\Opayment;
use App\Question;
use DateInterval;
use App\Flutteref;
use App\Pgsetting;
use Carbon\Carbon;
use App\AdditionalService;
use App\Mail\RefundIssued;
use Illuminate\Http\Request;
use App\Mail\ProjectAssigned;
//use Illuminate\Support\Facades\Auth;

use App\OrderAdditionalService;
use Illuminate\Support\Facades\Auth;

class FlutterWaveController extends Controller
{

  /**
   * Initialize Rave payment process
   * @return void
   */
  public function initialize()
  {
    //This initializes payment and redirects to the payment gateway
    //The initialize method takes the parameter of the redirect URL
    Rave::initialize(route('callback'));
  }

  /**
   * Obtain Rave callback information
   * @return void
   */
  public function callback(Request $request)
  {
    
    $data = Rave::verifyTransaction($request->txref);

    dd($data);
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Comfirm that the transaction is successful
        // Confirm that the chargecode is 00 or 0
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (includeing parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here

  }
  public function orderPaidSuccess($txref){
    $flutterpg=Pgsetting::where('pg_id',3)->first();

    $data = array('txref' => $txref,
    'SECKEY' =>  $flutterpg->pgsecret //secret key from pay button generated on rave dashboard
  );



  // make request to endpoint using unirest.
  $headers = array('Content-Type' => 'application/json');
  $body = \Unirest\Request\Body::json($data);
  $url = "https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/v2/verify"; //please make sure to change this to production url when you go live

// Make `POST` request and handle response with unirest
  $response = \Unirest\Request::post($url, $headers, $body);
  //dd($response);
  
  //check the status is success
  if ($response->body->status === "success" && $response->body->data->chargecode === "00" ) {
      //confirm that the amount is the amount you wanted to charge
      //get bid amount
     $thisbid=$txref;   
     
      $bidder=Bid::where('id',$thisbid)->first();		     
        $finalprice=$bidder->price;   	
        			     
    			
      if ($response->body->data->amount ==$finalprice) {
        //do the rest of the transaction  
        
            $bidder=Bid::findOrFail($thisbid);
            $amount=$bidder->price;
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
			
			$paypals=Flutter::findOrFail(1);
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
			$spay->pg=3;
			$spay->status=1;
			$spay->narration="You have awarded project ".$order->id." to a scholar.";
			$spay->save();
			$tpay=new Opayment;
			$tpay->user_id=$bidder->user_id;
			$tpay->amount=3*$order->pages;
			$tpay->balance=$tbalance->balance;
			$tpay->order_id=$order->id;
      $tpay->type=1;
      $spay->pg=3;
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
        //transaction amount verification failed redirect, liase with admin for confirmation
        	
      }
  }else{
  	
    // the transation was not found
    

  }
  }
  public function paymentFailed(){
    dd("Payment Failed");
  }
  public function loadWalletFlutter(Request $request){
    $data=[
      'refs'=>$request->rand,
      'user_id'=>$request->id,
      'amount'=>$request->amount
    ]; 
    DB::table('flutterefs')->insert($data);

    return json_encode(array(
        "statusCode"=>200
    ));
  }
  public function loadWallet(){
    return view('loadwallet');
  }

  public function walletLoadVerify($txref){
    $flutterpg=Pgsetting::where('pg_id',3)->first();

    $data = array('txref' => $txref,
    'SECKEY' =>  $flutterpg->pgsecret //secret key from pay button generated on rave dashboard
  );
    // make request to endpoint using unirest.
    $headers = array('Content-Type' => 'application/json');
    $body = \Unirest\Request\Body::json($data);
    $url = "https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/v2/verify"; //please make sure to change this to production url when you go live
  
  // Make `POST` request and handle response with unirest
    $response = \Unirest\Request::post($url, $headers, $body);
    //dd($response);
    
    //check the status is success
    if ($response->body->status === "success" && $response->body->data->chargecode === "00") {        
        $ref=Flutteref::where('refs',$txref)->first();
        //dd($ref->amount);
        if ($response->body->data->amount ===(int)($ref->amount)) {
          	
			$amount = $ref->amount;
			
			$paypals=Flutter::findOrFail(1);
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
			$spay->pg=3;
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
         // flash('Amount not verified.','danger');	
   // $route=URL::to('/mypayments');
    //return redirect($route);
    dd("Amount not verified");
        }

  }else{
    /*flash('Transaction not found.','danger');	
    $route=URL::to('/mypayments');
    return redirect($route);*/
    dd("Transaction not found.");
  }
  
}
}
