<img alt="paypal" src="/paypal-logo-png-3.png" width="125px" height="40px;" class="img-responsive"/>
<form method="post" action="{{ url('/award-scholar') }}"  role="form" class="form-horizontal ">
    {{ csrf_field() }}

    <div class="col-md-3">

        <input  type="hidden" name="bidder" value=" {{$bid->id}}"/>

    </div>

    <br/>
    <button  type="submit"  class="btn btn-sm btn-warning" style="color: #000; font-weight: bold;">Buy Bid ($ {{$bid->price}}) </button>



</form>