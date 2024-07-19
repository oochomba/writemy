@extends('layouts.app')
@section('title')
 {{ $post->title }}
@endsection


@section('content')  
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Edit {{$post->title}}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Posts</a></li>
                    <li class="breadcrumb-item active">Edit Post</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="row">
<div class="col-md-12">
    <br/>
    <div class="card">
        <div class="card-body">
        
            <form class="form-horizontal"  enctype="multipart/form-data" method="post" action="{{ url('/update-seopost') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{ $post->id }}" name="pid"/>
                <div class="row">
                    <div class="col-md-7 col-sm-12 col-lg-7">
                        <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="inputAddress">  Title</label>
                            <input type="text" class="form-control" name="title" id="inputAddress" value=" {{ $post->title }}" required="true" placeholder="Write about...">
                            @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                       
                    </div>
                    <div class="col-md-7 col-sm-12 col-lg-7">
                        <div class="form-group {{ $errors->has('label') ? ' has-error' : '' }}">
                            <label for="inputAddress">  Label</label>
                            <input type="text" class="form-control" name="label" id="inputAddress" value=" {{ $post->title }}" required="true" placeholder="Write about...">
                            @if ($errors->has('label'))
                            <span class="help-block">
                                <strong>{{ $errors->first('label') }}</strong>
                            </span>
                            @endif
                        </div>
                       
                    </div>
                    <div class="col-md-7 col-sm-12 col-lg-7">
                        <div class="form-group {{ $errors->has('metadescription') ? ' has-error' : '' }}">
                            <label for="inputAddress">  Meta Description</label>
                            <textarea  class="form-control" name="metadescription" id="inputAddress" required="true" placeholder="Meta Description">{{ $post->metadescription }}</textarea>
                            @if ($errors->has('metadescription'))
                            <span class="help-block">
                                <strong>{{ $errors->first('metadescription') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-12 col-lg-7">

                        <div class="form-group {{ $errors->has('keyphrase') ? ' has-error' : '' }}">
                            <label for="inputAddress">  Key Phrase</label>
                            <input type="text" class="form-control" name="keyphrase" id="inputAddress" value=" {{ $post->keyphrase }}" required="true" placeholder="Key Phrase">
                            @if ($errors->has('keyphrase'))
                            <span class="help-block">
                                <strong>{{ $errors->first('keyphrase') }}</strong>
                            </span>
                            @endif
                        </div>
                           
                      
                        
                           
                        <div class="form-group {{ $errors->has('keywords') ? ' has-error' : '' }}">
                            <label for="inputAddress">  Key Words</label>
                            <input type="text" class="form-control" name="keywords" id="inputAddress" value=" {{ $post->keywords }}" required="true" placeholder="Article Keywords">
                            @if ($errors->has('keywords'))
                            <span class="help-block">
                                <strong>{{ $errors->first('keywords') }}</strong>
                            </span>
                            @endif
                        </div>
                       
                 
                        <button type="submit" class="btn btn-primary shadow-btn">Update</button>  
                    </div>
                </div>
                
        
               
                   
               
                
                
               
                
                
                      
               
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
	$("#files_div").append('<div class="file_wrapper"><label class="btn btn-outline-success btn-file mr-2">Browse file... <input type="file" name="orderfiles[]" onchange="$(\'#upload-file-info'+f_index+'\').html(this.files[0].name)"></label><span class="label label-info" id="upload-file-info'+f_index+'">No file selected</span><button class="btn btn-outline-danger ml-2" onclick="remove_file(this)"><i class="fa fa-trash"></i></button></div>');
}

function remove_file(ele) {
	$(ele).parent().remove();
	return;
}
</script>
     
@endsection