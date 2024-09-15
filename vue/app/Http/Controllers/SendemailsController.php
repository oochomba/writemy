<?php

namespace App\Http\Controllers;

use App\User;
use Redirect;
use Validator;
use App\Invoice;
use App\Message;
use App\Qmailer;
use App\Messagefile;
use App\Order;
use App\Queuedmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SendemailsController extends Controller
{

	public function prepareEmail($mfrom, $mto, $msubject, $mymessage, $order_id, $datecreated, $user_id)
	{
		$qmail = new Qmailer;
		$qmail->mfrom = $mfrom;
		$qmail->mto = $mto;
		$qmail->msubject = $msubject;
		$qmail->mymessage = $mymessage;
		$qmail->datecreated = $datecreated;
		$qmail->user_id = $user_id;
		$qmail->save();
		$this->sendEmails();
	}
	public function prepareQueue($mfrom, $mto, $msubject, $mymessage, $datecreated)
	{
		$qmail = new Qmailer;
		$qmail->mfrom = $mfrom;
		$qmail->mto = $mto;
		$qmail->msubject = $msubject;
		$qmail->mymessage = $mymessage;
		$qmail->datecreated = $datecreated;
		$qmail->save();
		$this->sendQueue();
	}
	public function sendEmails()
	{
		$unsent = Qmailer::where('status', 0)->get();
		foreach ($unsent as $tomail) {
			$mto = User::where('id', $tomail->mto)->first();
			$mfrom = User::where('id', $tomail->mfrom)->first();

			if (!empty($mto->email) && !empty($mfrom->email)) {
				$sender = $mfrom->name;
				$details = $tomail->mymessage;
				$name = $mto->name;
				$email = $mto->email;
				if ($mto->role == 1 || $mto->role == 3) {
					$mymail = app()->make(\Snowfire\Beautymail\Beautymail::class);

					try {
						$mymail->send('emails.mailtemp',  ['details' => $details, 'emailsender' => $sender, 'rece' => $name], function ($message) use ($email, $name, $tomail) {
							$message
								->from('support@writemypaperforme.org', 'WriteMyPaperforMe')
								->to($email, $name)
								->subject($tomail->msubject);
						});
					} catch (\Exception $e) {
						// dd($e);
					}
				} else {
					$mymail = app()->make(\Snowfire\Beautymail\Beautymail::class);

					try {
						$mymail->send('emails.writer',  ['details' => $details, 'emailsender' => $sender, 'rece' => $name], function ($message) use ($email, $name, $tomail) {
							$message
								->from('support@writemypaperforme.org', 'WriteMyPaperforMe')
								->to($email, $name)
								->subject($tomail->msubject);
						});
					} catch (\Exception $e) {
						// dd($e);
					}
				}
				Qmailer::where('id', $tomail->id)->update(['status' => 1]);
			}
		}
	}
	public function sendQueue()
	{
		$unsent = Queuedmail::where('status', 0)->get();
		foreach ($unsent as $tomail) {
			$mto = User::where('id', $tomail->mto)->first();
			$details = $tomail->mymessage;
			$name = $mto->name;
			$email = $mto->email;
			$mymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
			$mymail->send('emails.mailtemp',  ['details' => $details, 'rece' => $name], function ($message) use ($email, $name, $tomail) {
				$message
					->from('support@writemypaperforme.org', 'WriteMyPaperforMe')
					->to($email, $name)
					->subject($tomail->msubject);
			});
			Queuedmail::where('id', $tomail->id)->update(['status' => 1]);
		}
	}
	public function getInvoicehceckout($id)
	{
		$vid = Invoice::findOrFail($id);
		$order = Order::findOrFail($vid->order_id);
		$user = User::findOrFail($order->user_id);
		$email = $user->email;
		$title = $order->title;
		$amount = $vid->amount;
		return view('invoices.checkout', compact('title', 'amount', 'id', 'email'));
	}
	public function paymentSuccess()
	{
		return view('invoices.paymentsuccess');
	}
}
