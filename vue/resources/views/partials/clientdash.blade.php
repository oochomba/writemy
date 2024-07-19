@php
$tutor=App\Wallet::where('user_id',Auth::user()->id)->first();
$accbal=App\Credit::where('id',1)->first();
$orders=App\Order::where('user_id',Auth::user()->id )->where('status',1)->where('is_deleted',0)->get();
$completed=App\Order::where('status',5)->where('user_id',auth::user()->id)->where('is_deleted',0)->get();
$first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
$last_day_this_month  = date('Y-m-t');
$arecent=App\Order::where('user_id',Auth::user()->id )->where('is_deleted',0)->orderBy('created_at','DESC')->take(5)->get();  
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
        <div class="card overflow-hidden">
            <div class="card-body">
                <img src="/postsimages/z.png" alt="icon" width="40%" align="center">
                <h3 class="text-primary">Welcome, {{ ucfirst(auth::user()->name) }}</h3>
                <br>
                <div class="row">
                    <p>Password, order details, and updates sent to: <a href>{{ ucfirst(auth::user()->email) }}</a></p>
                </div>
                <div class="row">
                    <p>"This is a private account registered to <a href>{{ ucfirst(auth::user()->name) }}</a>. Chat with your writer via WhatsApp or Message section of your Order</p>
                    <p>Thank You and Welcome Again"</p>
                </div>
                <div class="row">
                    <a href="{{ url('new-order') }}"class="btn_main">Place New Order</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="row">
            <div class="col-6">
                <a href="{{ url('available-orders') }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body"><h3>Bidding</h3></div>
                                <div><h3 class="badge badge-warning">{{ count($orders) }}</h3></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ url('completed-orders') }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body"><h3>Completed</h3></div>
                                <div><h3 class="badge badge-primary">{{ count($completed) }}</h3></div>
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