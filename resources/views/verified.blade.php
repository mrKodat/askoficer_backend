@extends('layouts.empty', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('Admin Dashboard')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">
      <div class="col-lg-10 col-md-8">
          <h1 class="text-white text-center" style="font-size: 30px;">{{ __('Your Email has been verfied') }}</h1>
          <h1 class="text-white text-center" style="font-size: 30px;">{{ __('You can go back to the Application') }}</h1>
      </div>
  </div>
</div>
@endsection
