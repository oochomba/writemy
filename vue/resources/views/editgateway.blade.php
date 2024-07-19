@extends('layouts.app')

@section('title','System Settings')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Order Budgets</h4>
            </div>
            <div class="card-body">
                @if($setpg->pg_id==1)
                <div class="">
                    <div class="text-center"><img src="/images/paypal-logo.png" height="60px" width="120px" /></div>
                    <form method="post" action="{{ URL::to('/update-pg') }}" role="form">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $setpg->id }}" name="pgid" />
                        <input type="hidden" value="1" name="pg" />
                        <div class="form-group col">
                            <label class="">Client ID</label>
                            <input type="text" name="clientid" value="{{ $setpg->pgclient }}"
                                class="form-control" />
                            @if($errors->has('clientid'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('clientid') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group col">
                            <label class="">Client Secret</label>
                            <input type="text" name="clientsecret" value="{{ $setpg->pgsecret}}"
                                class="form-control" />
                            @if($errors->has('clientsecret'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('clientsecret') }}</strong>
                                </span>
                            @endif
                        </div>
                        <input type="submit" value="Save " class="btn btn-success  btn-success" />


                    </form>
                </div>
                @endif
                @if($setpg->pg_id==3)
                <div class="" >
                    <div class="text-center"><img src="/images/flutterwave.jpg" height="80px" width="120px" /></div>
                    <form method="post" action="{{ URL::to('/update-pg') }}" role="form">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $setpg->id }}" name="pgid" />
                        <input type="hidden" value="3" name="pg" />
                        <div class="form-group col">
                            <label class="">Public Key
                            </label>
                            <input type="text" name="clientid" value="{{ $setpg->pgclient }}"
                                class="form-control" />
                            @if($errors->has('clientid'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('clientid') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group col">
                            <label class="">Secret Key</label>
                            <input type="text" name="clientsecret" value="{{ $setpg->pgsecret}}"
                                class="form-control" />
                            @if($errors->has('clientsecret'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('clientsecret') }}</strong>
                                </span>
                            @endif
                        </div>
                        <input type="submit" value="Save " class="btn btn-success  btn-success" />


                    </form>
                </div>
                @endif
                @if($setpg->pg_id==2)
                <div class="" >
                    <div class="text-center"><img src="/images/pesapal_logo.png" height="80px" width="120px" /></div>
                    <form method="post" action="{{ URL::to('/update-pg') }}" role="form">
                        {{ csrf_field() }}

                        <input type="hidden" value="{{ $setpg->id }}" name="pgid" />
                        <input type="hidden" value="2" name="pg" />
                        <div class="form-group col">
                            <label class="">PesaPal Consumer Key
                            </label>
                            <input type="text" name="clientid" value="{{ $setpg->pgclient }}"
                                class="form-control" />
                            @if($errors->has('clientid'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('clientid') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group col">
                            <label class="">PesaPal Consumer Secret</label>
                            <input type="text" name="clientsecret" value="{{ $setpg->pgsecret}}"
                                class="form-control" />
                            @if($errors->has('clientsecret'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('clientsecret') }}</strong>
                                </span>
                            @endif
                        </div>
                        <input type="submit" value="Save " class="btn btn-success  btn-success" />
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
