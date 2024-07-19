@extends('layouts.app')
@section('title')
{{$cat->title}}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Edit Category</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Category</a></li>
                    <li class="breadcrumb-item active">Edit Category</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div id="content" class="app-content">


    <div class="row">
        <div class="col-md-6">
         
           
            <div class="card">
                <div class="card-body">
                
                    <form class="form-horizontal"  enctype="multipart/form-data" method="post" action="{{ url('/update-cat') }}">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $cat->id }}" name="cid"/>
                        
                
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="inputAddress"> Category Name</label>
                            <input type="text" class="form-control" name="name" id="inputAddress" value="{{$cat->title}}" required="true" placeholder="Category name...">
                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                        
                    
                      
                        <div class="form-row">
                            <div class="form-group col-md-12 {{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="inputEmail4">Description</label>
                                <textarea width="100%" id="detailsee" name="description" >{{$cat->description}}</textarea>
                            </div>
                            @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
           
                        </div>
                           
                        
                        <button type="submit" class="btn btn-primary shadow-btn">Save</button>  
                              
                       
                    </form>
                </div>
            </div>
        </div>
   
    </div>

</div>
<script>
    CKEDITOR.replace( 'detailsee' );
</script>
@stop