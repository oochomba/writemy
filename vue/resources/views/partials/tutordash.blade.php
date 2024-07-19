@php
$tutor=App\Wallet::where('user_id',Auth::user()->id)->first();
$accbal=App\Credit::where('id',1)->first();
$orders=App\Order::where('status',1)->where('is_deleted',0)->get();
$completed=App\Order::where('status',5)->where('is_deleted',0)->get();

$assorders =App\Order::where('status',2)->where('is_deleted',0)->count();

$first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
$last_day_this_month  = date('Y-m-t');
$sumbymonth=App\Opayment::whereBetween('created_at', [$first_day_this_month, $last_day_this_month])->where('type',1)->sum('amount');
$arecent=App\Order::where('tutor_id',Auth::user()->id )->where('is_deleted',0)->orderBy('created_at','DESC')->take(5)->get();  
function secondsToTime($seconds) {
$dtF = new \DateTime('@0');
$dtT = new \DateTime("@$seconds");
return $dtF->diff($dtT)->format('%ad %hh %imins ');
}
@endphp
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ date('m-d-Y') }}</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-soft-primary">
                <div class="row">
                    <div class="col-12">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">Welcome, {{ ucfirst(auth::user()->name) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img alt="" class="img-thumbnail" src="{{ URL::asset('vue/public/assets/images/avatars/'.Auth::user()->avatar)}}" alt="">
                        </div>
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
                    </div>
                    <div class="col-sm-8">
                        <div class="pt-4">
                           <div class="row"> 
                                <div class="col-7">
                                    <h5 class="font-size-15"><span class="badge badge-warning font-size-12"><i class="mdi mdi-star mr-1"></i>{{round( $meanscore,2) }}</span></h5>
                                    <p class="text-muted mb-0"><b>{{ $reviews }}</b> Reviews</p>
                                </div>                              
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="mt-4">
                        <a href="{{ url('/view/profile') }}" class="btn btn-primary waves-effect waves-light btn-sm">View Profile <i class="mdi mdi-arrow-right ml-1"></i></a>
                    </div>
                </div>
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
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">Bidding</p>
                                <h4 class="mb-0">{{ count($orders) }}</h4>
                            </div>
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                <span class="avatar-title">
                                    <i class="bx bx-copy-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <a href="{{ url('assigned-orders') }}">
                    <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">Assigned</p>
                                <h4 class="mb-0">{{ count($assorders) }}</h4>
                            </div>

                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-archive-in font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
        <!-- end row -->

      @include('partials.recentorder')
    </div>
</div>
<!-- end row -->
 

