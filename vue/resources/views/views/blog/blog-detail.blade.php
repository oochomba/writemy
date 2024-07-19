@extends('layouts.frontend')
@section('canonical')
{{ $post->slug }} 
@endsection
@section('title')
{{ ucfirst($post->title  ) }}
@endsection
@section('description')
{{ $post->metadescription }}
@endsection
@section('keyphrase')
{{ $post->keyphrase }}
@endsection
@section('keywords')
{{ $post->keywords }}
@endsection

@section('content')

    <div class="top-background" style="text-align:center;">
        <span class="topinfo">This is a sample of <u>{{ $post->keyphrase }}</u> paper we have written.</span>
        <div class="row acolor">
            <h1 class="qtitle">{{ ucfirst($post->title) }}</h1>
            <div class="qdescription">{{ $post->metadescription }}</div>
        </div>
    </div>

    <div class="row">
        <div class="blog-body" style="margin-top:-20px;">
            <div class="blog-sec">
                <div class="blogcont">{!! $post->body!!}</div>
                <div class="sidebar contnr d-none-mobile" id="sidebar">
                    <div class="sidebarhd">Table of Contents</div>
                    <div id="tableOfContents"></div>
                </div>
            </div>
            <div class="blog-ans">
                <div class="ans-title">Get Your Custom Solution from Expert Writers!</div>
                <div class="cta-section">
                    <div class="cta-description">Have a question that needs a bespoke answer? Let our skilled writers craft the perfect paper for you.</div>
                    <div class="cta-steps">
                        <ol>
                            <li><strong>Place Your Order</strong>: Submit your question and requirements.</li>
                            <li><strong>Choose Your Writer</strong>: Select from our pool of expert writers.</li>
                            <li><strong>Receive Your Paper</strong>: Get a custom paper tailored to your needs.</li>
                        </ol>
                    </div>
                    <p class="btn"><a class="btn_main" href="/order">Place your order here</a></p>
                </div>
            </div>
        </div>
    <div class="section row">
        <h2>Related Questions</h2>
        <div class="quiz">
            @foreach($relatedPosts as $relatedPost)
            <p class="related-quiz">Q: <a href="{{ url('/'. $relatedPost->slug) }}" target="_blank">{{ $relatedPost->title }} : {{ $relatedPost->metadescription }}</a> </p>
            @endforeach
        </div><br><br><br>
        <a href="{{ url('/blog') }}" target="_blank" class="btn btn_main">Browse All</a>
    </div>
</div>
@stop