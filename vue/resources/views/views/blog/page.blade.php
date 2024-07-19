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
@section('fimage')
{{ $post->fimage }}
@endsection

@section('content')

<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [{
        "@type": "Question",
        "name": "{{ $post->faq}}",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "{{ $post->answera }}"
        }
      },{
        "@type": "Question",
        "name": "{{ $post->faqb}}",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "{{ $post->answerb}}"
        }
      },{
        "@type": "Question",
        "name": "{{ $post->faqc}}",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "{{ $post->answerc}}"
        }
      }]
    }
</script>

    <div class="top-background right-bird">
        <div class="row acolor">
            <h1>{{ ucfirst($post->title) }}</h1>
            <div class="col-lg-8 "> 
                <div class="micro">{{ $post->keyphrase }}</div>
                <div class="microdescription">{{ $post->metadescription }}</div>
                <div class="features">
                    <div class="feature"><img src="/svg/plag.webp" alt="plag" width="30" height="30">No Plagiarism</div>
                    <div class="feature"><img src="/svg/gpt.webp" alt="ai" width="30" height="30">No AI Content</div>
                    <div class="feature"><img src="/svg/cheap.webp" alt="price" width="30" height="30">Affordable</div>
                </div> 
            </div>
            <div class="col-lg-4">
                <div class="featimage">
                    <img src="/postsimages/{{$post->fimage}}" width="740" height="356" alt="featimage">
                </div>
            </div>
        </div>
    </div>
    <div class="blog">
        <div class="row blogfaq">
            <div class="faqhead"><a class="btn_main">Frequently Asked Questions</a></div>
            <div class="accordion">{{ $post->faq}}</div>
            <div class="panel"><p>{{ $post->answera }}</p></div>
            <div class="accordion">{{ $post->faqb}}</div>
            <div class="panel"><p>{{ $post->answerb}}</p></div>
            <div class="accordion">{{ $post->faqc}}</div>
            <div class="panel"><p>{{ $post->answerc}}</p></div>
        </div>
    </div>
    <div class="blog">
        <div class="row blog-body">
            <h2>{{ ucfirst($post->title) }}</h2>
            <div class="blog-sec"> 
                <div class="cite d-none-mobile">
                    <div class="citea">
                        <p><b>By:</b>  <a href="/">WriteMyPaperforMe.org</a></p>
                        <p><b>Updated:</b>  {{$post->updated_at->format('F j, Y')}}</p>
                        <p><b>Category:</b>  {{ ($post->category) }}</p> 
                    </div>
                </div>
                <div class="blogcont fmage">
                    <img class="fimage" src="/postsimages/{{$post->fimage}}" width="732" height="400" alt="Featured-Image" loading="lazy">
                </div>
            </div>   
            <div class="blog-sec">
                <div class="blogcont">{!! $post->body!!}</div>
                <div class="sidebar contnr d-none-mobile" id="sidebar">
                    <div class="sidebarhd">Table of Contents</div>
                    <div id="tableOfContents"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="socialshare">
        <p class="share">Share this article on: 
            <a href="https://www.facebook.com/sharer/sharer.php?u=https://writemypaperforme.org/{{$post->slug}}" target="_blank"><img src="/svg/fb.svg" alt="Fb" width="30" height="30"></a>
            <a href="https://twitter.com/intent/tweet?url=https://writemypaperforme.org/{{$post->slug}}" target="_blank"><img src="/svg/twt.svg" alt="x" width="20" height="20"></a>
            <a href="https://www.linkedin.com/shareArticle?url=https://writemypaperforme.org/{{$post->slug}}" target="_blank"><img src="/svg/linkedin.svg" alt="lnk" width="30" height="30"></a>
        </p>
    </div>
    <div class="section-cost">
        <div class="cost__title">No AI Generated Content, No Plagiarism – Original Papers!</div>
        <div class="row items">
            <div class="items_item">
                <img src="/postsimages/place.webp" alt="plag" class="items_img" loading="lazy">
                <div class="items_title"><div class="icon">1.</div>Place Your Order </div>
                <p>Submit your paper instructions. Click “Place Your Order” - fill in all the details and submit.</p>
            </div>
            <div class="items_item">
                <img src="/postsimages/assign.webp" alt="plag" class="items_img" loading="lazy">
                <div class="items_title"><div class="icon">2.</div>Assign to a Writer</div>
                <p>Go to your Order, check the Bids from available writers. See their reviews and assign to any.</p>
            </div>
            <div class="items_item">
                <img src="/postsimages/solution.webp" alt="plag" class="items_img" loading="lazy">
                <div class="items_title"><div class="icon">3.</div>Get Your Paper</div>
                <p>Go to your Order, check the Solutions. Download your paper, leave a review or feedback.</p>
            </div>
        </div>
        <p><a class="btn_main btn" href="/order">Place your order</a></p>
    </div> 
    <div class="section row">
        <h2>Related Articles</h2>
        <div class="items">
            @foreach($relatedPosts as $relatedPost)
            <div class="related">
                <img src="/postsimages/{{$relatedPost->fimage}}" class="rel_img" alt="Featured-Image" loading="lazy">
                <div class="items_title">
                    <a href="{{ url('/'. $relatedPost->slug) }}" target="_blank">{{ $relatedPost->title }}</a> 
                </div>
                <p>{{ $relatedPost->metadescription }}</p>
            </div>
             @endforeach
        </div><br><br><br>
        <a href="{{ url('/pages') }}" target="_blank" class="btn btn_main">Browse All</a>
    </div>
@stop