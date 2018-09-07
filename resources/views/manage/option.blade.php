@extends('layouts.manage')

@section('content')
    @if (session('status'))
    <div class="card-body">
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
    </div>
    @endif
    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="mt-5">Global Options</h1>
          
         </div>
        </div>
      </div>
    </div>
@endsection
