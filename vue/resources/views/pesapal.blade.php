<img alt="paypal" src="/paypal-credit-card-logo-png-8.png" width="175px" height="40px;" class="img-responsive"/>
<form method="post" action="{{URL::to('/order/checkout')}}" role="form" class="form-horizontal ">
    {{ csrf_field() }}
    <table>
        <input type="hidden"  oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="form-control"  name="amount" value="{{ $bid->price }}" />  
        <input type="hidden" name="type" value="MERCHANT" readonly="readonly" />
        <input type="hidden" name="description" value="{{$order->id}} | {{$order->title}}" />
        <input type="hidden" name="reference" value="{{$bid->id}}" />
        <input type="hidden" name="email" value="{{Auth::user()->email}}" />
        
    </table>
    <br/>
<input type="submit" class="btn btn-success btn-sm" value="Buy Bid (${{ $bid->price }})" />

</form>