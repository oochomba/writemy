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
use App\Blog;
use App\User;
use App\Order;
use App\Award;
use App\Wallet;
use App\Rating;
use App\Orderfile;
use App\Additionalservice;

use AuthenticatesUsers;
class FrontController extends Controller{

    public function bigFormorder(){
        return view('orderform');
    }
    public function createUser(Request $request){		

        $messages = [
            'email.required' => 'Please fill in your email address.',     
            
          ];
        $validator = Validator::make($request->all(), [           
            'email' => 'required',    
            
        ],$messages);

        if ($validator->fails()) {
            flash('You have input errors on the form. Correct them please.', 'danger');
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{
           
            $email=$request->email;
            
            $role=3;
            $emailexists=User::where('email',$email)->first();
            if($emailexists==""){
                $lastuser=User::latest()->first();
                if(count($lastuser)>0){
                    $rand=rand(11111,111111);
                    $id=$lastuser->id+12000+$rand;
                }else{
                    $rand=rand(11111,111111);
                    $id=12000+$rand;
                }
            
                $role=3;
                $pass=str_random(8);  
                $result = substr($email, 0, 7);             
                $name=$result;
                $user=new User;
                $user->id=$id;
                $user->name=$name;
                $user->email=$email;
                $user->password=bcrypt($pass);
                $user->role=$role;
                $user->save();
                //user account
            
                $wallet=new Wallet;
                $wallet->user_id=$id;
                $wallet->balance=0;
                $wallet->save();
                
                $awards=new Award;
                $awards->user_id=$id;
                $awards->award=0;
                $awards->save();
                
                $ratings=new Rating;
                $ratings->user_id=$id;
                $ratings->score=0;
                $ratings->reviews=0;
                $ratings->save();
            
                $mfrom=Auth::user()->id;	
                $mto=$id;
                $message="You account has been created. Your email is ".$email." and your password is ".$pass.". Change password on login. ";
                $msubject="Account Created";
                $datecreated=Carbon::now();
                $user_id=Auth::user()->id;
             
                if(app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id])){
                    $user= Auth::attempt(['email' => $request->email, 'password' =>$pass]);
                     if ($user) {           
                      
                    return $this->createRorder($request); 
                
                   }else{  
                       
                  return $this->redirectToLogin($email);
                   }
                }else{
                    //delete the already created account
                    $user->delete($user_id);
                
                     return $this->redirectToLogin($email);
                }
                
               
                 
            }else{
                return $this->redirectToLogin($email);
            }
        }	
        
        
        
        
    }
    public function redirectToLogin($email){
        flash('This email ('.$email.') is registered. Please login or reset your password.','danger');
       
        $route=URL::to('/login');
        return redirect($route);	
            
    }

    public function createRorder(Request $request){         
        $lastorder=Order::latest()->first();
        if(@count($lastorder)>0){
            $id=$lastorder->id+1;
        }else{
            $id=15000;
        }		
 
       
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
			$order->id=$id;
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
        

        if($request->writer_category!=""){
            $aorder=new Additionalservice;
            $aorder->service="Writer Category";
            $aorder->price=$request->writer_category;
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
        $message="You have placed an order with id # ".$id.". Our writers are reviewing it. Please check for bids.";
        $msubject="Order Placed";
        $datecreated=Carbon::now();
        $user_id=Auth::user()->id;		
        app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
        
        
        $mfrom=Auth::user()->id;	
        $mto=$admin->id;
        $message="Client ".ucfirst(Auth::user()->name)." has placed order with id # ".$id.".";
        $msubject="Order Placed";
        $datecreated=Carbon::now();
        $user_id=Auth::user()->id;		
        app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
    
        flash('Success! Order submitted. Scholars are bidding on your Order. Please check your email for Verification and Password', 'success');
        $route=URL::to('/order',$id);
        return redirect($route);	
    }
    }
    
     public function postHomework(Request $request){
        
         
    
    $validator = Validator::make($request->all(), [
            'email' => 'required',
            'topic' => 'required',			
            'deadline' => 'required',		
            		
            'subject' => 'required',
        ]);

    if($validator->fails()){
        flash('You have input errors on the form. Correct them please.', 'danger');
        return Redirect::back()
        ->withErrors($validator)
        ->withInput();
    }else{

        if($request->title==null){
            //get user by email
            $email=$request->email;
            $subject=$request->subject;
            $deadline=$request->deadline;
            $title=$request->topic;
            $user=User::where('email',$email)->first();
            if($user!=null){
                //user exists, redirect to partial login with data
                $udata=array(
                    'email'=>$email,
                    'subject'=>$subject,
                    'deadline'=>$deadline,
                    'title'=>$title,
                );
               
                return view('orders.wordpresslogin',compact('udata'));
            }else{
                //sign up the user
                $lastuser=User::latest()->first();
                if(count($lastuser)>0){
                    $rand=rand(11111,111111);
                    $id=$lastuser->id+12000+$rand;
                }else{
                    $rand=rand(11111,111111);
                    $id=12000+$rand;
                }
                $role=3;
                $pass=str_random(8);    
                $result = substr($email, 0, 7);     
                $name=$result;
                $user=new User;
                $user->id=$id;
                $user->name=$name;
                $user->email=$email;
                $user->password=bcrypt($pass);
                $user->role=$role;
                $user->save();
            
                $wallet=new Wallet;
                $wallet->user_id=$id;
                $wallet->balance=0;
                $wallet->save();
                
                $awards=new Award;
                $awards->user_id=$id;
                $awards->award=0;
                $awards->save();
                
                $ratings=new Rating;
                $ratings->user_id=$id;
                $ratings->score=0;
                $ratings->reviews=0;
                $ratings->save();           
                

                $admin=User::where('role',1)->first();
                $mfrom=$admin->id;	
                $mto=$id;
                $message="Thank you for choosing WriteMyPaperforMe.org as your custom paper provider. You have completed the registration and account created. Your email is ".$email." and your password is ".$pass.". Change password on login. ";
                $msubject="CONGRATULATIONS! Welcome to WriteMyPaperforMe.org";
                $datecreated=Carbon::now();
                $user_id=$id;            
                app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
            
                $time =$deadline;		
                $dtime = DateTime::createFromFormat("m-d-Y G:i", $time);
                $timestamp = $dtime->getTimestamp();
                $timer=Carbon::now();
                
                $lastorder=Order::latest()->first();
                if(@count($lastorder)>0){
                    $oid=$lastorder->id+1;
                }else{
                    $oid=15000;
                }
                $order= new Order;
                $order->id=$oid;
                $order->user_id=$id;
                $order->title=$title;
                $order->instructions="";
                $order->subject=$subject;
                $order->academic=2;
                $order->paper_type=1;
                $order->language=2;
                $order->style=1;
                $order->budget=50;
                $order->sources=0;
                $order->pages=0;
                $order->duedate= date('Y-m-d H:i:s', $timestamp);
                $order->deadline=$timestamp-strtotime($timer);
                $order->status=1;
                $order->sources=0;
                $order->save();	
                $admin=User::where('role',1)->first();
                $mfrom=$admin->id;	
                $mto=$id;
                $message="You have placed an order with id # ".$oid.". Our writers are reviewing it. Please check bids and assign.";
                $msubject="Order Placed";
                $datecreated=Carbon::now();
                $user_id=$id;		
                app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
                $mfrom=$id;	
                $mto=$admin->id;
                $message="Client ".ucfirst(Auth::user()->name)." has placed order with ID # ".$id.".";
                $msubject="Order Placed";
                $datecreated=Carbon::now();
                $user_id=$id;		
                app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
            
               
                $userE = User::where('id',$id)->first();

if(empty($userE)){
abort(404);
}

if(Auth::loginUsingId($userE->id)){
    flash('Success! Order submitted. Please update this information and Check your email for logins ', 'success');
    $route=URL::to('/edit',$oid);
return redirect($route);
}
               	
            }             

           $route=URL::to('/home');
return redirect($route);

            }
    }
    }
}
