<div class="" id="orderpaypalpg" class="text-center">
    <div class=""><img src="/svg/paypal-logo.png" height="40px" width="110px"/></div>

    <form method="post" action="{{URL::to('/pay-order-paypal')}}" role="form" class="form-horizontal ">
        {{ csrf_field() }} 
        <input type="hidden" name="bid" value="{{ $bids->id }}"/>        
        <div>
            <br/>
            <input type="submit" value="Continue to Safe Checkout (${{ $bids->price+$asum  }})" class="btn  btn-primary"/>
        </div>
    </form>
</div>