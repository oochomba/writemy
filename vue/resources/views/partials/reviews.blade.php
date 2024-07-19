<div class="card">
    <div class="card-body">
        <h3>Top Reviews : {{count($ureviews)}}</h3><hr>
        @if(count($ureviews)>0)
            @foreach($ureviews as $ureview)
            @php
                $cname=App\User::where('id',$ureview->student_id)->first();
            @endphp
        <div class="row revi">
            <div class="col-sm-1">
                <img class="img" height="40px" width="40px" src="/postsimages/z.png" alt="icon">
            </div>
            <div class="col-sm-2">
                <h4><a href="">{{ucfirst($cname->name)}}</a></h4>
                <span style="font-size:11px">{{$ureview->created_at->format('m-d-Y')}}</span>
            </div>
            <div class="col-sm-5">{{$ureview->review}}</div>
            <div class="col-sm-3">
                @if($ureview->recommend==1)
                    <span class="badge badge-pill badge-success">Yes, I recommend this writer</span>
                @else
                    <span class="badge badge-pill badge-danger">No, I recommend another writer</span>
                @endif
                <span>
                    @if($ureview->rating==5)
                        <div class="rating_star"><span class="rate_star"><span class="rstar" style="width:100%"></span></span></div>
                    @elseif($ureview->rating==4)
                        <div class="rating_star"><span class="rate_star"><span class="rstar" style="width:80%"></span></span></div>
                    @elseif($ureview->rating==3)
                        <div class="rating_star"><span class="rate_star"><span class="rstar" style="width:60%"></span></span></div>
                    @elseif($ureview->rating==2)
                        <div class="rating_star"><span class="rate_star"><span class="rstar" style="width:40%"></span></span></div>
                    @elseif($ureview->rating==1)						<div class="site-rating-block__stars">
                        <div class="rating_star"><span class="rate_star"><span class="rstar" style="width:20%"></span></span></div>
                    @else
                    @endif
                </span>
            </div>
        </div><hr>
        @endforeach
        @else
            <p>No reviews yet.</p>
        @endif
    </div>
</div>