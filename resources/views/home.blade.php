@extends('layouts.app')

@section('content')
<div class="row mt-4 mb-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
      <div class="card z-index-2 h-100 p-5">
        <div class="card-header bg-transparent">
          <h6 class="text-capitalize">Hi, {{Auth::user()->name}}</h6>
          <p class="text-sm ">
            <span class="font-weight-bold">Let's Explore fot the Test
          </p>
        </div>
      </div>
    </div>
  </div>
@endsection
