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
use App\Menu;
use App\User;
use App\Cat;
use App\Menuitem;
use App\Navmenu;

class MenuController extends Controller{
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct(){
		$this->middleware('auth');
    }

    public function index(){    
        $menus=Menu::orderBy('menuname','DESC')->get();
        $tpages=Blog::where('type',1)->orderBy('title','ASC')->get();
        return view('menus.index',compact('menus','tpages'));
	}
	public function addMenupage(Request $request){		
		$post=new Menuitem;			
		$post->page_id=$request->page;		
		$post->menuid=$request->mid;		
		$post->created_by=auth()->user()->id;
		$post->save();
		flash('Menu item added successfully.','success');
		return Redirect::back();
	
	}
	public function addGrandChildMenu(Request $request){

		$post=new Navmenu;			
		$post->pageid=$request->page;		
		$post->menuid=$request->mid;		
		$post->navid=$request->cid;
		$post->save();
		flash('Menu item added successfully.','success');
		return Redirect::back();
	
	}
	
}