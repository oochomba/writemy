@extends('layouts.app')
@section('title')
 {{ $post->title }}
@endsection

@section('content')  

<script src="https://cdn.tiny.cloud/1/w75xwosb7fak6zrt4r2hs4wjnvc53o7luvz03yuivs0rjwvv/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'charmap codesample emoticons image link lists table wordcount casechange linkchecker advtable advcode editimage autocorrect inlinecss',
    toolbar: 'blocks fontfamily fontsize | bold italic underline | link image  table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script>

<div class="row">
    <div class="col-12">
        <div class="d-flex">
            <h3>Edit: {{$post->title}}</h3>
            <div class="breadcrumb m-0">
               <a href="javascript: void(0);">{{ date('m-d-Y') }}</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal"  enctype="multipart/form-data" method="post" action="{{ url('/update-post') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{ $post->id }}" name="pid"/>
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="inputAddress"> Title</label>
                            <input type="text" class="form-control" name="title" id="inputAddress" value=" {{ $post->title }}" required="true" placeholder="Write about...">
                            @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 {{ $errors->has('blog') ? ' has-error' : '' }}">
                                <label for="inputEmail4">Blog Details</label>
                                <textarea name="blog" > {!! $post->body !!}</textarea>
                            </div>
                            @if ($errors->has('blog'))
                            <span class="help-block">
                                <strong>{{ $errors->first('blog') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('faq') ? ' has-error' : '' }}">
                            <label for="inputAddress">  Q 1</label>
                            <input type="text" class="form-control" name="faq" id="inputAddress" value=" {{ $post->faq }}" required="true" placeholder="FAQ">
                            @if ($errors->has('faq'))
                            <span class="help-block">
                                <strong>{{ $errors->first('faq') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('answera') ? ' has-error' : '' }}">
                            <label for="inputAddress">  Answer 1</label>
                            <input type="text" class="form-control" name="answera" id="inputAddress" value=" {{ $post->answera }}" required="true" placeholder="Answer">
                            @if ($errors->has('answera'))
                            <span class="help-block">
                                <strong>{{ $errors->first('answera') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('faqb') ? ' has-error' : '' }}">
                            <label for="inputAddress">  Q 2</label>
                            <input type="text" class="form-control" name="faqb" id="inputAddress" value=" {{ $post->faqb }}" required="true" placeholder="FAQ">
                            @if ($errors->has('faqb'))
                            <span class="help-block">
                                <strong>{{ $errors->first('faqb') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('answerb') ? ' has-error' : '' }}">
                            <label for="inputAddress">  Answer 2</label>
                            <input type="text" class="form-control" name="answerb" id="inputAddress" value=" {{ $post->answerb }}" required="true" placeholder="Answer">
                            @if ($errors->has('answerb'))
                            <span class="help-block">
                                <strong>{{ $errors->first('answerb') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('faqc') ? ' has-error' : '' }}">
                            <label for="inputAddress">  Q 3</label>
                            <input type="text" class="form-control" name="faqc" id="inputAddress" value=" {{ $post->faqc }}" required="true" placeholder="FAQ">
                            @if ($errors->has('keyphrase'))
                            <span class="help-block">
                                <strong>{{ $errors->first('faqc') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('answerc') ? ' has-error' : '' }}">
                            <label for="inputAddress">  Answer 3</label>
                            <input type="text" class="form-control" name="answerc" id="inputAddress" value=" {{ $post->answerc }}" required="true" placeholder="Answer">
                            @if ($errors->has('answerc'))
                            <span class="help-block">
                                <strong>{{ $errors->first('answerc') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-5" style="padding-left: 10px;">
                        <div class="form-group {{ $errors->has('label') ? ' has-error' : '' }}">
                            <label for="inputAddress">  Page Label</label>
                            <input type="text" class="form-control" name="label" id="inputAddress" value=" {{ $post->label }}" required="true" placeholder="Label">
                            @if ($errors->has('label'))
                            <span class="help-block">
                                <strong>{{ $errors->first('label') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('keyphrase') ? ' has-error' : '' }}">
                            <label for="inputAddress">  Key Phrase</label>
                            <input type="text" class="form-control" name="keyphrase" id="inputAddress" value=" {{ $post->keyphrase }}" required="true" placeholder="Key Phrase">
                            @if ($errors->has('keyphrase'))
                            <span class="help-block">
                                <strong>{{ $errors->first('keyphrase') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('metadescription') ? ' has-error' : '' }}">
                            <label for="inputAddress">  Meta Description</label>
                            <input type="text" class="form-control" name="metadescription" id="inputAddress" value=" {{ $post->metadescription }}" required="true" placeholder="Meta Description">
                            @if ($errors->has('metadescription'))
                            <span class="help-block">
                                <strong>{{ $errors->first('metadescription') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group  {{ $errors->has('menuitem') ? ' has-error' : '' }}">
                            <label for="inputEmail4">Menu Item</label>
                                @php
                                    $menus=App\Menu::orderBy('id','asc')->get();
                                @endphp
                            <select name="menuitem" class="form-control">
                                @if(count($menus)>0)
                                @foreach($menus as $menu)
                                <option value="{{$menu->id}}"  {{($menu->id ==$post->menuitem) ? 'selected':''}}>{{$menu->menuname}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('menuitem'))
                            <span class="help-block">
                                <strong>{{ $errors->first('menuitem') }}</strong>
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
                        <div class="form-group  {{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="inputEmail4">Category</label>
                            <select name="category" class="form-control">
                                @if(count($cats)>0)
                                @foreach($cats as $cat)
                                <option value="{{$cat->id}}"  {{($cat->id ==$post->category) ? 'selected':''}}>{{$cat->title}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if ($errors->has('category'))
                            <span class="help-block">
                                <strong>{{ $errors->first('category') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('fimage') ? ' has-error' : '' }}">
                            <label for="inputAddress">Featured Image</label>
                            <input type="text" class="form-control" name="fimage" id="inputAddress" value=" {{ $post->fimage }}" required="true" placeholder="fimage">
                            @if ($errors->has('fimage'))
                            <span class="help-block">
                                <strong>{{ $errors->first('fimage') }}</strong>
                            </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary shadow-btn">Save</button>  
                    </div>
                </div>
          </form>
        </div>
    </div>
    </div>
</div>
@endsection