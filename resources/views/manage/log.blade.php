@extends('layouts.manage')

@section('content')

<div class="col-lg-12 clearfix">
	<table class="table table-sm table-hover" id="update-form">
		<thead>
			<tr>
				<th scope="col">Start Time</th>
				<th scope="col">Finish Time</th>
				<th scope="col">Duration (seconds)</th>
				<th scope="col">User Agent</th>
				<th scope="col">Output</th>
			</tr>
		</thead>
		<tbody>
			@foreach($log as $index => $logValues)
				<tr>
					<td>{{ $logValues->started }}</td>
					<td>{{ $logValues->finished }}</td>
					<td>{{ $logValues->duration }}</td>
					<td>{{ $logValues->user_agent_used }}</td>
					<td>{!! $logValues->output !!}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

@endsection