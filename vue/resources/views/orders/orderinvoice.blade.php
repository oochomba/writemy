@extends('layouts.app')

@section('title','Order Invoice')

@section('content')
@php
    $order=App\Order::where('id',$bids->question_id)->first();
    $user=App\User::where('id',$order->user_id)->first();
    $asum=App\Additionalservice::where('order_id',$order->id)->sum('price');
    $aservices=App\Additionalservice::where('order_id',$order->id)->get();
@endphp

<style>
    table {border-collapse: collapse;}
    table, td, th {border: 1px solid black;padding: 5px;font-size:13px;}
    .text{font-weight:500;}b{font-weight:500;}
    .lable{line-height:1.5em; font-size: 16px;font-weight:500;}
</style>

<div class="row">
    <div class="col-lg-3 col-md-3"></div>
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-body"> 
                <div class="d-flex">
                    <h3><u>YOUR ORDER INVOICE</u></h3>
                    <div class="breadcrumb m-0"><a href="" class="float-right text">Order <b>#: {{ $bids->question_id }}</b></a></div>
                </div>
                <div><p>Billed To: <b> {{ $user->email }}</b></p></div>    
                <div><p>Date: <b> {{ $bids->created_at->format('F d, Y') }}</b></p></div>
                <div>
                    <table style="width:100%">
                        <thead >
                            <tr>
                                <th>No.</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>{{ $order->title }}</td>
                                <td class="text-right">${{ $bids->price }}</td>
                            </tr>
                            @if(count($aservices))
                            @foreach ($aservices as $key=> $service )
							<tr>
                                <td>{{ $key+2 }}</td>
								<td>{{ $service->service }}</td>
								<td class="text-right">$ {{ $service->price }}</td>						
							</tr>	
                            @endforeach
                            @endif
                            <tr>
                                <th colspan="2" class="text-right">TOTAL</th>
                                <th class="text-right">${{ $bids->price+$asum}}</th>
                            </tr>          
                        </tbody>
                    </table>
                </div>
                <br>
                @php
                $ubalance=App\Wallet::where('user_id',auth::user()->id)->first();
                @endphp
                @if ($ubalance->balance>=$bids->price+$sum )
                <p>The amount <b>(${{ $bids->price+$asum }})</b> will be deducted from your wallet <b>$ {{ $ubalance->balance }}</b></p>
                <div class="" id="">
                    <form method="post" action="{{URL::to('/pay-order-wallet')}}" role="form" class="form-horizontal ">
                        {{ csrf_field() }} 
                        <input type="hidden" name="bid" value="{{ $bids->id }}"/>        
                        <div>
                            <input type="submit" value="Continue to Checkout (${{ $bids->price+$asum }})" class="btn  btn-success"/>
                        </div>
                    </form>
                </div> 
                @else
                <p class="lable">Pay Via:</p>
                @php
                    $paypalactive=App\Pgsetting::where('pg_id',1)->first();
                    $pesaactive=App\Pgsetting::where('pg_id',2)->first();
                    $flutteractive=App\Pgsetting::where('pg_id',3)->first();
                @endphp
                <div class="float-left">
                    @include('orderinvoicecheckout')
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
