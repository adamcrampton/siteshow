<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ URL::asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

    <title>{{ $pageTitle }}</title>
  </head>
  <body>

  <!-- Build slideshow -->
  @foreach ($pageData as $page => $data)

  @endforeach
  </div>
	<!-- Vendor JS -->
    <script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/jqueryui/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- App Scripts -->
    <script src="{{ URL::asset('js/app.js') }}"></script>
    <script src="{{ URL::asset('js/display.js') }}"></script>
  </body>
</html>