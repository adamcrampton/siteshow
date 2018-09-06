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
            {{-- Editor or higher access required for managing pages. --}}
            @can('editor-functions', auth()->user())  
            <li>
              <a href="/pages">Manage Pages</a>
            </li>
            @endcan

            {{-- Only admins can manage global config and users. --}}
            @can('admin-functions', auth()->user())            
            <li>
              <a href="/options">Set Options</a>
            </li>
            <li>
              <a href="/users">Manage Users</a>
            </li>
            @endcan

            {{-- Any logged in viewer can see logs. --}}
            <li>
              <a href="/logs">View Logs</a>
            </li>
            <li>
              <a href="/logout">Log out</a>
            </li>
          </ul>
         </div>
        </div>
      </div>
    </div>
@endsection
