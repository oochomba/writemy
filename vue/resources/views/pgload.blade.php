<div class="" id="paypalpg">
   
    <form method="post" action="{{URL::to('/load-funds-viapaypal')}}" role="form" class="form-horizontal ">
        {{ csrf_field() }}
                                 
        <label for="language" class=" control-label"><strong>Amount To Load</strong></label>
        <input type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="amount" class="form-control" placeholder="Amount to Load " required="true"/>
                            
                    


        <div>
            <br/>
            <input type="submit" value="Continue Safe Checkout" class="btn  btn-warning"/>
        </div>
 </form>
 <div class="float-right"><img src="/images/paypal-logo.png" height="30px" width="70px"/></div>
</div>
<div class="" id="flutter">
    <div class="text-center"><img src="/images/flutterwave.jpg" height="80px" width="120px"/></div>
    <form>
        <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
       
        <input type="number" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Amount e.g 50" value="" class="form-control" name="amount" id="amount"/>
        <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
       
       
        <div>
            <br/>
            <button type="button" onClick="loadWithRave()" class="btn  btn-warning">Continue Safe Checkout</button>
        
           
        </div>
    </form>
    <div class="float-right"><img src="/images/credit-cards.png" height="50px" width="150px"/></div>
</div>
<div class="" id="pgpesa">
    <div class="text-center"><img src="/images/pesapal_logo.png" height="80px" width="120px"/></div>
    <form method="post" action="{{URL::to('/load-pesapal')}}" role="form" >
        {{ csrf_field() }}
        
        <label for="language" class=" control-label"><strong>Amount To Load</strong></label>
        <input type="number" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Amount e.g 50" value="" class="form-control" name="amount" id="amount"/>
      
        <br/>
          				
    <input type="submit" value="Continue Safe Checkout " class="btn btn-warning  btn-success"/>
            
    
    </form>
</div>

