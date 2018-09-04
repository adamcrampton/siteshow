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
          <h1 class="mt-5">Hi </h1>
          <p class="lead">Admin options</p>
          <ul>
            <li>
              <a href="/config">Global Configuration</a>
            </li>
            <li>
              <a href="/users">Manage Users</a>
            </li>         
          </ul>
          <p class="lead">Tools</p>
          <ul>
            <li>
              <a href="/logs">View Logs</a>
            </li>
          </ul>
         </div>
        </div>
      </div>
    </div>
@endsection
