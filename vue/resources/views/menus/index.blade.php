@extends('layouts.app')
@section('title')
 Menus
@endsection

@section('content')
<div class="row">
  <div class="col-12">
      <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0 font-size-18">Menus</h4>

          <div class="page-title-right">
              <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Add Menu</a></li>
          
              </ol>
          </div>

      </div>
  </div>
</div>

<div class="col-lg-6">
  <div class="card">
      <div class="card-body">

          <h4 class="card-title">Menu</h4>
         

          <div id="accordion">
           @include('partials.menu')
           
          </div>

      </div>
  </div>
</div>
@stop