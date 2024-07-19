@extends('layouts.frontend')
@section('title')
Checkout Invoice
@endsection
@section('content')
@php
    $fcheck=App\Pgsetting::where('pg_id',3)->first();
@endphp

<section class="welcome-page sec-padding pb-150px p-relative o-hidden bg-gray h-auto">
    <div class="container">
        <br />
        <br />
        <div class="bg-white table-responsive">
            <h4 class="text-center">Your Order Invoice</h4>
            <table class="table ">

                <thead>
                    <tr>

                        <th class="card-name">Order Title</th>
                        <th class="anuual-fees">Price</th>

                        <th class="action"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span class="text-dark compare-card-title">
                                {{ $title }}</span>

                                <br/>
                                <br><small>Select How to Pay</small>
                            <div class="mt10"><a class="btn1  btn-secondary btn-sm colorwhite" id="example-one"
                                    data-text-swap="Hide Details" data-text-original="Expand Details"
                                    data-toggle="collapse" href="#collapseExample" aria-expanded="false"
                                    aria-controls="collapseExample"> Click To Pay ${{ $amount }}</a></div>
                            <br />
                            <div class="collapse expandable-collapse" id="collapseExample">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                        <div class="card border-0">
                                            <div class="card-body">
                                                <h4 class="mb20">Pay With PayPal</h4>
                                                <div>
                                                    <img src="/images/paypal-logo.png" style="height: 50px"
                                                        class="img img-responsive" />
                                                </div>
                                                <br />
                                                <form method="post"
                                                    action="{{ URL::to('/pay-invoice') }}"
                                                    role="form" class="form-horizontal ">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" value="{{ $id }}" name="invid" />
                                                    <button type="submit" class="btn1 btn-secondary btn-sm mb5">
                                                         PayPal ${{ $amount }}</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                        <div class="card border-0">
                                            <div class="card-body">
                                                <h4 class="mb20">Pay with FlutterWave</h4>
                                                <div>
                                                    <img src="/images/flutterwave.jpg" style="height: 50px"
                                                        class="img img-responsive" />
                                                </div>
                                                <br />
                                                <br />
                                                <br />
                                                @if($fcheck->active)

                                                    <div class="float-right"><img src="/images/credit-cards.png"
                                                            height="50px" width="180px" /></div>
                                                    <form>
                                                        <script
                                                            src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js">
                                                        </script>

                                                        <div>
                                                            <br />
                                                            <br />
                                                            <br />
                                                            <button type="button" onClick="payOrderRave()"
                                                                class="btn1 btn-secondary btn-sm mb5">Card (${{ $amount }})</button>


                                                        </div>
                                                    </form>


                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                        <div class="card border-0">
                                            <div class="card-body">
                                                <h4 class="mb20">Pay with PesaPal</h4>
                                                <div>
                                                    <img src="/images/pesapal_logo.png" style="height: 50px"
                                                        class="img img-responsive" />
                                                </div>
                                                <br />
                                                <form method="post"
                                                action="{{ URL::to('/pesapal-invoice') }}"
                                                role="form" class="form-horizontal ">
                                                {{ csrf_field() }}
                                                <input type="hidden" value="{{ $id }}" name="invid" />
                                                <button type="submit" class="btn1 btn-secondary btn-sm mb5">
                                                     PesaPal ${{ $amount }}</button>
                                            </form>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </td>
                        <td class="text-dark text-bold">${{ $amount }}</td>

                       
                    </tr>
                </tbody>
            </table>
        </div>
        <br />
        <br />
    </div>
</section>
@php
    $flutterkey=App\Pgsetting::where('pg_id',3)->first();
@endphp
<script>
    function payOrderRave() {
        var otuitle = "Paying Invoice";
        const API_publicKey = "<?php echo($flutterkey->pgclient);?>";
        var rand = "{{ $id }}";
        var amount = "{{ $amount }}";
        var email = "{{ $email }}";
        var x = getpaidSetup({
            PBFPubKey: API_publicKey,
            customer_email: email,
            amount: amount,
            customer_phone: " ",
            currency: "USD",
            txref: rand,
            meta: [{
                metaname: "<?php echo($bids->question_id);?>",
                metavalue: rand
            }],
            onclose: function () {},
            callback: function (response) {
                var txref = response.tx.txRef;


                if (response.tx.chargeResponseCode == "00") {
                    window.location = "/invoice-paid-success/" + txref;
                } else {
                    window.location = "/payment-failed";
                }

                x.close(); // use this to close the modal immediately after payment.
            }
        });

    }

</script>
@stop
