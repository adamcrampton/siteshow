@extends('layouts.manage')

@section('content')
    
<h2 class="mt-5">Add New Page</h2>
	<div class="card-body">
		{!! Form::open(['action' => ['PageController@store'], 'class' => 'form', 'id' => 'add_form']) !!}
		<div class="form-group row required">
	      <label class="col-lg-3 col-form-label form-control-label">Page Name</label>
	      <div class="col-lg-9">
	          {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'required']) }}
		  </div>
		</div>
		<div class="form-group row required">
	      <label class="col-lg-3 col-form-label form-control-label">Page URL</label>
	      <div class="col-lg-9">
	          {{ Form::text('url', null, ['class' => 'form-control', 'id' => 'url', 'required']) }}
		  </div>
		</div>
		<div class="form-group row required">
	      <label class="col-lg-3 col-form-label form-control-label">Display Duration (seconds)</label>
	      <div class="col-lg-9">
	          {{ Form::text('duration', $option['global_delay'], ['class' => 'form-control', 'id' => 'duration', 'required']) }}
		  </div>
		</div>
		<div class="form-group row required">
			<label class="col-lg-3 col-form-label form-control-label">Ranking</label>
			<div class="col-lg-9">
				<select class="form-control" name="rank" id="rank" required>
		        <option value required>Please select one:</option>
		        	@for ($i = 1; $i <= $pageCount + 1; $i++)
		        		<option value="{{ $i }}">{{ $i }}</option>
		        	@endfor
				</select>	
			</div>
		</div>
		<div class="form-group row text-right">
		  <label class="col-lg-3 col-form-label form-control-label"></label>
		  <div class="col-lg-9">
		      <input type="reset" class="btn btn-secondary" value="Cancel">
		      {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		  </div>
		</div>
	{!! Form::close() !!}
	</div>
</div>

<div class="col-lg-12 mt-5">
	<h2 class="float-md-left">Manage Pages</h2>
	<div class="float-md-right">
		<a href="#" class="btn btn-primary btn-right">Show Disabled Pages</a>
	</div>
	{!! Form::open(['action' => ['PageController@batchUpdate'], 'class' => 'form', 'id' => 'update_form']) !!}
	<table class="table table-hover">
		<thead>
			<tr>
				<th scope="col">Page Name</th>
				<th scope="col">Page URL</th>
				<th scope="col">Duration</th>
				<th scope="col">Image Link</th>
				<th scope="col">Rank</th>
				<th scope="col">Status</th>
				<th scope="col">Delete</th>
			</tr>
		</thead>

		@foreach($page as $index => $pageValues)
			{{-- Hide row if item is disabled --}}
			<tr {!! $pageValues->status == 0 ? 'class="d-none"' : '' !!}>
				<td>
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					{{ Form::text('page['. $index .'][id]', $pageValues->id, ['style' => 'display:none']) }}
					{{ Form::text('page['. $index .'][original_value_name]', $pageValues->name, ['style' => 'display:none']) }}
					{{ Form::text('page['. $index .'][name]', $pageValues->name, ['class' => 'form-control first_name', 'data-input-type' => 'name', 'data-update-row' => $index, 'required']) }}
				</td>
				<td>
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					{{ Form::text('page['. $index .'][original_value_url]', $pageValues->url, ['style' => 'display:none']) }}
					{{ Form::text('page['. $index .'][url]', $pageValues->url, ['class' => 'form-control last_name', 'data-input-type' => 'url', 'data-update-row' => $index, 'required']) }}
				</td>
				<td>
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					{{ Form::text('page['. $index .'][original_value_duration]', $pageValues->duration, ['style' => 'display:none']) }}
					{{ Form::text('page['. $index .'][duration]', $pageValues->duration, ['class' => 'form-control', 'id' => 'duration', 'required']) }}
				</td>
				<td>								
					<a href="{{ $option['default_save_path'] }}{{ $pageValues->image_path }}.jpg">Link</a>
				</td>
				<td>								
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					{{ Form::text('page['. $index .'][original_value_rank]', $pageValues->rank, ['style' => 'display:none']) }}
					{{ Form::text('page['. $index .'][rank]', $pageValues->rank, ['class' => 'form-control', 'id' => 'rank', 'required']) }}
				</td>
				<td>								
					<select class="form-control" name="dismiss_dialogues" id="dismiss_dialogues" required>
						<option value="1" {{ $pageValues->status == 1 ? 'selected' : '' }}>Active</option>
						<option value="0" {{ $pageValues->status == 0 ? 'selected' : '' }}>Disabled</option>
					</select>
				</td>
				<td class="text-center">
					<div class="form-check">
					{{-- There will either be a value or not in $_POST, so the actual value of the field set doesn't matter. --}}
					{{ Form::checkbox('page['. $index .'][delete]', null, false, ['class' => 'form-check-input']) }}
					</div>
				</td>
			</tr>
		@endforeach
			<tr>
				<td colspan="7" class="text-right">
					<input type="reset" class="btn btn-secondary" value="Cancel">
					{!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
				</td>
			</tr>
	</table>
	{!! Form::close() !!}
	</div>
</div>

@endsection