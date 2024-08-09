<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Type;
use App\User;
use Redirect;
use App\Award;
use App\Order;
use App\Style;
use Validator;
use App\Budget;
use App\Credit;
use App\Rating;
use App\Wallet;
use App\Gateway;
use App\Pesapal;
use App\Subject;
use App\Academic;
use App\Articleslevel;
use App\Language;
use App\Opayment;
use App\Pgsetting;
use App\Typesofarticle;
use OAuthRequest;
use Carbon\Carbon;
use OAuthConsumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use OAuthSignatureMethod_HMAC_SHA1;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
	public function pesapal()
	{
		return view('orders.pesapal');
	}
	public function checkoutSuccess()
	{
		return view('orders.checkoutsuccess');
	}

	public function loadWallet()
	{
		return view('orders.load');
	}
	public function paymentSuccess()
	{
		include_once('oauth.php');
		$consumer_key = "EWh0Lq/5V8eAJsR6HNoG8dokUjHfxrm0"; //Register a merchant account on
		//demo.pesapal.com and use the merchant key for testing.
		//When you are ready to go live make sure you change the key to the live account
		//registered on www.pesapal.com!
		$consumer_secret = "5UBdexZRd24fQyR0a3i4qQC+H1o="; // Use the secret from your test
		//account on demo.pesapal.com. When you are ready to go live make sure you 
		//change the secret to the live account registered on www.pesapal.com!
		$statusrequestAPI = //'http://demo.pesapal.com/api/querypaymentstatus';//change to      
			'https://www.pesapal.com/api/querypaymentstatus'; //when you are ready to go live!

		// Parameters sent to you by PesaPal IPN
		//$pesapalNotification=$_GET['pesapal_notification_type'];
		$pesapalTrackingId = $_GET['pesapal_transaction_tracking_id'];
		$pesapal_merchant_reference = $_GET['pesapal_merchant_reference'];
		$signature_method = new OAuthSignatureMethod_HMAC_SHA1();

		if ($pesapalTrackingId != "" && $pesapal_merchant_reference != '') {
			$token = $params = NULL;
			$consumer = new OAuthConsumer($consumer_key, $consumer_secret);

			//get transaction status
			$request_status = OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $statusrequestAPI, $params);
			$request_status->set_parameter("pesapal_merchant_reference", $pesapal_merchant_reference);
			$request_status->set_parameter("pesapal_transaction_tracking_id", $pesapalTrackingId);
			$request_status->sign_request($signature_method, $consumer, $token);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $request_status);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			if (defined('CURL_PROXY_REQUIRED')) if (CURL_PROXY_REQUIRED == 'True') {
				$proxy_tunnel_flag = (defined('CURL_PROXY_TUNNEL_FLAG') && strtoupper(CURL_PROXY_TUNNEL_FLAG) == 'FALSE') ? false : true;
				curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, $proxy_tunnel_flag);
				curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
				curl_setopt($ch, CURLOPT_PROXY, CURL_PROXY_SERVER_DETAILS);
			}

			$response = curl_exec($ch);


			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$raw_header  = substr($response, 0, $header_size - 4);
			$headerArray = explode("\r\n\r\n", $raw_header);
			$header      = $headerArray[count($headerArray) - 1];

			//transaction status
			$elements = preg_split("/=/", substr($response, $header_size));
			$status = $elements[1];

			curl_close($ch);

			//UPDATE YOUR DB TABLE WITH NEW STATUS FOR TRANSACTION WITH pesapal_transaction_tracking_id $pesapalTrackingId



			if ($status == 'FAILED') {
				$resp = "pesapal_transaction_tracking_id=$pesapalTrackingId&pesapal_merchant_reference=$pesapal_merchant_reference";
				$thisbid = $pesapal_merchant_reference;
				$bidder = Bid::where('id', $thisbid)->first();
				if ($bidder->status == 0) {
					$ucpp = User::findOrFail($bidder->user_id);
					$amount = $thisbid->price;
					$bidder->status = 1;
					$bidder->buyer_id = Auth::user()->id;
					$bidder->save();

					$order = Order::findOrFail($bidder->question_id);
					$order->amount = $amount;
					$order->status = 2;
					$order->paid = 1;
					$order->writerpay = $ucpp->cpp * $order->pages;
					$order->tutor_id = $bidder->user_id;
					$order->save();

					$awards = Award::where('user_id', $bidder->user_id)->first();
					$awards->award = $awards->award + 1;
					$awards->save();
					$sawards = Award::where('user_id', Auth::user()->id)->first();
					$sawards->award = $sawards->award + 1;
					$sawards->save();

					//$sbalance=Wallet::where('user_id',Auth::user()->id)->first();
					$tbalance = Wallet::where('user_id', $bidder->user_id)->first();
					//write money Transactions
					$wallet = Wallet::where('user_id', Auth::user()->id)->first();
					$wallet->balance = $wallet->balance - $amount;
					$wallet->save();
					$spay = new Opayment;
					$spay->user_id = Auth::user()->id;
					$spay->amount = $amount;
					$spay->balance = $wallet->balance;
					$spay->order_id = $order->id;
					$spay->type = 1;
					$spay->status = 1;
					$spay->narration = "You have awarded project " . $order->id . " to a scholar.";
					$spay->save();
					$tpay = new Opayment;
					$tpay->user_id = $bidder->user_id;
					$tpay->amount = $ucpp->cpp * $order->pages;
					$tpay->balance = $tbalance->balance;
					$tpay->order_id = $order->id;
					$tpay->type = 1;
					$tpay->status = 1;
					$tpay->narration = "You have won bid on project " . $order->id;
					$tpay->save();
					$paypals = Pesapal::findOrFail(1);
					$paypals->total = $paypals->total + $amount;
					$paypals->save();

					$mfrom = Auth::user()->id;
					$mto = $bidder->user_id;
					$message = "You have been assigned order #" . $order->id . ". Ensure you deliver timely quality work.";
					$msubject = "Order Assigned!";
					$datecreated = Carbon::now();
					$user_id = Auth::user()->id;
					app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom, $mto, $msubject, $message, "", $datecreated, $user_id]);
					flash('Transaction successful, you have awarded the order to a scholar.', 'success');
					$route = URL::to('/order', $order->id);
					return redirect($route);
				} else {
					flash('You have already purchased this bid', 'danger');
					return Redirect::back();
				}
			}
		}
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if (Auth::user()->updated == 0) {
			$this->createProfile();
			User::where('id', Auth::user()->id)->update(['updated' => 1]);
		}

		return view('home');
	}

	private function createProfile()
	{
		$user = Auth::user()->id;
		$uwallet = Wallet::where('user_id', $user)->first();
		$uawards = Award::where('user_id', $user)->first();
		$uratings = Rating::where('user_id', $user)->first();

		if ($uwallet == "") {
			$wallet = new Wallet;
			$wallet->user_id = $user;
			$wallet->balance = 0;
			$wallet->save();
		}
		if ($uawards == "") {
			$awards = new Award;
			$awards->user_id = $user;
			$awards->award = 0;
			$awards->save();
		}
		if ($uratings == "") {
			$ratings = new Rating;
			$ratings->user_id = $user;
			$ratings->score = 0;
			$ratings->reviews = 0;
			$ratings->save();
		}
	}

	public function settingsPage()
	{
		if (Auth::user()->role == 1) {
			return view('settings.index');
		} else {
			flash('Not allowed!', 'danger');
			return Redirect::back();
		}
	}

	public function adjustBudget(Request $request)
	{
		$validator = Validator::make($request->all(), [

			'amount' => 'required',

		]);

		if ($validator->fails()) {
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {
			$bid = $request->budget;
			$pages = $request->pages;
			$amount = $request->amount;
			$adjust = Budget::findOrFail($bid);

			$adjust->amount = $amount;
			$adjust->save();
			flash('Budget updated successfully.', 'success');
			return Redirect::back();
		}
	}

	public function createBudget(Request $request)
	{
		$validator = Validator::make($request->all(), [

			'amount' => 'required',

		]);

		if ($validator->fails()) {
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {

			$amount = $request->amount;
			$adjust = new Budget;

			$adjust->amount = $amount;
			$adjust->save();
			flash('Budget created successfully.', 'success');
			return Redirect::back();
		}
	}

	public function deleteBudget(Request $request)
	{

		$bid = $request->budget;
		if (Auth::user()->role == 1) {
			$delete = Budget::findOrFail($bid);
			$delete->delete();
			flash('Budget deleted successfully.', 'success');
			return Redirect::back();
		} else {
			flash('Not allowed.', 'danger');
			return Redirect::back();
		}
	}

	public function updateSubject(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'subject' => 'required|string',
		]);

		if ($validator->fails()) {
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {
			$id = $request->subjectid;
			$subject = $request->subject;
			$adjust = Subject::findOrFail($id);
			$adjust->subject = $subject;
			$adjust->save();
			flash('Subject updated successfully.', 'success');
			return Redirect::back();
		}
	}

	public function createSubject(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'subject' => 'required|string',
		]);

		if ($validator->fails()) {
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {

			$subject = $request->subject;
			$create = new Subject;
			$create->subject = $subject;
			$create->save();
			flash('Subject created successfully.', 'success');
			return Redirect::back();
		}
	}
	public function deleteSubject(Request $request)
	{
		$sid = $request->subjectid;
		if (Auth::user()->role == 1) {
			$delete = Subject::findOrFail($sid);
			$delete->delete();
			flash('Subject deleted successfully.', 'success');
			return Redirect::back();
		} else {
			flash('Not allowed.', 'danger');
			return Redirect::back();
		}
	}

	public function updateType(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'type' => 'required|string',
		]);

		if ($validator->fails()) {
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {
			$id = $request->typeid;
			$type = $request->type;
			$adjust = Type::findOrFail($id);
			$adjust->type = $type;
			$adjust->save();
			flash('Type updated successfully.', 'success');
			return Redirect::back();
		}
	}

	public function createTypeArticle(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'article' => 'required|string',
		]);

		if ($validator->fails()) {
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {

			$type = $request->article;
			$create = new Typesofarticle;
			$create->title = $type;
			$create->save();
			flash('Article Type created successfully.', 'success');
			return Redirect::back();
		}
	}
	public function articlesLevels(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'rating' => 'required|string',
		]);

		if ($validator->fails()) {
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {

			$type = $request->rating;
			$create = new Articleslevel;
			$create->rating = $type;
			$create->save();
			flash('Article Type created successfully.', 'success');
			return Redirect::back();
		}
	}

	public function createType(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'type' => 'required|string',
		]);

		if ($validator->fails()) {
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {

			$type = $request->type;
			$create = new Type;
			$create->type = $type;
			$create->save();
			flash('Type created successfully.', 'success');
			return Redirect::back();
		}
	}
	public function deleteType(Request $request)
	{
		$tid = $request->typeid;
		if (Auth::user()->role == 1) {
			$delete = Type::findOrFail($tid);
			$delete->delete();
			flash('Type deleted successfully.', 'success');
			return Redirect::back();
		} else {
			flash('Not allowed.', 'danger');
			return Redirect::back();
		}
	}

	public function updateLevel(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'academic' => 'required|string',
		]);

		if ($validator->fails()) {
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {
			$id = $request->levelid;
			$academic = $request->academic;
			$adjust = Academic::findOrFail($id);
			$adjust->level = $academic;
			$adjust->save();
			flash('Academic level updated successfully.', 'success');
			return Redirect::back();
		}
	}
	public function createLevel(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'academic' => 'required|string',
		]);

		if ($validator->fails()) {
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {

			$level = $request->academic;
			$create = new Academic;
			$create->level = $level;
			$create->save();
			flash('Academic level created successfully.', 'success');
			return Redirect::back();
		}
	}
	public function deleteLevel(Request $request)
	{
		$tid = $request->academicid;
		if (Auth::user()->role == 1) {
			$delete = Academic::findOrFail($tid);
			$delete->delete();
			flash('Academic Level deleted successfully.', 'success');
			return Redirect::back();
		} else {
			flash('Not allowed.', 'danger');
			return Redirect::back();
		}
	}
	public function updateLanguage(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'language' => 'required|string',
		]);

		if ($validator->fails()) {
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {
			$id = $request->languageid;
			$language = $request->language;
			$adjust = Language::findOrFail($id);
			$adjust->language = $language;
			$adjust->save();
			flash('Language updated successfully.', 'success');
			return Redirect::back();
		}
	}
	public function createLanguage(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'language' => 'required|string',
		]);

		if ($validator->fails()) {
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {

			$language = $request->language;
			$create = new Language;
			$create->language = $language;
			$create->save();
			flash('Language created successfully.', 'success');
			return Redirect::back();
		}
	}
	public function deleteLanguage(Request $request)
	{
		$tid = $request->languageid;
		if (Auth::user()->role == 1) {
			$delete = Language::findOrFail($tid);
			$delete->delete();
			flash('Language deleted successfully.', 'success');
			return Redirect::back();
		} else {
			flash('Not allowed.', 'danger');
			return Redirect::back();
		}
	}
	public function updateStyle(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'style' => 'required|string',
		]);

		if ($validator->fails()) {
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {
			$id = $request->styleid;
			$style = $request->style;
			$adjust = Style::findOrFail($id);
			$adjust->style = $style;
			$adjust->save();
			flash('Style updated successfully.', 'success');
			return Redirect::back();
		}
	}
	public function createStyle(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'style' => 'required|string',
		]);

		if ($validator->fails()) {
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		} else {

			$style = $request->style;
			$create = new Style;
			$create->style = $style;
			$create->save();
			flash('Style created successfully.', 'success');
			return Redirect::back();
		}
	}
	public function deleteStyle(Request $request)
	{
		$sid = $request->styleid;
		if (Auth::user()->role == 1) {
			$delete = Style::findOrFail($sid);
			$delete->delete();
			flash('Style deleted successfully.', 'success');
			return Redirect::back();
		} else {
			flash('Not allowed.', 'danger');
			return Redirect::back();
		}
	}
	public function setPG(Request $request)
	{

		$pg = $request->pg;
		$isset = Pgsetting::where('pg_id', $pg)->first();
		if (!empty($isset)) {
			flash('You have a gateway set under this category. Please update the existing one.', 'danger');
			return Redirect::back();
		}
		if ($pg == 1) {
			$pgname = "PayPal";
		} elseif ($pg == 2) {
			$pgname = "Pesapal";
		} elseif ($pg == 3) {
			$pgname = "FlutterWave";
		} else {
		}
		$clientid = $request->clientid;
		$clientsecret = $request->clientsecret;
		$setpg = new Pgsetting;
		$setpg->pgname = $pgname;
		$setpg->pg_id = $pg;
		$setpg->pgclient = $clientid;
		$setpg->pgsecret = $clientsecret;
		$setpg->created_by = auth::user()->id;
		$setpg->save();
		flash('Payment Gateway added.', 'success');
		return Redirect::back();
	}
	public function updatePg(Request $request)
	{

		$pg = $request->pg;
		if ($pg == 1) {
			$pgname = "PayPal";
		} elseif ($pg == 2) {
			$pgname = "Pesapal";
		} elseif ($pg == 3) {
			$pgname = "FlutterWave";
		} else {
		}
		$clientid = $request->clientid;
		$clientsecret = $request->clientsecret;
		$setpg = Pgsetting::findOrFail($request->pgid);
		$setpg->pgname = $pgname;
		$setpg->pg_id = $pg;
		$setpg->pgclient = $clientid;
		$setpg->pgsecret = $clientsecret;
		$setpg->created_by = auth::user()->id;
		$setpg->save();
		flash('Payment Gateway updated.', 'success');
		$route = URL::to('/settings');
		return redirect($route);
	}
	public function editGateway($id)
	{
		$setpg = Pgsetting::findOrFail($id);
		return view('editgateway', compact('setpg'));
	}
	public function deletePg($id)
	{
		$setpg = Pgsetting::findOrFail($id);
		$setpg->delete();
		flash('Payment Gateway Deleted.', 'success');
		$route = URL::to('/settings');
		return redirect($route);
	}
	public function activatePg($id)
	{
		$setpg = Pgsetting::findOrFail($id);
		if ($setpg->active == 1) {
			$setpg->active = 0;
			$setpg->save();
			flash('Payment Gateway Deactivated.', 'success');
			$route = URL::to('/settings');
			return redirect($route);
		} else {
			$setpg->active = 1;
			$setpg->save();
			flash('Payment Gateway Activated.', 'success');
			$route = URL::to('/settings');
			return redirect($route);
		}
	}
}
