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
class PostsController extends Controller{
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct(){
		$this->middleware('auth');
    }

    public function getPosts(){
        $posts=Blog::where('type',2)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(10);
        
        return view('blogs.index',compact('posts'));
	}
	public function createPost(){
		$cats=Cat::where('is_deleted',0)->orderBy('title','asc')->get();
		return view('blogs.newpost',compact('cats'));
	}

	public function createCategory(){
		$cats=Cat::where('is_deleted',0)->orderBy('title','asc')->get();
		return view('blogs.newcategory',compact('cats'));
	}
	
	public function viewPosts(){
		$posts=Blog::where('type',2)->where('is_deleted',0)->orderBy('created_at','DESC')->paginate(10);
      
		return view('blogs.posts',compact('posts'));
	}
	public function getPost($id){
		$post=Blog::findOrFail($id);
      
		return view('blogs.singlepost',compact('post'));
	}
	public function editPost($id){
		$post=Blog::findOrFail($id);   
		$cats=Cat::where('is_deleted',0)->orderBy('title','asc')->get();   
		return view('blogs.editpost',compact('post','cats'));
	}

public function postCreatepost(Request $request){
    $validator = Validator::make($request->all(), [
        'title' => 'required|string',
        'blog' => 'required',
        'label' => 'required',
        'category' => 'required|exists:cats,id', // Validate that the category exists
        'featured_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
    ]);

    if ($validator->fails()) {
        flash('You have input errors on the form. Correct them please.', 'danger');
        return Redirect::back()
            ->withErrors($validator)
            ->withInput();
    } else {
        $post = new Blog;
        $post->title = $request->title;
        $post->label = $request->label;
        $post->body = $request->blog;
        $post->status = 1;
        $post->type = 2;
        $post->created_by = auth()->user()->id;
        $post->keywords = $request->keywords;

        $category = Cat::find($request->category);
        $post->category = $category->title;  // Assigning category title

        $post->metadescription = $request->metadescription;
        $post->keyphrase = $request->keyphrase;
        $post->faq = $request->faq;
        $post->answera = $request->answera;
        $post->faqb = $request->faqb;
        $post->answerb = $request->answerb;
        $post->faqc = $request->faqc;
        $post->answerc = $request->answerc;
        $post->fimage = $request->fimage;
        $post->save();
        flash('Post Created Successfully.', 'success');
        return Redirect::back();
    }
}

public function updatePost(Request $request){
    $validator = Validator::make($request->all(), [
        'title' => 'required|string',
        'blog' => 'required',
        'label' => 'required',
        'category' => 'required|exists:cats,id', // Validate that the category exists
    ]);

    if ($validator->fails()) {
        flash('You have input errors on the form. Correct them please.', 'danger');
        return Redirect::back()
            ->withErrors($validator)
            ->withInput();
    } else {
        $post = Blog::findOrFail($request->pid);
        $post->label = $request->label;
        $post->title = $request->title;
        $post->body = $request->blog;

        $category = Cat::find($request->category);
        $post->category = $category->title;  // Assigning category title

        $post->menuitem = $request->menuitem;
        $post->status = 1;
        $post->created_by = auth()->user()->id;
        $post->keywords = $request->keywords;
        $post->metadescription = $request->metadescription;
        $post->keyphrase = $request->keyphrase;
        $post->faq = $request->faq;
        $post->answera = $request->answera;
        $post->faqb = $request->faqb;
        $post->answerb = $request->answerb;
        $post->faqc = $request->faqc;
        $post->answerc = $request->answerc;
        $post->fimage = $request->fimage;
        $post->save();
        flash('Updated Successfully.', 'success');
        $route = URL::to('/view-post', $request->pid);
        return redirect($route);
    }
}

	public function deletePost($id){
		if(auth::user()->role==1){
			$post=Blog::findOrFail($id);
			$post->delete();
		}else{
			flash('You\'re lost! Get out of here!' ,'danger');
			return Redirect::back();
		}
		flash('Post deleted Successfully.','success');
		$route=URL::to('/view-posts');
			return redirect($route);	
	}
	public function toggleStatus($id){
		if(auth::user()->role==1){
			$post=Blog::findOrFail($id);
			if($post->status==1){
				$post->status=0;
				$post->save();
			}else{
				$post->status=1;
				$post->save();
			}
		
		}else{
			flash('You\'re lost! Get out of here!' ,'danger');
			return Redirect::back();
		}
		flash('Post Status updated.','success');
	
		$route=URL::to('/view-post',$id);
			return redirect($route);
	}

	public function findBySlug($slug){
		dd($slug);
	}
}