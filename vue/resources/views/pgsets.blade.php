<div class="" id="paypalpg">
    <div class="text-center"><img src="/images/paypal-logo.png" height="60px" width="120px"/></div>
    <form method="post" action="{{URL::to('/set-pg')}}" role="form" >
        {{ csrf_field() }}
        
        <input type="hidden" value="1" name="pg"/>
            <div class="form-group col">
                <label class="">Client ID</label>
        <input type="text" name="clientid" value="{{ old('clientid') }}" class="form-control"/>
                @if ($errors->has('clientid'))
                <span class="help-block">
                    <strong>{{ $errors->first('clientid') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group col">
                <label class="">Client Secret</label>
        <input type="text" name="clientsecret" value="{{ old('clientsecret') }}" class="form-control"/>
                @if ($errors->has('clientsecret'))
                <span class="help-block">
                    <strong>{{ $errors->first('clientsecret') }}</strong>
                </span>
                @endif
            </div>					
            <input type="submit" value="Save " class="btn btn-success  btn-success"/>
            
    
    </form>
</div>
<div class="" id="flutter">
    <div class="text-center"><img src="/images/flutterwave.jpg" height="80px" width="120px"/></div>
    <form method="post" action="{{URL::to('/set-pg')}}" role="form" >
        {{ csrf_field() }}
        
        <input type="hidden" value="3" name="pg"/>
            <div class="form-group col">
                <label class="">Public Key
                </label>
        <input type="text" name="clientid" value="{{ old('clientid') }}" class="form-control"/>
                @if ($errors->has('clientid'))
                <span class="help-block">
                    <strong>{{ $errors->first('clientid') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group col">
                <label class="">Secret Key</label>
        <input type="text" name="clientsecret" value="{{ old('clientsecret') }}" class="form-control"/>
                @if ($errors->has('clientsecret'))
                <span class="help-block">
                    <strong>{{ $errors->first('clientsecret') }}</strong>
                </span>
                @endif
            </div>					
            <input type="submit" value="Save " class="btn btn-success  btn-success"/>
            
    
    </form>
</div>
<div class="" id="pgpesa">
    <div class="text-center"><img src="/images/pesapal_logo.png" height="80px" width="120px"/></div>
    <form method="post" action="{{URL::to('/set-pg')}}" role="form" >
        {{ csrf_field() }}
        
        <input type="hidden" value="2" name="pg"/>
            <div class="form-group col">
                <label class="">PesaPal Consumer Key
                </label>
        <input type="text" name="clientid" value="{{ old('clientid') }}" class="form-control"/>
                @if ($errors->has('clientid'))
                <span class="help-block">
                    <strong>{{ $errors->first('clientid') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group col">
                <label class="">PesaPal Consumer Secret</label>
        <input type="text" name="clientsecret" value="{{ old('clientsecret') }}" class="form-control"/>
                @if ($errors->has('clientsecret'))
                <span class="help-block">
                    <strong>{{ $errors->first('clientsecret') }}</strong>
                </span>
                @endif
            </div>					
            <input type="submit" value="Save " class="btn btn-success  btn-success"/>
            
    
    </form>
</div>