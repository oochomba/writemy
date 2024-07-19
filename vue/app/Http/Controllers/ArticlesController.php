<?php

namespace App\Http\Controllers;
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
class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function newOrder(Request $request)
    {
        return view('articles.orders.neworder');
    }

    public function createArticleorder(Request $request){
        $lastorder=Order::latest()->first();
        if(@count($lastorder)>0){
            $id=$lastorder->id+1;
        }else{
            $id=15000;
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
        //dd("upload complete");
    $validator = Validator::make($request->all(), [
            'title' => 'required|string',  	
           	'pricemin' => 'numeric|max:9999',
            'pricemax' => 'numeric|max:9999',			
      
        ]);

    if($validator->fails()){
        flash('You have input errors on the form. Correct them please.', 'danger');
        return Redirect::back()
        ->withErrors($validator)
        ->withInput();
    }else{
        
        $order= new Order;
        $order->id=$id;    
        $order->site_id=1;
        $order->order_type=2;
        $order->user_id=Auth::user()->id;
        $order->title=$request->title;
        $order->instructions=$request->instructions;
        $order->subject=$request->subject;
        $order->authorrating=$request->authorrating;
        $order->typeofarticle=$request->typeofarticle;
        $order->pricemin=$request->pricemin;
        $order->pricemax=$request->pricemax;    
        $order->status=1;       
        $order->save();	      
       
            
        $admin=User::where('role',1)->first();
        $mfrom=$admin->id;	
        $mto=Auth::user()->id;
        $message="You have placed an order with id # ".$id.". Our expert writers are reviewing it. Please check the bids and assign to the preferred writer.";
        $msubject="Order Placed";
        $datecreated=Carbon::now();
        $user_id=Auth::user()->id;		
        //app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
        
        
        $mfrom=Auth::user()->id;	
        $mto=$admin->id;
        $message="Client ".ucfirst(Auth::user()->name)." has placed order with id # ".$id.".";
        $msubject="Order Placed";
        $datecreated=Carbon::now();
        $user_id=Auth::user()->id;		
       // app()->call('App\Http\Controllers\SendemailsController@prepareEmail', [$mfrom,$mto,$msubject,$message,"",$datecreated,$user_id]);
    
        flash('Success! Order submitted. Top writers are bidding on your Order. Check bids and assign ', 'success');
        $route=URL::to('/order',$id);
        return redirect($route);	
    }

    }
    
}
