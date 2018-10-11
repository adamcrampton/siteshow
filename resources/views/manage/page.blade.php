@extends('layouts.manage')

@section('content')

<div class="col-lg-12 clearfix">
	<div id="add-form" class="collapse multi-collapse">
		<h2>Add New Page</h2>
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
</div>
<div class="col-lg-12">
	<hr>
</div>
<div class="mt-5 col-lg-12 clearfix">
	<h2 class="float-md-left">Update Pages</h2>
	<div class="float-md-right">
		{{-- Only show visibility toggle if inactive records are on page --}}
		@if ($page->contains('status', 0))
		<button id="show-toggle" class="btn btn-info btn-right" type="button" data-toggle="collapse" data-target=".inactive-row" aria-expanded="false" aria-controls="inactive-row"></button>
		@endif
	</div>
	{!! Form::open(['action' => ['PageController@batchUpdate'], 'class' => 'form']) !!}
	{{ method_field('PATCH') }}
	@foreach($page->chunk($loopLimit) as $iteration => $pageGroup)
		{{-- Hide table if not in first loop iteration. Also add data attribute so we can toggle visibility of additional loads. --}}
		<table class="table table-sm table-hover {{ $loop->iteration !== 1 ? 'd-none' : '' }}" id="update-form" data-iteration={{ $loop->iteration }}>
			{{-- Only show thead in first iteration. --}}
			@if ($loop->first)
			<thead>
				<tr>
					<th scope="col">Page Name</th>
					<th scope="col">Page URL</th>
					<th scope="col">Image Link</th>
					<th scope="col">Rank</th>
					<th scope="col">Status</th>
				</tr>
			</thead>
			@endif
			<tbody>
				@foreach($pageGroup as $index => $pageValues)
					{{-- Hide row if item is inactive --}}
					<tr {!! $pageValues->status == 0 ? 'class="collapse multi-collapse inactive-row"' : '' !!}>
						<td>
							{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
							{{ Form::text('page['. $index .'][id]', $pageValues->id, ['style' => 'display:none']) }}
							{{ Form::text('page['. $index .'][original_value_name]', $pageValues->name, ['style' => 'display:none']) }}
							{{ Form::text('page['. $index .'][name]', $pageValues->name, ['class' => 'form-control name_field', 'data-input-type' => 'name', 'data-update-row' => $index, 'required']) }}
						</td>
						<td>
							{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
							{{ Form::text('page['. $index .'][original_value_url]', $pageValues->url, ['style' => 'display:none']) }}
							{{ Form::text('page['. $index .'][url]', $pageValues->url, ['class' => 'form-control', 'data-input-type' => 'url', 'data-update-row' => $index, 'required']) }}
						</td>
						<td>
							@if (!empty($pageValues->image_path))		
							<a class="venobox" href="{{ $option['default_save_path'] }}{{ $pageValues->image_path }}">Link</a>
							@else
							No image
							@endif
						</td>
						<td>								
							{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
							{{ Form::text('page['. $index .'][original_value_rank]', $pageValues->rank, ['style' => 'display:none', 'class' => 'original_rank_field']) }}
							{{ Form::text('page['. $index .'][rank]', $pageValues->rank, ['style' => 'display:none', 'class' => 'rank_field']) }}
							{{-- Show 'Inactive' if disabled --}}
							{{ $pageValues->rank ? $pageValues->rank : 'Inactive' }}
						</td>
						<td>
							{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
							{{ Form::text('page['. $index .'][original_value_status]', $pageValues->status, ['style' => 'display:none']) }}
							<select class="form-control" name="page[{{$index}}][status]" id="status" required>
								<option value="1" {{ $pageValues->status == 1 ? 'selected' : '' }}>Active</option>
								<option value="0" {{ $pageValues->status == 0 ? 'selected' : '' }}>Inactive</option>
							</select>
						</td>
					</tr>		
				@endforeach
			</tbody>
		</table>
	@endforeach
	<table class="table">
		<tbody>
			<tr>
				<td class="text-right">
					<input type="reset" class="btn btn-secondary" id="form-cancel" value="Cancel">
					{!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
				</td>
			</tr>
		</tbody>
	</table>
	{!! Form::close() !!}
</div>

@endsection