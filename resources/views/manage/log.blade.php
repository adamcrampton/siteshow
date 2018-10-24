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
					<td>
						<div class="d-none logButtonContainer" data-logValues="{!! $logValues->output !!}"></div>
						<button type="button" id="viewLog" class="btn btn-primary" data-toggle="modal" data-target="#logModal">
						  View Details
						</button>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

{{-- Log details modal --}}
<div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="logModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logModalTitle">Log Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

@endsection