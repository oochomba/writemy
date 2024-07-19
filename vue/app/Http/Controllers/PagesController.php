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
use App\Cat;
use App\Pageseo;

class PagesController extends Controller{
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct(){
		$this->middleware('auth');
	}
	
	public function newPage(){
		$cats=Cat::where('is_deleted',0)->orderBy('title','asc')->get();
		return view('pages.index',compact('cats'));
	}

    public function getPages(){    
		$cats=Cat::where('is_deleted',0)->orderBy('title','asc')->get();
		$posts=Blog::where('type',1)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(10);
        return view('pages.pages',compact('cats','posts'));
	}

	public function createPage(Request $request){
		$validator = Validator::make($request->all(), [
			'title' => 'required|string',
			'blog' => 'required',		
		]);
		if($validator->fails()){
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
			->withErrors($validator)
			->withInput();
		}else{
		$post=new Blog;	
		$post->title=$request->title;
		$post->label=$request->label;
		$post->body=$request->blog;
		$post->menuitem=$request->menuitem;
		$post->status=1;
		$post->type=1;
		$post->created_by=auth()->user()->id;
		$post->keywords=$request->keywords;
		$post->metadescription=$request->metadescription;
		$post->keyphrase=$request->keyphrase;
		$post->featured_image=$request->featured_image;
		$post->faq=$request->faq;
		$post->answera=$request->answera;
		$post->faqb=$request->faqb;
		$post->answerb=$request->answerb;
		$post->faqc=$request->faqc;
		$post->answerc=$request->answerc;
		$post->fimage=$request->fimage;
		$post->save();

		flash('Page Created Successfully.','success');
		return Redirect::back();
		
	}
	}

	public function makeSEO(){
		$posts=Blog::where('status',1)->orderBy('title','ASC')->get();
		return view('pages.seo',compact('posts'));
	}
	public function editSeo($id){
		$post=Pageseo::where('id',$id)->first();
		return view('pages.editseo',compact('post'));
	}
	public function updateSeopost(Request $request){
		$validator = Validator::make($request->all(), [
			'title' => 'required|string',
			'label' => 'required',
			'metadescription' => 'required',
			'keyphrase' => 'required',
			'keywords' => 'required',			
			
		]);
		if($validator->fails()){
			flash('You have input errors on the form. Correct them please.', 'danger');
			return Redirect::back()
			->withErrors($validator)
			->withInput();
		}else{
		
		$post= Pageseo::findOrFail($request->pid);	
		$post->title=$request->title;
		$post->label=$request->label;
		
		$post->created_by=auth()->user()->id;
		$post->keywords=$request->keywords;		
		$post->metadescription=$request->metadescription;
		$post->keyphrase=$request->keyphrase;
		$post->featured_image=$request->featured_image;
		$post->faq=$request->faq;
		$post->answera=$request->answera;
		$post->faqb=$request->faqb;
		$post->answerb=$request->answerb;
		$post->faqc=$request->faqc;
		$post->answerc=$request->answerc;
		$post->fimage=$request->fimage;
		$post->save();
		flash('Seo Updated Successfully.','success');
		$route=URL::to('/seo');
			return redirect($route);	
		
	}
	}
}