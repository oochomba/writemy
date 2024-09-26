@if(count($bids)>0)
@foreach ($bids as $bid)
@php
$uname=App\User::findOrFail($bid->user_id);
$userrating=App\Rating::where('user_id',$bid->user_id)->first();
$scores=$userrating->score;
$reviews=$userrating->reviews;	
@endphp

<div class="bid">
    <div class="row">
        <div class="col-sm-4">
            <div class="mt-4">
                <p>Order Completed: <b>{{ $uname->awarded }}</b></p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mt-4">
                <p>Students Served: <b>{{ $uname->students_helped }}</b></p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mt-4">
                <p>Current Rating: <b>   
                @php
                    $userrating=App\Rating::where('user_id',$bid->user_id)->first();
                    $scores=$userrating->score;
                    $reviews=$userrating->reviews;								
                    if($reviews==0){
                        $meanscore=0;
                    }
                    else {
                        $meanscore=$scores/$reviews;	
                    }
                    @endphp
                    <span class="badge badge-success font-size-14"><i class="mdi mdi-star mr-1"></i>{{round( $meanscore,2) }}/5</span></b></p>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <h4><a href="{{ url('/profile',$bid->user_id) }}">
                {{ucfirst($uname->name)}}</a></h4>
            <img alt="" class="rounded-circle avatar-sm" src="{{ URL::asset('vue/public/assets/images/avatars/'.$uname->avatar)}}">
            <small>Expert Writer</small>
        </div>
        <div class="col-md-4">
            <p class="bidcmnt">{!!$bid->text!!}</p>
        </div>
        <div class="col-md-4" style="text-align:center;">
            <p class="text-muted  mr-3">
                @if($newwriter==1)
                <h4>No rating</h4>
                @else
                @if(round($meanscore, 2)>=5)
                <span class="text-warning"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
                @elseif(round($meanscore, 2)>=4.5&& round($meanscore, 2)<=4.9)
                <span class="text-warning"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="far fa-star"></i></span>
                @elseif(round($meanscore, 2)>=4&& round($meanscore, 2)<=4.5)
                <span class="text-warning"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
                @else
                <span class="text-warning"><i class="far fa-star"></i></span>
                @endif
                @endif
            </p>
            <p class="text-muted mb-4"><a href="{{ url('/profile',$bid->user_id) }}">See Reviews</a></p>
            @if($order->status==1)
                <a href="{{ url('/checkout-invoice',$bid->invoicehash) }}" class="btn btn-success">Assign: <b> $ {{ $bid->price+$asum }}</b>  </a>
            @endif
            
            @if($mybid=="")
            @if($mybid == "" && Auth::user()->id == $bid->user_id)
            @if((Auth::user()->role == "1" || Auth::user()->role == "4") && $order->status == 1)
            <a data-toggle="modal" data-target="#editBid" class="btn btn-danger">Edit</a>
            @endif
            <div id="editBid" class="modal" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header"><h4 class="modal-title">Edit</h4></div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" method="post" action="{{ url('/edit-bid') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="bid" value="{{ $bid->id ?? '' }}"/> 
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"/>
                                <input type="hidden" name="question_id" value="{{ $order->id }}"/>
                                <div class="{{ $errors->has('price') ? ' has-error' : '' }}">
                                    <label for="price" class="lable">Amount</label>
                                    <input type="number" class="form-control" id="price" name="price" value="{{ $bid->price }}" required>
                                    @if ($errors->has('price'))
                                        <span class="help-block"><strong>{{ $errors->first('price') }}</strong></span>
                                    @endif
                                </div>
                                <div class="{{ $errors->has('text') ? ' has-error' : '' }}">
                                    <label for="text" class="lable">Message</label>
                                    <textarea class="form-control" id="text" name="text" rows="4" required>{{ $bid->text }}</textarea>
                                </div>
                                <button type="submit" value="Submit Bid" class="btn btn-success">Submit Bid</button>
                            </form>
                        </div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        @endif
        @endif            
        </div>
    </div>
</div>
<br><br>

@endforeach
@else 
<div>
    <br/>
    <br/>
    <br/>
    <p>Waiting for bids....</p>
</div>
@endif