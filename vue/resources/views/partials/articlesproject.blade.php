
        <div class="media">          
            <div class="media-body overflow-hidden">
                <h5 class="text-truncate font-size-15">{{$order->title}}</h5>
                   </div>
        </div>
        <h5 class="font-size-15 mt-4">Project Instructions:</h5>
        <p class="text-muted">{!!$order->instructions!!}</p>
        <hr/>
     
        <div class="row task-dates">
            <div class="col-sm-4 col-md-2 col-6">
                <div class="mt-4">
                    <h5 class="font-size-14"> Order #</h5>
                    <p class="text-muted mb-0">{{$order->id}}</p>
                </div>
            </div>

            <div class="col-sm-4 col-md-2 col-6">
                <div class="mt-4">
                    <h5 class="font-size-14"> Status</h5>
                    <p class="text-muted mb-0">@if($order->status==1)
                        <span class="quickview"> <span class="badge badge-pill badge-info">Bidding</span></span>
                        @elseif($order->status==2)
                        <span class="quickview"> <span class="badge badge-pill badge-warning">Assigned</span></span>
                        @elseif($order->status==3)
                        <span class="quickview"> <span class="badge badge-pill badge-primary">Editting</span></span>
                        @elseif($order->status==4)
                        <span class="quickview"> <span class="badge badge-pill badge-secondary">Revision</span></span>
                        @elseif($order->status==5)
                        <span class="quickview"> <span class="badge badge-pill badge-success">Completed</span></span>
                        
                            
                        @else
                        <span class="quickview"> <span class="badge badge-pill badge-danger">Cancelled</span></span>
                        @endif
                            </p>
                </div>
            </div>
            <div class="col-sm-4 col-md-2 col-6">
                <div class="mt-4">
                    <h5 class="font-size-14"> Order Budget</h5>
                    <p class="text-muted mb-0"> $ {{$order->budget}}</p>
                </div>
            </div>
            <div class="col-sm-4 col-md-2 col-6">
                <div class="mt-4">
                    <h5 class="font-size-14"> Amount Paid </h5>
                    <p class="text-muted mb-0">$ {{$order->amount}}</p>
                </div>
            </div>
            <div class="col-sm-4 col-md-2 col-6">
                <div class="mt-4">
                    <h5 class="font-size-14"> Writer Pay</h5>
                    <p class="text-muted mb-0">$ {{$order->writerpay}}</p>
                </div>
            </div>
            <div class="col-sm-4 col-md-2 col-6">
                <div class="mt-4">
                    <h5 class="font-size-14"> Words</h5>
                    <p class="text-muted mb-0"> <span class="badge badge-pill badge-info">{{$order->pricemin}}-{{ $order->pricemax}}</span></p>
                </div>
            </div>
        </div>
        <div class="row task-dates">
            <div class="col-sm-4 col-md-2 col-6">
                <div class="mt-4">
                    <h5 class="font-size-14"> Subject</h5>
                    <p class="text-muted mb-0">{{$subjects->subject}}</p>
                </div>
            </div>
            <div class="col-sm-4 col-md-2 col-6">
                <div class="mt-4">
                    <h5 class="font-size-14">Date Posted </h5>
                    <p class="text-muted mb-0">	<span class="quickview">{{$order->created_at->format('m-d-Y H:i A')}}</span></p>
                </div>
            </div>
            <div class="col-sm-4 col-md-3 col-6">
                <div class="mt-4">
                    <h5 class="font-size-14"> Client</h5>
                    <p class="text-muted mb-0">
                        <img class="rounded-circle avatar-sm" src="{{URL::asset('assets/images/users/avatar-2.jpg')}}" alt="">
           
                        <span class="quickview"> <a href="{{ url('/profile',$client->id) }}">{{ucfirst($client->name)}}</a> </span></p>
                </div>
            </div>
            @if($order->tutor_id!="")
            <div class="col-sm-4 col-md-3 col-6">
                <div class="mt-4">
                    <h5 class="font-size-14"> Tutor</h5>
                    <p class="text-muted mb-0">
                        <img class="rounded-circle avatar-sm" src="{{URL::asset('assets/images/users/avatar-1.jpg')}}" alt="">
           
                        <span class="quickview"> <a href="{{ url('/profile',$tutor->id) }}">{{ucfirst($tutor->name)}}</a> </span></p>
                </div>
            </div>
            @endif
          
           
          
        </div>
       
        <hr/>
        @include('partials.orderactions')
   
   