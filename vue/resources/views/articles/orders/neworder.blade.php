@extends('layouts.app')
@section('title')
 Article order
@endsection

@section('content')


@php

$subjects=App\Subject::orderBy('subject','ASC')->get();
$types=App\Type::orderBy('type','ASC')->get();
$levels=App\Academic::orderBy('level','ASC')->get();
$languages=App\Language::orderBy('language','ASC')->get();
$styles=App\Style::orderBy('style','ASC')->get();
$budgets=App\Budget::orderBy('pages','ASC')->get();
$string=rand(10000,100000);
$tempid=md5($string);

@endphp   
<div class="row">
<div class="col-md-8">
    <br/>
    <div class="card">
        <div class="card-body">
        
            <form class="form-horizontal"  enctype="multipart/form-data" method="post" action="{{ url('/create-article-order') }}">
                {{ csrf_field() }}
                
        
              
                
                <div class="form-row">
                    <div class="form-group col-md-6 {{ $errors->has('subject') ? ' has-error' : '' }}">
                        <label for="inputEmail4">Type of Article</label>
                        <select  class="form-control" name="typeofarticle">
                            
                            <option value="1">Blog Post (1000-1250 words)</option>
                            <option value="2">Blog Ideation (150-250 words)</option>
                            <option value="3">Order Guidelines (1100-1250 words)</option>
                            <option value="4">Press Release (500-650 words)</option>
                            <option value="5">Product Description (500-650 words)</option>
                            <option value="6">Social Media Facebook (250-450 words)</option>
                            <option value="7">Social Media Twitter (100-150 words)</option>
                            <option value="8">Website Content (1000-1250 words)</option>
                           
                        </select>
                        @if ($errors->has('subject'))
                        <span class="help-block">
                            <strong>{{ $errors->first('subject') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-md-6 {{ $errors->has('academic') ? ' has-error' : '' }}">
                        <label for="inputEmail4">Author Rating</label>
                        <select n class="form-control" name="authorrating">
                         
                            <option value="5">5 Star</option>
                            <option value="4">4 Star</option>
                            <option value="3">3 Star</option>
                            <option value="2">2 Star</option>
                          
                        </select>
                        @if ($errors->has('academic'))
                        <span class="help-block">
                            <strong>{{ $errors->first('academic') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-row">
                   
                    <div class="form-group col-md-4 {{ $errors->has('language') ? ' has-error' : '' }}">
                        
                        <label for="inputPassword4">Article Category

                           
                        </label>
                    
                        <select name="subject" class="form-control">
                            
                            @if(count($subjects)>0)
                            @foreach($subjects as $subject)
                            <option value="{{$subject->id}}">{{$subject->subject}}</option>
                            @endforeach
                            @endif
                        </select>
                        @if ($errors->has('language'))
                        <span class="help-block">
                            <strong>{{ $errors->first('language') }}</strong>
                        </span>
                        @endif
                    </div>
                   
                    <div class="form-group col-md-8 {{ $errors->has('style') ? ' has-error' : '' }}">
                        <label for="inputPassword4">Word Count</label>
                        <div data-role="form-group">
                        
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-lg-6">
                                  
                                    <input type="number" name="pricemin" class="form-control" placeholder="Min" id="price-min" required >
                  
                                   
                                </div>
                                <div class="col-md-6 col-sm-12 col-lg-6">
                                   
                                    <input type="number" name="pricemax" placeholder="Max" class="form-control" id="price-max"  required>
                                  
                                </div>
                            </div>
                         </div>
                        @if ($errors->has('styles'))
                        <span class="help-block">
                            <strong>{{ $errors->first('style') }}</strong>
                        </span>
                        @endif
                    </div>
                  
                </div>
                <hr />
               
                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                    <label for="inputAddress">  Title</label>
                    <input type="text" class="form-control" name="title" id="inputAddress" value="{{ old('title') }}" required="true" placeholder="Write about...">
                    @if ($errors->has('title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 {{ $errors->has('instructions') ? ' has-error' : '' }}">
                        <label for="inputEmail4">Article Briefing</label>
                        <textarea width="100%" id="detailsee" name="instructions" >{{ old('instructions') }}</textarea>
                    </div>
                    @if ($errors->has('instructions'))
                    <span class="help-block">
                        <strong>{{ $errors->first('instructions') }}</strong>
                    </span>
                    @endif
   
                </div>
               
                <label for="category" class="col-md-12 control-label">Additional materials</label>
                <div class="form-group row">
                 
                    <div class="col-md-9 ad_materials_wrapper" id="files_div">
                        <div class="file_wrapper">
                            <label class="btn btn-outline-primary btn-file mr-2">
                                Select file... <input name="orderfiles[]" type="file" onchange="$('#upload-file-info').html(this.files[0].name)">
                            </label>
                            <span class="label label-info" id="upload-file-info"></span>
                            
                        </div>                                     
                    </div>
                    <div class="col-md-3 ad_materials_wrapper">
                        <button class="btn btn-outline-primary ml-2" id="add_file" data-toggle="tooltip" title="Add file"><i class="fa fa-plus"></i></button>
                     
                                 </div>
                                 </div>
                <button type="submit" class="btn btn-primary pull-right btn-lg shadow-btn">Submit Order</button>  
                      
               
            </form>
        </div>
    </div>
</div>
         
</div>
<script>
    CKEDITOR.replace( 'detailsee' );

var matched = $("#files_div");

var f_index = 1;

$("#add_file").click(function(e) {
	e.preventDefault();
	if (matched.children().length < 10) {
		add_file();
		f_index++;
	} else {
		alert('Maximum 10 files allowed.');
	}
});

function add_file() {
	$("#files_div").append('<div class="file_wrapper"><label class="btn btn-outline-primary btn-file mr-2">Browse file... <input type="file" name="orderfiles[]" onchange="$(\'#upload-file-info'+f_index+'\').html(this.files[0].name)"></label><span class="label label-info" id="upload-file-info'+f_index+'">No file selected</span><button class="btn btn-outline-danger ml-2" onclick="remove_file(this)"><i class="fa fa-trash"></i></button></div>');
}

function remove_file(ele) {
	$(ele).parent().remove();
	return;
}
</script>
     
@endsection