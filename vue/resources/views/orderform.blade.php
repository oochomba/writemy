@extends('layouts.frontend')
@section('canonical','order')
@section('title')
    New Order | WriteMyPaperforMe.org
@endsection
@section('content')

@section('content')


<script src="https://cdn.tiny.cloud/1/w75xwosb7fak6zrt4r2hs4wjnvc53o7luvz03yuivs0rjwvv/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'charmap emoticons image link table lists linkchecker',
    toolbar: 'blocks fontsize | numlist bullist',
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="/writemypaperforme/asset/timepicker/jquery.datetimepicker.css" rel="stylesheet">

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

<style>
    .form-group{
        margin-bottom: 1px;
        margin-top: 1px;
        text-align:left;
        padding: 5px 5px;
        width: 100%;
    }
    .form-control{
        margin-bottom: 1px;
        margin-top: 1px;
        text-align:left;
        border: 1px solid #ddd;
    }
    .lable{
        line-height: 1.5em;
        font-size: 16px;
        font-weight:500;
    }
    .row1{line-height:2;}
    .advantages__itemq{
        margin-bottom:20px;
        border:1px solid #ddd;
        border-radius:10px;
        cursor: pointer;
        background: #fff;
        padding:20px;
    }
    .form-row{
        display:flex;
        margin-top:11px;
    }
    .sectio {
        padding: 100px 0;
        text-align: center;
    }
    .card {
        border: 1px solid #ddd;
        padding:14px 14px; 
        background: #ffff;
        border-radius: 10px;
    }
     .container {
        background: #dcfce3;
        padding-top:35px;
    }
    .section-v2__heading {
       font-size:22px; 
       font-weight:bold;
       text-align:center;
    }
    .as_checkbox_wrapper label {
    	padding: 14px 18px 14px 22px;
    } 
    .as_checkbox_wrapper .as_checkbox {
    	display: flex;justify-content:space-around;
    }
    .as_checkbox_wrapper .as_checkbox .as_input {
	    padding: 0 1rem;
    }
    .as_checkbox_wrapper .as_body {
    	width: 70%;
    }
    .as_checkbox_wrapper .as_body .as_header {
    	display: flex;
    	justify-content: space-between;
    }
    .as_checkbox_wrapper .as_body .as_desc {
    	text-align: left;
    	font-size: 14px;
    }
</style>

<div class="container ">
    <h1>Order Form</h1>
    <div class="row sectio">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal"  enctype="multipart/form-data" method="post" action="{{ url('/preorder-form') }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="lable" for="inputAddress">Topic/Title</label>
                            <input type="text" class="form-control" style="border: 1px solid rgba(0, 0, 0, 0.2);" name="title" id="inputAddress" value="{{ old('title') }}" required="true" placeholder="Write about...">
                            @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-8 {{ $errors->has('subject') ? ' has-error' : '' }}">
                                <label class="lable" for="inputEmail4">Subject</label>
                                <select name="subject" class="form-control">
                                    @if(count($subjects)>0)
                                    @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->subject}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('subject'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('subject') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-8 {{ $errors->has('typeofpaper') ? ' has-error' : '' }}">
                                <label class="lable" for="inputPassword4">Type of Paper</label>
                                <select name="typeofpaper" class="form-control">
                                    @if(count($types)>0)
                                    @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->type}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('typeofpaper'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('typeofpaper') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 {{ $errors->has('academic') ? ' has-error' : '' }}">
                                <label class="lable" for="inputEmail4">Academic Level</label>
                                <select name="academic" class="form-control">
                                    @if(count($levels)>0)
                                    @foreach($levels as $level)
                                    <option value="{{$level->id}}">{{$level->level}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('academic'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('academic') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('language') ? ' has-error' : '' }}">
                                <label class="lable" for="inputPassword4">Language</label>
                                <select name="language" class="form-control">
                                    @if(count($languages)>0)
                                    @foreach($languages as $language)
                                    <option value="{{$language->id}}">{{$language->language}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('language'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('language') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('style') ? ' has-error' : '' }}">
                                <label class="lable" for="inputPassword4">Format</label>
                                <select name="style" class="form-control">
                                    @if(count($styles)>0)
                                    @foreach($styles as $style)
                                    <option value="{{$style->id}}">{{$style->style}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('styles'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('style') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 {{ $errors->has('pages') ? ' has-error' : '' }}">
                                <label class="lable" for="inputEmail4">Pages</label>
                                <input type="number" name="pages" required="true"  value="{{ old('pages') }}"  class="form-control" style="border: 1px solid rgba(0, 0, 0, 0.2);" min="0" id="inputAddress2" placeholder="No. of pages">
                                @if ($errors->has('pages'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('pages') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('sources') ? ' has-error' : '' }}">
                                <label class="lable" for="inputPassword4">Sources</label>
                                <input type="number" class="form-control" style="border: 1px solid rgba(0, 0, 0, 0.2);" value="{{ old('sources') }}" min="0" name="sources" required="true"  id="inputAddress2" placeholder="No. of citations ">
                                @if ($errors->has('sources'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('sources') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 {{ $errors->has('deadline') ? ' has-error' : '' }}">
                                <label class="lable" for="inputPassword4">Deadline</label>
                                <input id="datetimepicker"  value="{{ old('deadline') }}"  onclick="calculateTime()" name="deadline" required="true" class="form-control" style="border: 1px solid rgba(0, 0, 0, 0.2);" placeholder="Set deadline " type="text" >
                                @if ($errors->has('deadline'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('deadline') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 {{ $errors->has('budget') ? ' has-error' : '' }}">
                                <label class="lable" for="inputEmail4">Budget</label>
                                <select name="budget" class="form-control" required="true">
                                    @if(count($budgets)>0)
                                    @foreach($budgets as $budget)
                                    <option value="{{$budget->amount}}">$ {{$budget->amount}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('budget'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('budget') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group {{ $errors->has('instructions') ? ' has-error' : '' }}">
                                <label class="lable" for="inputEmail4">Paper Instructions</label>
                                <textarea name="instructions" {{ old('instructions') }} placeholder="Type/paste your instructions here. Upload files once you submit order"></textarea>
                            </div>
                            @if ($errors->has('instructions'))
                            <span class="help-block">
                                <strong>{{ $errors->first('instructions') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group row">
                            <label class="lable" for="inputEmail4">Files & Materials</label>
                            <div class="col-md-9 ad_materials_wrapper" id="files_div">
                                <div class="file_wrapper"><br>
                                    <button class="btn btn_main" id="add_file" data-toggle="tooltip">Add</button>
                                </div>                                     
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label class="lable" for="inputAddress">Your E-mail Address</label>
                                <input type="text" class="form-control" style="border: 1px solid rgba(0, 0, 0, 0.2);" name="email" id="inputAddress" required="true" placeholder="Your email addresss">
                            </div>
                        </div><br>
                        <div class="form-group">
                            <label class="lable" for="category" class="col-md-3 control-label">Additional Services</label>
                            <div class="col-md-9 as_checkbox_wrapper">
                                <label class="lable" for="plagiarism">
                                    <div class="as_checkbox">
                                        <div class="as_input">
                                            <input type="checkbox" id="plagiarism" name="plagiarism" value="0">
                                        </div>
                                        <div class="as_body">
                                            <div class="as_header">
                                                <span class="as_title">Plagiarism Report</span>
                                                <span class="as_price">$0.00</span>
                                            </div>
                                            <div class="as_desc">
                                                <p>96.9% of user consider this service to be useful</p> 
                                            </div> 
                                        </div>
                                    </div>
                                </label>
                                <label class="lable" for="priority">
                                    <div class="as_checkbox">
                                        <div class="as_input">
                                            <input type="checkbox" id="priority" name="priority" value="10">
                                        </div>
                                        <div class="as_body">
                                            <div class="as_header">
                                                <span class="as_title">Make my Order High Priority</span>
                                                <span class="as_price">$10.00</span>
                                            </div>
                                            <div class="as_desc">
                                                <p>90.9% of user consider this service to be useful</p> 
                                            </div> 
                                        </div>
                                    </div>
                                </label>
                                <label class="lable" for="sources">
                                    <div class="as_checkbox">
                                        <div class="as_input">
                                            <input type="checkbox" id="sources" name="copysources" value="10">
                                        </div>
                                        <div class="as_body">
                                            <div class="as_header">
                                                <span class="as_title">Copy of Sources</span>
                                                <span class="as_price">$10.00</span>
                                            </div>
                                            <div class="as_desc">
                                                <p>89.9% of user consider this service to be useful</p> 
                                            </div> 
                                        </div>
                                    </div>
                                </label>
                                <label class="lable" for="grammarly">
                                    <div class="as_checkbox">
                                        <div class="as_input">
                                            <input type="checkbox" id="grammarly" name="grammarly" value="0">
                                        </div>
                                        <div class="as_body">
                                            <div class="as_header">
                                                <span class="as_title">Grammarly Report</span>
                                                <span class="as_price">$0.00</span>
                                            </div> 
                                            <div class="as_desc">
                                                <p>95.9% of user consider this service to be useful</p> 
                                            </div> 
                                        </div>
                                    </div>
                                </label>
                                <div class="checkout">
                                    <div class="checkout_info">
                                        <div class="services_info" id="serv_summary"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn_main">Submit Order</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="advantages__itemq">
                <div class="advantages__description">
                    <h2 style="font-size:22px">Free Services</h2>
                    <p>Draft Papers</p>
                    <p>Plagiarism Report</p>
                    <p>Grammarly Report</p>
                    <p>Bibliography /References</p>
                    <p>Title Page & Format</p>
                    <p>Table of Contents</p>
                    <P>Revisions on Request</P> 
                    <p>Links to Sources</p>
                    <p>24/7 Instant Chat</p>
                </div>
             </div>
            <div class="advantages__itemq">
                <div class="advantages__description">
                    <h2 style="font-size:20px">Money-Back Guarantee</h2>
                    <p>What you order is what you get! If not, you get a refund as stated in this <a href="/refund-policy" target="_blank">Refund Policy.</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
    	$("#files_div").append('<div class="row1"><div><label class="label label-info" class="btn">Select File... <input type="file" name="orderfiles[]" onchange="$(\'#upload-file-info'+f_index+'\').html(this.files[0].name)"></label><button class="btn" onclick="remove_file(this)">Remove</button></div></div>');
    }
    function remove_file(ele) {
    	$(ele).parent().remove();
    	return;
    }
</script>
<script src="/writemypaperforme/asset/timepicker/jquery.js"></script>
<script src="/writemypaperforme/asset/timepicker/jquery.datetimepicker.js"></script>
<script>
    jQuery('#datetimepicker').datetimepicker({
        format: 'm-d-Y H:i',
        minDate: 0
    });
</script>
@endsection