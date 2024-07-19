<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Message;
use App\User;
use App\Qmailer;
use Carbon\Carbon;
use App\Messagefile;
use App\Queuedmail;
use Redirect;
use Illuminate\Http\Request;
use Validator;
class MessagesController extends Controller{
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct(){
		$this->middleware('auth');
	}

	/**
	* Show the application dashboard.
	*
	* @return \Illuminate\Http\Response
	*/
	public function createMessage(){
    	
		return view('messages.createmessage');
	}

	public function replyMessage($id){
		return view('messages.replymessage');	
	}
    
	public function receivedMessages(){
		$message=Message::where('status',0)->where('mto',Auth::user()->id)->get();		
		foreach($message as $sms){
			if($sms->mto==Auth::user()->id){
				Message::where('id',$sms->id)->update(['status'=>1]);	
			}
		}
		$messages=Message::where('mto',Auth::user()->id)->orderBy('created_at','DESC')->get();
		return view('messages.inbox',compact('messages'));
	}
	public function sentMessages(){
		$messages=Message::where('mfrom',Auth::user()->id)->orderBy('created_at','DESC')->get();
		return view('messages.sentmessages',compact('messages'));
	}
	
	public function sendMessage(Request $request){
		
	
		$messageb=$request->yourmessage;
		$mto=$request->messageto;
		$order=$request->orderid;
		$sendmessage=new Message;
		$sendmessage->mfrom=Auth::user()->id;
		$sendmessage->mto=$mto;
		$sendmessage->order_id=$order;
		$sendmessage->message=$messageb;
		$sendmessage->save();
		$id=$sendmessage->id;
		
		if($request->hasFile('messagefiles')){    
			$files = $request->messagefiles;
			$file_count = count($files);
			$uploadcount = 0;
			foreach($files as $file){
				$rules = array('file' => 'required|mimes:doc,docx,ppt,pptx,zip,7z,rar,txt,pdf,xls,xlsx,gif,jpg,jpeg,png,bmp,mp3,wav,java,accdb,sav,zsav,dat,pub|max:20000'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
				$validator = Validator::make(array('file'=> $file), $rules);
				if($validator->passes()){
					$destinationPath = public_path('/mfiles');						
					$upload_filename=time().' '.$file->getClientOriginalName();
					$upload_success = $file->move($destinationPath, $upload_filename);
						
					$mfiles=new Messagefile;
					$mfiles->messagefile = $upload_filename;
					$mfiles->question_id = $order;
					$mfiles->message_id = $id;
					$mfiles->user_id = Auth::user()->id;
					$mfiles->save();					
					$uploadcount ++;
				}
			}
		}
		$rece=User::where('id',$mto)->first();
		$admin=User::where('role',1)->first();
		$from=Auth::user()->id;	
		$mto=$rece->id;
		$message="<b>".$messageb."</b>";
		$msubject="New Message on order #".$order;
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
		app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$from,$mto,$msubject,$message,"",$datecreated,$user_id]);			
			
		$admin=User::where('role',1)->first();
		$from=Auth::user()->id;	
		$mto=$admin->id;
		$message="User ".ucfirst(Auth::user()->name)." has sent a message to user ".ucfirst($rece->name).". The message is : <b>".$messageb."</b>.";
		$msubject="New Message sent order #".$order;
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
		app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$from,$mto,$msubject,$message,"",$datecreated,$user_id]);
		flash('Message sent. The recipient has been notified.','success');
		return Redirect::back();
	}
	public function directMessage(Request $request){
		//dd($request->all());
		
		$lastmessage=Message::latest()->first();
		if(count($lastmessage)>0){
			$id=$lastmessage->id+1;
		}else{
			$id=37500;
		}
		$messageb=$request->yourmessage;
		$mto=$request->messageto;
		$order=$request->orderid;
		$sendmessage=new Message;
		$sendmessage->mfrom=Auth::user()->id;
		$sendmessage->id=$id;
		$sendmessage->mto=$mto;
		$sendmessage->message=$messageb;
		$sendmessage->save();
		
		if($request->hasFile('messagefiles')){    
			$files = $request->messagefiles;
			$file_count = count($files);
			$uploadcount = 0;
			foreach($files as $file){
				$rules = array('file' => 'required|mimes:doc,docx,ppt,pptx,zip,7z,rar,txt,pdf,xls,xlsx,gif,jpg,jpeg,png,bmp,mp3,wav,java,accdb,sav,zsav,dat,pub|max:20000'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
				$validator = Validator::make(array('file'=> $file), $rules);
				if($validator->passes()){
					$destinationPath = public_path('/mfiles');						
					$upload_filename=time().' '.$file->getClientOriginalName();
					$upload_success = $file->move($destinationPath, $upload_filename);
						
					$mfiles=new Messagefile;
					$mfiles->messagefile = $upload_filename;
					$mfiles->message_id = $id;
					$mfiles->user_id = Auth::user()->id;
					$mfiles->save();					
					$uploadcount ++;
				}
			}
		}		
		$admin=User::where('role',1)->first();
		$from=Auth::user()->id;	
		$mto=$mto;
		$message=$messageb;
		$msubject="New Message";
		$datecreated=Carbon::now();
		$user_id=Auth::user()->id;		
		app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$from,$mto,$msubject,$message,"",$datecreated,$user_id]);
			
		flash('Message sent. The recipient has been notified.','success');
		return Redirect::back();
	}
	public function messageFile($filename){
		$path=public_path('/mfiles/').$filename;
		return response()->download($path);
	}
	
	public function deleteMessage(Request $request){		
		$mid=$request->mid;
		$message=Message::findOrFail($mid);
		$message->delete();
		flash('Message deleted!','success');
		return Redirect::back();
	}
	
	public function clearMessages($id){		
		$message=Message::where('order_id',$id)->get();		
		foreach($message as $sms){
			if($sms->mto==Auth::user()->id){
				Message::where('id',$sms->id)->update(['is_read'=>1]);	
			}
		}
	}
	public function emailAllClients(){
		return view('messages.allclients');
	}
	public function postSendEmails(Request $request){
		$validator = Validator::make($request->all(), [			
			'subject' => 'required',	
			'yourmessage' => 'required',	
		
		]);

	if($validator->fails()){
		flash('You have input errors on the form. Correct them please.', 'danger');
		return Redirect::back()
		->withErrors($validator)
		->withInput();
	}else{
		$users=User::where('role',3)->get();
		foreach($users as $user){
			$newmessage=new Queuedmail;
			$newmessage->mfrom="System Support";
			$newmessage->mto=$user->id;
			$newmessage->msubject=$request->subject;
			$newmessage->mymessage=$request->yourmessage;	
			$newmessage->save();
			
		}
		flash('Message Sent!','success');
		return Redirect::back();
			
		
	}

		
	}
	public function postSendEmailswriters(Request $request){
		$validator = Validator::make($request->all(), [			
			'subject' => 'required',	
			'yourmessage' => 'required',	
		
		]);

	if($validator->fails()){
		flash('You have input errors on the form. Correct them please.', 'danger');
		return Redirect::back()
		->withErrors($validator)
		->withInput();
	}else{
		$users=User::where('role',4)->get();
		foreach($users as $user){
			$newmessage=new Queuedmail;
			$newmessage->mfrom="System Support";
			$newmessage->mto=$user->id;
			$newmessage->msubject=$request->subject;
			$newmessage->mymessage=$request->yourmessage;	
			$newmessage->save();
			
		}
		flash('Message Sent!','success');
		return Redirect::back();
			
		
	}
	
	}
	public function emailWriters(){
		return view('messages.allwriters');
	}
	
}
