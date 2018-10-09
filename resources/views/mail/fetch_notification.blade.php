<!doctype html>
  <head>
    <title>Siteshow Fetch Notification</title>
  </head>
  <body>   
    <p>Hello! A fetch containing {{ $totalUpdates }} items was just processed with the following information:</p>
    <p><strong>Timing</strong></p>
    <ul>
      <li>Start datetime: {{ $startTime }}</li>
      <li>End datetime: {{ $endTime }}</li>
      <li>Duration: {{ $duration }} seconds</li>
    </ul>
    <p><strong>Files</strong></p>
    @foreach ($filesUpdated as $item => $fileDetails)
    <p>Item #{{ $item }}</p>
      <ul>
      {{-- If there was an error fetch, display it. Otherwise show file details. --}}
      @if (isset($fileDetails['error']))
        <li>There were errors: {!! $fileDetails['error'] !!}</li>
      @else
        <li>Original filename: {{ $fileDetails['original'] }}
        <li>Saved filename: {{ $fileDetails['saved'] }}
        <li>New file created? {{ ($fileDetails['new'] === true) ? 'Yes' : 'No' }}
      @endif
    </ul>
    @endforeach
  </body>
</html>