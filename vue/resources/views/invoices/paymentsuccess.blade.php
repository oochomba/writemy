@extends('layouts.frontend')
@section('title')
Payment Success
@endsection
@section('content')

<br><br>


    <div class="section row">
        <div class="col-sm-12 ">
            <h2>Payment Successful</h2>
            <img src="/svg/paypal-logo.png" class="img-responsive" style="height:97px; width:250px">
            <p style="font-size:20px;color:#5C5C5C;">Thank you for the Payment. Your order is now in progress. </p>
            <a href="/login" class="btn_main btn">Log In</a>
        </div>
    </div>
 
@stop