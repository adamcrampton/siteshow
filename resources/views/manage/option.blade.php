@extends('layouts.manage')

@section('content')

<!-- Page Content -->
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card-body">
			{!! Form::open(['action' => ['OptionController@batchUpdate'], 'class' => 'form']) !!}
			{{ method_field('PATCH') }}
				<div class="form-group row required">
					<label class="col-lg-3 col-form-label form-control-label">Global Delay</label>
					<div class="col-lg-9">
					{{ Form::text('global_delay', $option['global_delay'], ['class' => 'form-control', 'id' => 'global_delay', 'required']) }}
					</div>
				</div>
			</div>
			<div class="form-group row">
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

@endsection