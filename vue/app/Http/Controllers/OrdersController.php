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
use App\Order;
use App\Award;
use App\Rating;
use App\Wallet;
use App\Qmailer;
use App\Orderfile;
use App\User;
use App\Solutionfile;
use File;
use ZipArchive;
class OrdersController extends Controller{
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	

	/**
	* Show the application dashboard.
	*
	* @return \Illuminate\Http\Response
	*/
	public function newOrder(){
    	
		return view('orders.neworder');
	}
	
	public function orderFiles(Request $request){
		$image = $request->file('file');
		$imageName = time().$image->getClientOriginalName();
		$image->move(public_path('uploads'),$imageName);
        
		$orderfiles=new Orderfile;
		$orderfiles->filename = $imageName;
		$orderfiles->tempid = $request->tempid;
		$orderfiles->user_id = Auth::user()->id;
		$orderfiles->save();	
	}
	
	public function createOrder(Request $request){
		//dd($request->all());
		$dt=Carbon::now();
		$my_date_time=	$dt->addHours($request->deadline); 		
		$diff = strtotime($my_date_time)-time();   		
		$validator = Validator::make($request->all(), [
				'topic' => 'required|string',
				'subject' => 'required',			
				'format' => 'required',				
				'pages' => 'numeric|max:999',
				'sources' => 'numeric|max:999',			
				'instructions' => 'string',
			]);

		if($validator->fails()){
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
			->withErrors($validator)
			->withInput();
		}else{
			// get user by email

			$userexists=User::where('email',$request->email)->first();	

			if($userexists!=""){
				$userid=$userexists->id;
				
			}else{
				//sign up the user
				$email=$request->email;
                $lastuser=User::latest()->first();
                if(count($lastuser)>0){
                    $rand=rand(11111,111111);
                    $userid=$lastuser->id+12000+$rand;
                }else{
                    $rand=rand(11111,111111);
                    $userid=12000+$rand;
                }
                $role=3;
                $pass=str_random(8);               
                $name=$request->name;
                $user=new User;
                $user->id=$userid;
                $user->name=$name;
                $user->email=$email;
                $user->password=bcrypt($request->password);
                $user->role=$role;
                $user->save();
            
                $wallet=new Wallet;
                $wallet->user_id=$userid;
                $wallet->balance=0;
                $wallet->save();
                
                $awards=new Award;
                $awards->user_id=$userid;
                $awards->award=0;
                $awards->save();
                
                $ratings=new Rating;
                $ratings->user_id=$userid;
                $ratings->score=0;
                $ratings->reviews=0;
                $ratings->save();           
                

                $admin=User::where('role',1)->first();
                $mfrom=$admin->id;	
                $mto=$userid;
                $message="Thank you for choosing WriteMyPaperforMe.org as your custom paper provider. You have completed registration on WriteMyPaperforMe. You account has been created. Your email is ".$email." and your password is ".$pass.". Change password on login. ";
                $msubject="CONGRATULATIONS! Welcome To WriteMyPaperforMe.org";
                $datecreated=Carbon::now();
                $user_id=$userid;            
                app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			}
			
			$time =$request->deadline;		
			$dtime = DateTime::createFromFormat("m-d-Y G:i", $time);
			//$timestamp = $dtime->getTimestamp();
			//$timer=Carbon::now();
			
			$lastorder=Order::latest()->first();
			if(@count($lastorder)>0){
				$id=$lastorder->id+1;
			}else{
				$id=15000;
			}

			$files = $request->file('files');
        if($request->hasFile('files'))
            {
                foreach ($files as $file) {                   
                    $imageName = time().$file->getClientOriginalName();
                    $file->move(public_path('uploads'),$imageName);
                    $orderfiles=new Orderfile;
		            $orderfiles->filename = $imageName;
                    $orderfiles->question_id=$id;
                    $orderfiles->user_id = $userid;
                    $orderfiles->save();
            }
            }
			
			$order= new Order;
			$order->id=$id;
			$order->user_id=$userid;
			$order->title=$request->topic;
			$order->instructions=$request->instructions;
			$order->subject=$request->subject;
			$order->academic=$request->academic_level;
			$order->paper_type=$request->paper_type;
			$order->typeofservice=$request->service_type;
			$order->language=$request->language;
			$order->style=$request->format;
			$order->budget=$request->orderprice;
			$order->sources=$request->sources;
			$order->pages=$request->pages;
			$order->slides=$request->slides;
			$order->duedate=$my_date_time;
			$order->deadline=$diff;
			$order->status=1;		
			
			$order->writer_category=$request->writer_category;
			$order->top_writer=$request->top_writer;
			$order->plagiarism=$request->plagiarism;
			$order->priority=$request->priority;
			$order->grammarly=$request->grammarly;
			$order->save();	
			
			//$orderf=Orderfile::where('tempid',$request->tempid)->get();
			
		
				
			$admin=User::where('role',1)->first();
			$mfrom=$admin->id;	
			$mto=$userid;
			$message="You have placed an order with ID ".$id.". Our writers are reviewing it. Please check bids and assign to preferred writer.";
			$msubject="Order Placed";
			$datecreated=Carbon::now();
			$user_id=$userid;		
			app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			
			
			$mfrom=$userid;	
			$mto=$admin->id;
			$message="Client ".ucfirst(Auth::user()->name)." has placed order with id # ".$id.".";
			$msubject="Order Placed";
			$datecreated=Carbon::now();
			$user_id=$userid;		
			app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			$userE = User::where('id',$userid)->first();
			if(empty($userE)){
			abort(404);
			}
			
			if(Auth::loginUsingId($userE->id)){
				flash('Success! Order submitted. Please check bids and select a writer to start working on it. ', 'success');
				$route=URL::to('/order',$id);
			return redirect($route);	
			}
			
		}
	
	}

	public function createProject(Request $request){
		//dd($request->all());
		$dt=Carbon::now();
		$my_date_time=	$dt->addHours($request->deadline); 		
		$diff = strtotime($my_date_time)-time();   		
		$validator = Validator::make($request->all(), [
				'topic' => 'required|string',
				'subject' => 'required',			
				'format' => 'required',				
				'pages' => 'numeric|max:999',
				'sources' => 'numeric|max:999',			
				'instructions' => 'string',
			]);

		if($validator->fails()){
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
			->withErrors($validator)
			->withInput();
		}else{
			// get user by email

			$time =$request->deadline;		
			$dtime = DateTime::createFromFormat("m-d-Y G:i", $time);
			//$timestamp = $dtime->getTimestamp();
			//$timer=Carbon::now();
			$userid=Auth::user()->id;
			$lastorder=Order::latest()->first();
			if(@count($lastorder)>0){
				$id=$lastorder->id+1;
			}else{
				$id=15000;
			}

			$files = $request->file('files');
        if($request->hasFile('files'))
            {
                foreach ($files as $file) {                   
                    $imageName = time().$file->getClientOriginalName();
                    $file->move(public_path('uploads'),$imageName);
                    $orderfiles=new Orderfile;
		            $orderfiles->filename = $imageName;
                    $orderfiles->question_id=$id;
                    $orderfiles->user_id = $userid;
                    $orderfiles->save();
            }
            }
			
			$order= new Order;
			$order->id=$id;
			$order->user_id=$userid;
			$order->title=$request->topic;
			$order->instructions=$request->instructions;
			$order->subject=$request->subject;
			$order->academic=$request->academic_level;
			$order->paper_type=$request->paper_type;
			$order->typeofservice=$request->service_type;
			$order->language=$request->language;
			$order->style=$request->format;
			$order->budget=$request->orderprice;
			$order->sources=$request->sources;
			$order->pages=$request->pages;
			$order->slides=$request->slides;
			$order->duedate=$my_date_time;
			$order->deadline=$diff;
			$order->status=1;
			$order->sources=$request->sources;
			$order->writer_category=$request->writer_category;
			$order->top_writer=$request->top_writer;
			$order->plagiarism=$request->plagiarism;
			$order->priority=$request->priority;
			$order->grammarly=$request->grammarly;
		
			$order->save();	
			
			//$orderf=Orderfile::where('tempid',$request->tempid)->get();
			
		
				
			$admin=User::where('role',1)->first();
			$mfrom=$admin->id;	
			$mto=$userid;
			$message="You have placed an order with ID".$id.". Our expert writers are reviewing it. Please check bids and assign to your preferred writer.";
			$msubject="Order Placed";
			$datecreated=Carbon::now();
			$user_id=$userid;		
			app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			
			
			$mfrom=$userid;	
			$mto=$admin->id;
			$message="Client ".ucfirst(Auth::user()->name)." has placed order with id # ".$id.".";
			$msubject="Order Placed";
			$datecreated=Carbon::now();
			$user_id=$userid;		
			app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			flash('Success! Order submitted. Please check bids and select a writer to start working on it. ', 'success');
			$route=URL::to('/order',$id);
		return redirect($route);	
			
		}
	
	}



	
	public function viewOrder($id){
		
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
		return view('orders.order',compact('order'));
	}
	
	public function editOrder($id){
		$order=Order::findOrFail($id);
		return view('orders.edit',compact('order'));
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
			$order->user_id=Auth::user()->id;
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
					$upload_filename=$file->getClientOriginalName();
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
				$message="Order files added by ".ucfirst(Auth::user()->name)." on order # ".$id.".";
				$msubject="Files Added";
				$datecreated=Carbon::now();
				$user_id=Auth::user()->id;		
				//app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
				$admin=User::where('role',1)->first();
				$mfrom=Auth::user()->id;	
				$mto=$admin->id;
				$message="Order files added by ".ucfirst(Auth::user()->name)." on order # ".$id.".";
				$msubject="Files Added";
				$datecreated=Carbon::now();
				$user_id=Auth::user()->id;		
				//app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			}else{
				$admin=User::where('role',1)->first();
				$mfrom=Auth::user()->id;	
				$mto=$admin->id;
				$message="Order files added by ".ucfirst(Auth::user()->name)." on order # ".$id.".";
				$msubject="Files Added";
				$datecreated=Carbon::now();
				$user_id=Auth::user()->id;		
				//app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
			}
			
		
			flash('File uploaded!','success');
			return Redirect::back();
		}else{
			flash('File uploaded failed!','danger');
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
					$upload_filename=$file->getClientOriginalName();
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
			//app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
				
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
					$upload_filename=$file->getClientOriginalName();
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

	   public function downloadZip($id)
    {
		$zip = new ZipArchive();
   
        $fileName = time().$id.'.zip';
        $folderName = rand(50570,158077).$id;
   
        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
        {
			$filesd=Orderfile::where('question_id',$id)->get();	
			$path = public_path().'/uploads/'.$folderName;

			File::makeDirectory($path, 0777, true);
			foreach($filesd as $file){
				$sourceFilePath=public_path('/uploads/').$file->filename;		
				
				$destinationPath=public_path()."/uploads/".$folderName.'/'.$file->filename;
				$success = File::copy($sourceFilePath,$destinationPath);
				
			}
				
			$files = File::files(public_path("/uploads/".$folderName));
   			foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }             
			$zip->close();
			
        }
		File::deleteDirectory(public_path("/uploads/".$folderName));
        return response()->download(public_path($fileName))->deleteFileAfterSend(true);
	}
	public function downloadSolutionZip($id)
    {
        $zip = new ZipArchive;
   
        $fileName = time().$id.'.zip';
        $folderName = rand(50570,158077).$id;
   
        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
        {
			$filesd=Solutionfile::where('question_id',$id)->get();	
			$path = public_path().'/solutions/'.$folderName;

			File::makeDirectory($path, 0777, true);
			foreach($filesd as $file){
				$sourceFilePath=public_path('/solutions/').$file->filename;		
				
				$destinationPath=public_path()."/solutions/".$folderName.'/'.$file->filename;
				$success = File::copy($sourceFilePath,$destinationPath);
				
			}
				
			$files = File::files(public_path("/solutions/".$folderName));
   			foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }             
			$zip->close();
			
        }
		File::deleteDirectory(public_path("/solutions/".$folderName));
        return response()->download(public_path($fileName))->deleteFileAfterSend(true);
	}
	
	
}
