@php
$setpg=App\Gateway::where('id',1)->first();
$ubal=App\Wallet::where('user_id',auth::user()->id)->first();
@endphp

@if($ubal->balance>=$bid->price)
@include('ubalance')
@else
@if($setpg->activepg==1)    
@include('pp')
@elseif($setpg->activepg==2)
@include('pesapal')
@elseif($setpg->activepg==3)
<div class="row">
    <div class="col-md-6">
        @include('pp')
    </div>
    <div class="col-md-6">
      
@include('pesapal')
    </div>
</div>
@else
Not Set
@endif
@endif