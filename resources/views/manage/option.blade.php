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
					<label class="col-lg-3 col-form-label form-control-label">Delay</label>
					<div class="col-lg-9">
					{{ Form::text('global_delay', $option['global_delay'], ['class' => 'form-control', 'id' => 'global_delay', 'required']) }}
					</div>
				</div>
				<div class="form-group row required">
					<label class="col-lg-3 col-form-label form-control-label">Fetch Limit</label>
					<div class="col-lg-9">
					{{ Form::text('global_fetch_limit', $option['global_fetch_limit'], ['class' => 'form-control', 'id' => 'global_fetch_limit', 'required']) }}
					</div>
				</div>
				<div class="form-group row required">
					<label class="col-lg-3 col-form-label form-control-label">Fetch Delay</label>
					<div class="col-lg-9">
					{{ Form::text('global_fetch_delay', $option['global_fetch_delay'], ['class' => 'form-control', 'id' => 'global_fetch_delay', 'required']) }}
					</div>
				</div>
				<div class="form-group row required">
					<label class="col-lg-3 col-form-label form-control-label">Page List Limit</label>
					<div class="col-lg-9">
					{{ Form::text('global_page_list_limit', $option['global_page_list_limit'], ['class' => 'form-control', 'id' => 'global_page_list_limit', 'required']) }}
					</div>	
				</div>
				<div class="form-group row required">
					<label class="col-lg-3 col-form-label form-control-label">User Agent</label>
					<div class="col-lg-9">
					{{ Form::text('user_agent', $option['user_agent'], ['class' => 'form-control', 'id' => 'user_agent', 'required']) }}
					</div>	
				</div>
				<div class="form-group row required">
					<label class="col-lg-3 col-form-label form-control-label">Save Path</label>
					<div class="col-lg-9">
					{{ Form::text('default_save_path', $option['default_save_path'], ['class' => 'form-control', 'id' => 'default_save_path', 'required']) }}
					</div>	
				</div>
				<div class="form-group row required">
					<label class="col-lg-3 col-form-label form-control-label">Overwrite files?</label>
					<div class="col-lg-9">
						<select class="form-control" name="global_overwrite_files" id="global_overwrite_files" required>
							<option value required>Please select one:</option>
							<option value="1" {{ $option['global_overwrite_files'] == 1 ? 'selected' : '' }}>Yes</option>
							<option value="0" {{ $option['global_overwrite_files'] == 0 ? 'selected' : '' }}>No</option>
						</select>
					</div>
				</div>
				<div class="form-group row required">
					<label class="col-lg-3 col-form-label form-control-label">Dimiss Dialogues?</label>
					<div class="col-lg-9">
						<select class="form-control" name="dismiss_dialogues" id="dismiss_dialogues" required>
							<option value required>Please select one:</option>
							<option value="1" {{ $option['dismiss_dialogues'] == 1 ? 'selected' : '' }}>Yes</option>
							<option value="0" {{ $option['dismiss_dialogues'] == 0 ? 'selected' : '' }}>No</option>
						</select>
					</div>
				</div>
				<div class="form-group row required">
					<label class="col-lg-3 col-form-label form-control-label">Wait Until Network Idle?</label>
					<div class="col-lg-9">
						<select class="form-control" name="wait_until_network_idle" id="wait_until_network_idle" required>
							<option value required>Please select one:</option>
							<option value="1" {{ $option['wait_until_network_idle'] == 1 ? 'selected' : '' }}>Yes</option>
							<option value="0" {{ $option['wait_until_network_idle'] == 0 ? 'selected' : '' }}>No</option>
						</select>
					</div>
				</div>
				<div class="form-group row required">
					<label class="col-lg-3 col-form-label form-control-label">Global Page Image Width</label>
					<div class="col-lg-9">
					{{ Form::text('global_fetch_window_width', $option['global_fetch_window_width'], ['class' => 'form-control', 'id' => 'global_fetch_window_width', 'required']) }}
					</div>
				</div>
				<div class="form-group row required">
					<label class="col-lg-3 col-form-label form-control-label">Global Page Image Height</label>
					<div class="col-lg-9">
					{{ Form::text('global_fetch_window_height', $option['global_fetch_window_height'], ['class' => 'form-control', 'id' => 'global_fetch_window_height', 'required']) }}
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
</div>

@endsection