<div class="table-responsive">
    <table class="table ">
        <tbody>
            <tr>
                <th scope="row" style="width: 250px;">Order ID :</th>
                <td>{{$order->id}}</td>
            </tr>
            <tr>
                <th scope="row">Status :</th>
                <td>
                    <p class="text-muted mb-0">@if($order->status==1)
                        <span class="quickview"> <span class="badge badge-pill badge-info">Bidding</span></span>
                        @elseif($order->status==2)
                        <span class="quickview"> <span class="badge badge-pill badge-warning">Assigned</span></span>
                        @elseif($order->status==3)
                        <span class="quickview"> <span class="badge badge-pill badge-primary">Editing</span></span>
                        @elseif($order->status==4)
                        <span class="quickview"> <span class="badge badge-pill badge-secondary">Revision</span></span>
                        @elseif($order->status==5)
                        <span class="quickview"> <span class="badge badge-pill badge-success">Completed</span></span>
                        @else
                        <span class="quickview"> <span class="badge badge-pill badge-danger">Cancelled</span></span>
                        @endif
                    </p>
                </td>
            </tr>
            <tr>
                <th>Order Budget :</th>
                <td>$ {{$order->budget}}</td>
            </tr>
            <tr>
                <th scope="row">Amount Paid :</th>
                <td>$ {{$order->amount}}</td>
            </tr>
         
            <tr>
                <th scope="row">Pages :</th>
                <td><span class="badge badge-pill badge-info">{{$order->pages}}</span></td>
            </tr>
            <tr>
                <th scope="row">Sources :</th>
                <td><span class="badge badge-pill badge-info">{{$order->sources}}</span></td>
            </tr> 
            <tr>
                <th scope="row">Timer :</th>
                <td nowrap="true">
                    <p class="text-muted mb-0">
                        <span>
                            @if(strtotime($str)>$t) <b style="color: #23AF00">{{secondsToTime($timestamp)}}</b>
                            @else<b style="color: #FF0000"> {{secondsToTime($timestamp)}}</b>
                            @endif
                        </span>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row">Date Created :</th>
                <td>{{$order->created_at->format('m-d-Y, H:i A')}}</td>
            </tr>
            <tr>
                <th>Client :</th>
                <td><a href="{{ url('/profile',$client->id) }}">{{ucfirst($client->name)}}</a></td>
            </tr>
        </tbody>
    </table>
</div>