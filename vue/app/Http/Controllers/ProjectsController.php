<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Order;
use App\Award;
use App\Revision;
use App\Revision_file;
use App\Opayment;
use App\Bid;
use App\User;
use App\Wallet;
use Carbon\Carbon;
use Redirect;
use DateTime;
use Validator;
class ProjectsController extends Controller{	
	public function __construct(){
		$this->middleware('auth');
	}
	
	public function currentOrders(){
		$orders=Order::where('user_id',Auth::user()->id)->where('status','!=',5)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);    	
		return view('orders.currentorders',compact('orders'));
	}
    
	public function completedOrders(){
		if(Auth::user()->role==3){
			$orders=Order::where('user_id',Auth::user()->id)->where('status',5)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}elseif(Auth::user()->role==4){
			$orders=Order::where('status',5)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}else{
			$orders=Order::where('status',5)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}
		return view('orders.completedorders',compact('orders'));
	}
	public function assignedOrders(){
		if(Auth::user()->role==3){
			$orders=Order::where('user_id',Auth::user()->id)->where('status',2)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}elseif(Auth::user()->role==4){
			$orders=Order::where('status',2)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}else{
			$orders=Order::where('status',2)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}
		return view('orders.assigned',compact('orders'));
	}

	public function ordersInEditing(){
		if(Auth::user()->role==3){
			$orders=Order::where('user_id',Auth::user()->id)->where('status',3)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}elseif(Auth::user()->role==4){
			$orders=Order::where('tutor_id',Auth::user()->id)->where('status',3)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}else{
			$orders=Order::where('status',3)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}
		return view('orders.editing',compact('orders'));
	}
	
	
	public function myorders(){
		if(Auth::user()->role==3){
			$orders=Order::where('user_id',Auth::user()->id)->where('status',2)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}elseif(Auth::user()->role==4){
			$orders=Order::where('tutor_id',Auth::user()->id)->where('status',2)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}else{
			$orders=Order::where('status',2)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}
		return view('orders.completedorders',compact('orders'));
	}
	
	public function availableOrders(){
		if(Auth::user()->role==3){
			$orders=Order::where('user_id',Auth::user()->id)->where('status',1)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}elseif(Auth::user()->role==4){
			$orders=Order::where('status',1)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}else{
			$orders=Order::where('status',1)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);;
		}
		
		return view('orders.available',compact('orders'));
	}
	
	public function myBids(){
		$orders=Bid::where('user_id',Auth::user()->id)->get();
		
		return view('orders.mybids',compact('orders'));
	}
	
	public function myRevisions(){
		if(Auth::user()->role==3){
			$orders=Order::where('user_id',Auth::user()->id)->where('status',4)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}elseif(Auth::user()->role==4){
			$orders=Order::where('tutor_id',Auth::user()->id)->where('status',4)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}else{
			$orders=Order::where('status',4)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}
		return view('orders.revision',compact('orders'));
	}
	
	public function myunpaidOrders(){
		if(Auth::user()->role==3){
			$orders=Order::where('user_id',Auth::user()->id)->where('paid',0)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}elseif(Auth::user()->role==4){
			$orders=Order::where('tutor_id',Auth::user()->id)->where('paid',0)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}else{
			$orders=Order::where('paid',0)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(20);
		}
		return view('orders.unpaid',compact('orders'));
	}
	public function markPaid(Request $request){	
		$order=$request->orderID;	
		$amount=$request->amount;
		$paid=Order::findOrfail($order);
		$paid->amount=$amount;
		$paid->paid=1;
		$paid->save();	
		$admin=User::where('role',1)->first();
		$mfrom=Auth::user()->id;	
		$mto=$admin->id;
		$message="Order #".$order." has been marked as paid.";
		$msubject="Marked as Paid";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
		app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		flash('Order marked as paid.','success');
		return Redirect::back();
	}
	
	public function adjustPay(Request $request){
		$order=$request->orderID;	
		$amount=$request->amount;
		$paid=Order::findOrfail($order);
		$paid->writerpay=$amount;
		$paid->save();	
		$admin=User::where('role',1)->first();
		$mfrom=Auth::user()->id;	
		$mto=$admin->id;
		$message="Writer pay for the order #".$order." has been changed to $ ".$amount.".";
		$msubject="Writer Pay Adjusted";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
		app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		flash('Pay adjusted.','success');
		return Redirect::back();
	}
	public function assignOrder(Request $request){
		$tutor=$request->tutor;
		$order=$request->orderID;
		$assign=Order::findOrfail($order);
		$assign->tutor_id=$tutor;	
		$assign->writerpay=3*$assign->pages;	
		$assign->save();	
		$awards=Award::where('user_id',$tutor)->first();
		$awards->award=$awards->award+1;
		$awards->save();
		$mfrom=Auth::user()->id;	
		$mto=$tutor;
		$message="You have been assigned order #".$order.". Ensure you deliver timely quality work.";
		$msubject="Order Assigned!";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
		app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		flash('Order assigned.','success');
		return Redirect::back();
	}
	
	public function changeStatus(Request $request){
		$status=$request->status;
		$order=$request->orderID;
		$statuschange=Order::findOrfail($order);
		
		$statuschange->status=$status;	
		$statuschange->save();
		if($status==4){
			if($statuschange->tutor_id!=""){
				$mfrom=Auth::user()->id;	
				$mto=$statuschange->tutor_id;
				$message="Your order # ".$order." has been returned for revision.Login to address the issue.";
				$msubject="Revision Requested";
				$datecreated=Carbon::now();
				$user_id=Auth::user()->id;		
				app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			}
		
		}elseif($status==5){
			$mfrom=Auth::user()->id;	
			$mto=$statuschange->user_id;
			$message="Your order # ".$order." has been completed. Please login to download the solution.";
			$msubject="Order Completed";
			$datecreated=Carbon::now();
			$user_id=Auth::user()->id;		
			app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		}elseif($status==1&&$statuschange->tutor_id!=""){
			$mfrom=Auth::user()->id;	
			$mto=$statuschange->tutor_id;
			$message="Your ealier assigned order # ".$order." has been returned for bidding.";
			$msubject="Order Returned to Bidding";
			$datecreated=Carbon::now();
			$user_id=Auth::user()->id;		
			app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);	
			$rtutor=Order::findOrfail($order);		
			$rtutor->tutor_id=NULL;	
			$rtutor->save();
		}else{
			
		}
		
		flash('Order status updated.','success');
		return Redirect::back();		
	}
	
	public function releaseFunds(Request $request){
		$order=$request->orderID;
		$statuschange=Order::findOrfail($order);
		if($statuschange->writer_paid==0){
			$statuschange->writer_paid=1;	
			$statuschange->save();
			$pay=$statuschange->writerpay;
			$tbalance=Wallet::where('user_id',$statuschange->tutor_id)->first();
			$tbalance=$tbalance->balance+$pay;
			$tpay=new Opayment;
			$tpay->user_id=$statuschange->tutor_id;
			$tpay->amount=$pay;
			$tpay->balance=$tbalance;
			$tpay->order_id=$order;
			$tpay->type=6;
			$tpay->status=1;
			$tpay->narration="Payment released for order ".$order;
			$tpay->save();
			$wallet=Wallet::where('user_id',$statuschange->tutor_id)->first();
			$wallet->balance=$wallet->balance+$pay;
			$wallet->save();
			
			$mfrom=Auth::user()->id;	
			$mto=$statuschange->tutor_id;
			$message="Payment for the order #".$order." released. Your wallet has been credited with $ ".$pay.".";
			$msubject="Order Paid";
			$datecreated=Carbon::now();
			$user_id=Auth::user()->id;		
			app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			flash('Payment released.','success');
			return Redirect::back();
		}else{
			flash('Writer has already been paid for this order.','danger');
			return Redirect::back();
		}
	}
	
	public function deleteOrder(Request $request){		
		$order=$request->orderID;
		$delete=Order::findOrfail($order);
		$delete->is_deleted=1;	
		$delete->status=7;	
		$delete->save();
		flash('Order deleted!','success');
		return Redirect::back();
	}
	
	public function requestRevision(Request $request){
		$id=$request->id;
		$instructions=$request->instruction;
		$deadline=$request->deadline;	
		$dtime = DateTime::createFromFormat("m-d-Y G:i", $deadline);
		$timestamp = $dtime->getTimestamp();
		
		$lastorder=Revision::latest()->first();
		if(count($lastorder)>0){
			$rid=$lastorder->id+1;
		}else{
			$rid=5000;
		}
		$revision=new Revision;
		$revision->deadline= date('Y-m-d H:i:s', $timestamp);
		$revision->question_id=$id;
		$revision->id=$rid;
		$revision->instructions=$instructions;
		$revision->user_id=Auth::user()->id;
		$revision->save();
		
		$order=Order::findOrFail($id);
		$order->status=4;
		$order->save();
		
		if($request->hasFile('orderfiles')){    
			$files = $request->orderfiles;
			$file_count = count($files);
			$uploadcount = 0;
			foreach($files as $file){
				$rules = array('file' => 'required|mimes:doc,docx,ppt,pptx,zip,7z,rar,txt,pdf,xls,xlsx,gif,jpg,jpeg,png,bmp,mp3,wav,java,accdb,sav,zsav,dat,pub|max:20000'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
				$validator = Validator::make(array('file'=> $file), $rules);
				if($validator->passes()){
					$destinationPath = public_path('/uploads');						
					$upload_filename=time().' '.$file->getClientOriginalName();
					$upload_success = $file->move($destinationPath, $upload_filename);
						
					$orderfiles=new Revision_file;
					$orderfiles->filename = $upload_filename;
					$orderfiles->question_id = $id;
					$orderfiles->revision_id = $rid;
					$orderfiles->user_id = Auth::user()->id;
					$orderfiles->save();
					
					$uploadcount ++;
				}
			}
		}
				$assigned=Order::findOrFail($id);
				$mfrom=Auth::user()->id;	
				$mto=$assigned->tutor_id;
				$message="Your order # ".$id." has been returned for revision.";
				$msubject="Revision Requested";
				$datecreated=Carbon::now();
				$user_id=Auth::user()->id;		
				app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
				$admin=User::where('role',1)->first();
				$mfrom=Auth::user()->id;	
				$mto=$admin->id;
				$message="Order # ".$id." has been returned for revision.";
				$msubject="Revision Requested";
				$datecreated=Carbon::now();
				$user_id=Auth::user()->id;		
				app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			
		flash('Revision created!','success');
		return Redirect::back();
			
	}
	
	public function revisionFiles($filename){
		$path=public_path('/uploads/').$filename;
		return response()->download($path);
	}
	
	public function deleteRevisionfile(Request $request){
		$sifle=$request->sfile;
		$file=Revision_file::findOrFail($sifle);
			$file->delete();
		flash('Revision file deleted!','success');
		return Redirect::back();
	}
	
}
