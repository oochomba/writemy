<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use Config;
use URL;
use Carbon\Carbon;
use DateTime;
use App\Bid;
use App\Order;
use App\Orderfile;
use Illuminate\Support\Str;

class BidsController extends Controller
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
	public function createBid(Request $request)
	{
		$random = Str::random(16);
		$user = $request->user_id;
		$question_id = $request->question_id;
		$amount = $request->amount;
		$text = $request->offer;
		$hasBid = Bid::where('user_id', $user)->where('question_id', $question_id)->first();
		// dd($hasBid);
		if ($hasBid != "") {
			flash('You have an active bid!', 'danger');
			return Redirect::back();
		} else {
			$validator = Validator::make($request->all(), [
				'amount' => 'required|numeric',
				'offer' => 'required|max:300|min:5',
			]);
			if ($validator->fails()) {
				flash('Please check all the fields for errors.', 'danger');
				return Redirect::back()
					->withErrors($validator)
					->withInput();
			} else {
				$bid = new Bid;
				$bid->user_id = Auth::user()->id;
				$bid->question_id = $question_id;
				$bid->price = $amount;
				$bid->invoicehash = $random;
				$bid->text = $text;
				$bid->save();
				$bidincrement = Order::findOrfail($question_id);
				$bidincrement->bids = $bidincrement->bids + 1;
				$bidincrement->save();

				$mfrom = Auth::user()->id;
				$mto = $bidincrement->user_id;
				$message = "Writer " . ucfirst(Auth::user()->name) . " has placed a bid on order ID # " . $question_id . ".";
				$msubject = "Bid Placed";
				$datecreated = Carbon::now();
				$user_id = Auth::user()->id;
				//app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
				flash('Bid Placed Successfully', 'success');
				return Redirect::back();
			}
		}
	}

	public function editBid(Request $request)
	{
		$bid = $request->bid;
		$price = $request->price;
		$text = $request->text;
		$bid = Bid::findOrFail($bid);
		$bid->price = $price;
		$bid->text = $text;
		$bid->save();
		flash('Bid updated Successfully', 'success');
		return Redirect::back();
	}

	public function deleteBid(Request $request)
	{
		$bid = $request->bidid;
		$bids = Bid::findOrFail($bid);
		$question_id = $bids->question_id;
		if ($bids->status == 0) {
			$bids->delete();
			$bidincrement = Order::findOrfail($question_id);
			$bidincrement->bids = $bidincrement->bids - 1;
			$bidincrement->save();
			flash('Bid deleted Successfully', 'success');
			return Redirect::back();
		} else {
			flash('This bid has been bought and cannot be deleted!', 'danger');
			return Redirect::back();
		}
	}
	public function checkoutInvoice($id)
	{
		$bids = Bid::where('invoicehash', $id)->first();
		return view('orders.orderinvoice', compact('bids'));
	}
}
