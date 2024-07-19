@extends('layouts.app')
@section('title','Dashboard')
@section('content')
@php

if(Auth::user()->role==3){
		$transactions=App\Opayment::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->take(5)->get();
		}elseif(Auth::user()->role==4){
		$transactions=App\Opayment::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->take(5)->get();
		}elseif(Auth::user()->role==2){
			$transactions=App\Opayment::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->take(5)->get();
		}else{
			$transactions=App\Opayment::orderBy('created_at','DESC')->take(5)->get();
		}
@endphp
@if(auth::user()->role==1)
@include('partials.admindashboard')
@include('partials.clients')

@elseif(auth::user()->role==4)
@include('partials.tutordash')
@elseif(auth::user()->role==3)
@include('partials.clientdash')
@elseif(auth::user()->role==2)
@include('partials.editordash')
@else
@endif

@include('partials.withdrawals')
@include('partials.transactions')
@endsection
