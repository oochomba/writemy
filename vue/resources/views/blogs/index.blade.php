@extends('layouts.app')
@section('title')
 Posts
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Category</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">New Category</a></li>
            
                </ol>
            </div>

        </div>
    </div>
</div>
<div id="content" class="app-content">

        <div class="col-md-6">
            <br/>
           
            <div class="card11">
                <div class="card-body">
                
                    <form class="form-horizontal"  enctype="multipart/form-data" method="post" action="{{ url('/post-create-cat') }}">
                        {{ csrf_field() }}
                        
                
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="inputAddress"> Category Name</label>
                            <input type="text" class="form-control" name="name" id="inputAddress" value="{{ old('name') }}" required="true" placeholder="Category name...">
                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                        
                    
                      
                        <div class="form-row">
                            <div class="form-group col-md-12 {{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="inputEmail4">Description</label>
                                <textarea width="100%" id="detailsee" name="description" >{{ old('description') }}</textarea>
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