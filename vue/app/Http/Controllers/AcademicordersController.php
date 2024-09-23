<?php

namespace App\Http\Controllers;

use App\Additionalservice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

use Validator;
use Redirect;
use Config;
use URL;
use Carbon\Carbon;
use DateTime;
use App\User;
use App\Order;
use App\Orderfile;
use App\Solutionfile;

class AcademicordersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function newOrder(Request $request)
    {     
    
        return view('academic.orders.neworder');
    }

    public function createOrder(Request $request){
	
            //dd("upload complete");
		$validator = Validator::make($request->all(), [
				'title' => 'required|string',
				'subject' => 'required',			
				'style' => 'required',				
				'pages' => 'numeric|max:999',
				'sources' => 'numeric|max:999',			
				'instruction' => 'string',
			]);

		if($validator->fails()){
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
			->withErrors($validator)
			->withInput();
		}else{
			
			$time =$request->deadline;		
			$dtime = DateTime::createFromFormat("m-d-Y G:i", $time);
			$timestamp = $dtime->getTimestamp();
			$timer=Carbon::now();		
			
			$order= new Order;
			$order->order_type=1;
			$order->site_id=1;
			$order->user_id=Auth::user()->id;
			$order->title=$request->title;
			$order->instructions=$request->instructions;
			$order->subject=$request->subject;
			$order->academic=$request->academic;
			$order->paper_type=$request->typeofpaper;
			$order->language=$request->language;
			$order->style=$request->style;
			$order->budget=$request->budget;
			$order->pages=$request->pages;
			$order->duedate= date('Y-m-d H:i:s', $timestamp);
			$order->deadline=$timestamp-strtotime($timer);
			$order->status=1;
			$order->sources=$request->sources;
			$order->save();	
			
			$id=$order->id;

			if($request->copysources!=""){
				$aorder=new Additionalservice;
				$aorder->service="Copy of Sources";
				$aorder->price=$request->copysources;
				$aorder->order_id=$id;
				$aorder->save();
			}

			if($request->top_writer!=""){
				$aorder=new Additionalservice;
				$aorder->service="Top Writer";
				$aorder->price=$request->top_writer;
				$aorder->order_id=$id;
				$aorder->save();
			}
			if($request->plagiarism!=""){
				$aorder=new Additionalservice;
				$aorder->service="Plagiarism Report";
				$aorder->price=$request->plagiarism;
				$aorder->order_id=$id;
				$aorder->save();
			}
			if($request->priority!=""){
				$aorder=new Additionalservice;
				$aorder->service="Make my Order High Priority";
				$aorder->price=$request->priority;
				$aorder->order_id=$id;
				$aorder->save();
			}
			if($request->dedline!=""){
				$aorder=new Additionalservice;
				$aorder->service="Deadline Guaranteed";
				$aorder->price=$request->dedline;
				$aorder->order_id=$id;
				$aorder->save();
			}
			if($request->grammarly!=""){
				$aorder=new Additionalservice;
				$aorder->service="Grammarly Report";
				$aorder->price=$request->grammarly;
				$aorder->order_id=$id;
				$aorder->save();
			}
			
			$files = $request->file('orderfiles');
        if($request->hasFile('orderfiles'))
            {
                foreach ($files as $file) {                   
                    $imageName = time().$file->getClientOriginalName();
                    $file->move(public_path('uploads'),$imageName);
                    $orderfiles=new Orderfile;
		            $orderfiles->filename = $imageName;
                    $orderfiles->question_id=$id;
                    $orderfiles->user_id = Auth::user()->id;
                    $orderfiles->save();
            }
            }	
			$admin=User::where('role',1)->first();
			$mfrom=$admin->id;	
			$mto=Auth::user()->id;
			$message="You have placed an order with ID # ".$id.". Our expert writers are reviewing it. Please open your order, check Bids, and assign to your preferred writer";
			$msubject="Order Placed";
			$datecreated=Carbon::now();
			$user_id=Auth::user()->id;		
			app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			
			
			$mfrom=Auth::user()->id;	
			$mto=$admin->id;
			$message="Client ".ucfirst(Auth::user()->name)." has placed order with ID # ".$id.".";
			$msubject="Order Placed";
			$datecreated=Carbon::now();
			$user_id=Auth::user()->id;		
			app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
		
			flash('Success! Order submitted. Writers are reviewing it. Please check the Bids and assign to a preferred writer.', 'success');
			$route=URL::to('/order',$id);
			return redirect($route);	
		}
	
	}
	
	public function viewOrder($id,Request $request){
		if(Auth::user()->role==3){
			$order=Order::findOrFail($id);
			if($order->user_id==Auth::user()->id){
				true;
			}else{
				flash('You can only open your orders','danger');
				return Redirect::back();
			}
		}elseif(Auth::user()->role==4 && Auth::user()->verified==1 ){
			$order=Order::findOrFail($id);
		}elseif(Auth::user()->role==1 || Auth::user()->role==2 ){
			$order=Order::findOrFail($id);
		}else{
			flash('You have no access to this order.','danger');
			return Redirect::back();
		}    
		if($order->order_type==1){
			return view('academic.orders.order',compact('order'));
		}else{
			return view('articles.orders.order',compact('order'));
		}
		
		
        
	}
	
	public function editOrder($id){
		$order=Order::findOrFail($id);
		return view('academic.orders.edit',compact('order'));
	}
	
	public function updateProject(Request $request){
		$validator = Validator::make($request->all(), [
				'title' => 'required|string',
				'subject' => 'required',			
				'style' => 'required',				
				'pages' => 'numeric|max:999',
				'sources' => 'numeric|max:999',			
				'instruction' => 'string',
			]);

		if($validator->fails()){
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
			->withErrors($validator)
			->withInput();
		}else{
					
			$time =$request->deadline;		
			$dtime = DateTime::createFromFormat("m-d-Y G:i", $time);
			$timestamp = $dtime->getTimestamp();
			$timer=Carbon::now();
			$id=$request->oid;
			$order= Order::findOrfail($id);			
			$order->title=$request->title;
			$order->instructions=$request->instructions;
			$order->subject=$request->subject;
			$order->academic=$request->academic;
			$order->paper_type=$request->typeofpaper;
			$order->language=$request->language;
			$order->style=$request->style;
			$order->sources=$request->sources;
			$order->pages=$request->pages;
			$order->duedate= date('Y-m-d H:i:s', $timestamp);
			$order->deadline=$timestamp-strtotime($timer);
			$order->status=1;
			$order->sources=$request->sources;
			$order->budget=$request->budget;
			$order->save();			
			flash('Success! Order updated.', 'success');
			$route=URL::to('/order',$id);
			return redirect($route);	
		}
	
	}
	
	public function uploadFile(Request $request){
		$id=$request->orderid;
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
						
					$orderfiles=new Orderfile;
					$orderfiles->filename = $upload_filename;
					$orderfiles->question_id = $id;
					$orderfiles->user_id = Auth::user()->id;
					$orderfiles->save();					
					$uploadcount ++;
				}
			}
			$assigned=Order::findOrFail($id);
			if($assigned->tutor_id!=""){
				$mfrom=Auth::user()->id;	
				$mto=$assigned->tutor_id;
				$message="Order Files added by ".ucfirst(Auth::user()->name)." on order # ".$id.".";
				$msubject="Files Added";
				$datecreated=Carbon::now();
				$user_id=Auth::user()->id;		
				app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
				$admin=User::where('role',1)->first();
				$mfrom=Auth::user()->id;	
				$mto=$admin->id;
				$message="Order Files added by ".ucfirst(Auth::user()->name)." on order # ".$id.".";
				$msubject="Files Added";
				$datecreated=Carbon::now();
				$user_id=Auth::user()->id;		
				app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			}else{
				$admin=User::where('role',1)->first();
				$mfrom=Auth::user()->id;	
				$mto=$admin->id;
				$message="Order Files added by ".ucfirst(Auth::user()->name)." on order # ".$id.".";
				$msubject="Files Added";
				$datecreated=Carbon::now();
				$user_id=Auth::user()->id;		
				app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			}
			
		
			flash('File Uploaded!','success');
			return Redirect::back();
		}else{
			flash('File Uploaded failed!','danger');
			return Redirect::back();
		}
			
	}
	public function uploadSolution(Request $request){
		$id=$request->orderid;
		if($request->hasFile('sfiles')){    
			$files = $request->sfiles;
			$file_count = count($files);
			$uploadcount = 0;
			foreach($files as $file){
				$rules = array('file' => 'required|mimes:doc,docx,ppt,pptx,zip,7z,rar,txt,pdf,xls,xlsx,gif,jpg,jpeg,png,bmp,mp3,wav,java,accdb,sav,zsav,dat,pub|max:20000'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
				$validator = Validator::make(array('file'=> $file), $rules);
				if($validator->passes()){
					$destinationPath = public_path('/solutions');						
					$upload_filename=time().' '.$file->getClientOriginalName();
					$upload_success = $file->move($destinationPath, $upload_filename);
						
					$sfiles=new Solutionfile;
					$sfiles->filename = $upload_filename;
					$sfiles->question_id = $id;
					$sfiles->user_id = Auth::user()->id;
					$sfiles->save();					
					$uploadcount ++;
				}
			}
			
			$admin=User::where('role',1)->first();
			$mfrom=Auth::user()->id;	
			$mto=$admin->id;
			$message="Solution uploaded by writer ".ucfirst(Auth::user()->name)." on order # ".$id.".";
			$msubject="Solution Uploaded";
			$datecreated=Carbon::now();
			$user_id=Auth::user()->id;		
			app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
				
			Order::where('id',$id)->update(['status'=>3]);
				
			flash('Solution File uploaded!','success');
			return Redirect::back();
		}else{
			flash('Solution File uploaded failed!','danger');
			return Redirect::back();
		}
	}
	
	public function deleteOrderfile(Request $request){
		$id=$request->ofile;
		$orderfiles=Orderfile::findOrfail($id);
		$orderfiles->is_deleted = 1;
		$orderfiles->save();
		flash('Order File deleted!','success');
		return Redirect::back();
		
	}
	public function deleteSolutionfile(Request $request){
		$id=$request->sfile;
		$orderfiles=Solutionfile::findOrfail($id);
		$orderfiles->is_deleted = 1;
		$orderfiles->save();
		
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
						
					$orderfiles=new Orderfile;
					$orderfiles->filename = $upload_filename;
					$orderfiles->question_id = $id;
					$orderfiles->user_id = Auth::user()->id;
					$orderfiles->save();
					
					$uploadcount ++;
				}
			}
		}
			
		flash('Solution File deleted!','success');
		return Redirect::back();
		
	}
	
	public function downloadSolution($filename){
		$path=public_path('/solutions/').$filename;
		return response()->download($path);
	}
	
	public function orderFile($filename){
		$path=public_path('/uploads/').$filename;
		return response()->download($path);
	}

    
}
