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
class BlogController extends Controller{
  
  public function getPages(Request $request){
        $query = Blog::where('type', 1)->where('status', 1);
        
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%');
        }
        $posts = $query->orderBy('created_at', 'DESC')->paginate(12);
        
        return view('views.blog.index', compact('posts'));
    }


  public function getBlogs(Request $request){
        $query = Blog::where('type', 2)->where('status', 1);
        
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%');
        }
        $posts = $query->orderBy('created_at', 'DESC')->paginate(12);
        
        return view('views.blog.index', compact('posts'));
    }

    public function findBySlug($slug) {
        $post = Blog::where('slug', $slug)->first();
        if ($post->type == 1) {
            $relatedPosts = Blog::where('type', 1)
                                ->where('category', $post->category)
                                ->where('id', '!=', $post->id)
                                ->limit(4)
                                ->get();
            return view('views.blog.page', compact('post', 'relatedPosts'));
        } elseif ($post->type == 2) {
            $relatedPosts = Blog::where('type', 2)
                                ->where('category', $post->category)
                                ->where('id', '!=', $post->id)
                                ->limit(8)
                                ->get();
            return view('views.blog.blog-detail', compact('post', 'relatedPosts'));
        } else {
            abort(404, 'Page Not Found');
        }
    }
}