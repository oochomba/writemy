@extends('layouts.frontend')
@section('canonical','blog')
@section('title')
Blog | Academic Resources and Writing Guides
@endsection

@section('content')

<div class="front-page-wrapper">
    <div class="section">
        <div class="row">
            @if($posts->where('type', 1)->count() > 0)
                <h2>Academic Resources and Writing Guides</h2><br>
                <form action="{{ url('pages') }}" method="GET" id="search-form">
                    <div class="input-grp">
                        <input type="text" name="search" id="search-input" placeholder="Search articles, guides..." value="{{ request('search') }}">
                        <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" height="24" viewBox="0 0 24 24" width="24" focusable="false"><path clip-rule="evenodd" d="M16.296 16.996a8 8 0 11.707-.708l3.909 3.91-.707.707-3.909-3.909ZM18 11a7 7 0 11-14 0 7 7 0 0114 0Z" fill-rule="evenodd"></path></svg></button>
                        <button type="button" class="btn-clear" id="clear-search" style="display:none; height:33px;">✖</button>
                    </div>
                    <div class="columns" style="padding:30px;border-radius:10px;">
                        @foreach($posts as $post)
                        <div class="blog-item">
                            <h3><a href="/{{ $post->slug }}" target="_blank">{{ $post->title }}</a></h3>
                            <p>{!! substr(strip_tags($post->body), 0, 150) !!}</p>
                            <p><b>Updated on:</b> {{ $post->created_at->format('d M Y') }}</p>
                        </div>
                        @endforeach
                    </div>
                </form>
            @elseif($posts->where('type', 2)->count() > 0) 
                <h2>Question Bank</h2><br>
                <form action="{{ url('blog') }}" method="GET" id="search-form">
                    <div class="input-grp">
                        <input type="text" name="search" id="search-input" placeholder="Search sample questions..." value="{{ request('search') }}">
                        <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" height="24" viewBox="0 0 24 24" width="24" focusable="false"><path clip-rule="evenodd" d="M16.296 16.996a8 8 0 11.707-.708l3.909 3.91-.707.707-3.909-3.909ZM18 11a7 7 0 11-14 0 7 7 0 0114 0Z" fill-rule="evenodd"></path></svg></button>
                        <button type="button" class="btn btn-clear" id="clear-search" style="display: none;height:33px;">✖</button>
                    </div>
                    <div class="columns" style="padding:30px;border-radius:10px;">
                        @foreach($posts as $post)
                        <div class="blog-item">
                            <h3><a href="/{{ $post->slug }}" target="_blank">{{ $post->title }}</a></h3>
                            <p>{!! substr(strip_tags($post->body), 0, 150) !!}</p>
                            <p><b>Updated on:</b> {{ $post->created_at->format('d M Y') }}</p>
                        </div>
                        @endforeach
                    </div>
                </form>
            @else
            <h3>"Oops! The search party came back empty-handed."</h3><br>
                <button onclick="goBack()">Go Back</button>
            @endif
            {!!$posts->links('pagination::bootstrap-4')!!}
        </div>
    </div>
</div>  
<script>
    function goBack() {
        window.history.back();
    }
</script>
@stop