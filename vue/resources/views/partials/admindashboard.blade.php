@php
$tutor=App\Wallet::where('user_id',Auth::user()->id)->first();
$accbal=App\Credit::where('id',1)->first();
$orders=App\Order::where('status',1)->where('is_deleted',0)->get();
$completed=App\Order::where('status',5)->where('is_deleted',0)->get();
$totalpaid=App\Order::where('amount', '>', 0)->sum('amount');
$first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
$last_day_this_month  = date('Y-m-t');
$sumbymonth=App\Order::whereBetween('created_at', [$first_day_this_month, $last_day_this_month])->where('amount', '>', 0)->sum('amount');
$arecent=App\Order::orderBy('created_at','DESC')->take(10)->get();  
function secondsToTime($seconds) {
$dtF = new \DateTime('@0');
$dtT = new \DateTime("@$seconds");
return $dtF->diff($dtT)->format('%ad %hh %imins ');
}
@endphp

<div class="row">
    <div class="col-12">
        <div class="d-flex">
            <h3>Dashboard</h3>
            <div class="breadcrumb m-0">
               <a href="javascript: void(0);">{{ date('m-d-Y') }}</a>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h3>Welcome, {{ ucfirst(auth::user()->name) }}</h3>
            </div>
            <img class="avatr" src="{{ URL::asset('vue/public/assets/images/avatars/'.Auth::user()->avatar)}}" alt="icon">
            <div class="card-body">
                 @php
                    $userrating=App\Rating::where('user_id',Auth::user()->id)->first();
                    $scores=$userrating->score;
                    $reviews=$userrating->reviews;							
                    if($reviews==0){
                          $meanscore=0;
                    }
                    else {
                        $meanscore=$scores/$reviews;	
                    }
                @endphp
                <p>Average Rating: <span class="badge badge-warning"> {{round( $meanscore,2) }}</span></p>
                <p><a href="{{ url('/view/profile') }}" class="btn btn-primary">View Profile </a></p>
            </div>
        </div><br>
    
        <div class="card">
            <div class="card-body">
                <h3>Earnings this Month</h3>
                <div><h3 class="badge badge-warning">${{ $sumbymonth }}</h3></div>
                <div><a href="{{ url('financial-analysis') }}" class="btn btn-primary">View Analysis </a></div>
            </div>
        </div><br>
        
        <div class="card">
            <div class="card-body">
                <h3>Upload Image</h3>
                <form action="upload.php" method="post" enctype="multipart/form-data">Select image:
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" value="Upload Image" name="submit">
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-xl-8">
        <div class="row">
            <div class="col-md-4">
                <a href="{{ url('available-orders') }}">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body"><h3>Available</h3></div>
                            <div><h3 class="badge badge-warning">{{ count($orders) }}</h3></div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ url('completed-orders') }}">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body"><h3>Completed</h3></div>
                            <div><h3 class="badge badge-warning">{{ count($completed) }}</h3></div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ url('financial-transactions') }}">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body"><h3>Revenue</h3></div>
                            <div><h3 class="badge badge-warning"> ${{$totalpaid}}</h3></div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <!-- end row -->
      @include('partials.recentorder')
    </div>
</div>
<!-- end row -->