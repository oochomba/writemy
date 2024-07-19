@extends('layouts.app')

@section('title','Writers')
@section('content')

	  @if(Auth::user()->role==1)                 
@include('partials.writers')
@endif
@endsection