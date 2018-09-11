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
		        	@for ($i = 1; $i <= $pageCount; $i++)
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

@endsection