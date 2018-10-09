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
		<div id="displayCarousel" class="carousel slide" data-ride="carousel" data-interval=5000>
			<div class="carousel-inner">
				@foreach ($pageData as $page => $data)
				<div class="carousel-item {{ $page === 0 ? 'active' : '' }}">
					<img class="d-block w-100" src="{{ $globalOptions['default_save_path'] . $data->image_path }}" alt="{{ $data->name }}">
					<div class="carousel-caption d-none d-md-block">
						<!-- Captions if you want them -->
					</div>
				</div>
				@endforeach
			</div>
			<a class="carousel-control-prev" href="#displayCarousel" role="button" data-slide="prev">
			    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next" href="#displayCarousel" role="button" data-slide="next">
			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>
			</div>
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