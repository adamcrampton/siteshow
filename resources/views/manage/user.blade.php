@extends('layouts.manage')

@section('content')

<div class="col-lg-12 clearfix">
	<div id="add-form" class="collapse multi-collapse">
		<h2>Add New User</h2>
		<div class="card-body">
			{!! Form::open(['action' => ['UserController@store'], 'class' => 'form', 'id' => 'add_form']) !!}
			<div class="form-group row required">
		      <label class="col-lg-3 col-form-label form-control-label">First Name</label>
		      <div class="col-lg-9">
		          {{ Form::text('first_name', null, ['class' => 'form-control', 'id' => 'first_name', 'required']) }}
			  </div>
			</div>
			<div class="form-group row required">
		      <label class="col-lg-3 col-form-label form-control-label">Last Name</label>
		      <div class="col-lg-9">
		          {{ Form::text('last_name', null, ['class' => 'form-control', 'id' => 'last_name', 'required']) }}
			  </div>
			</div>
			<div class="form-group row required">
		      <label class="col-lg-3 col-form-label form-control-label">Display Name</label>
		      <div class="col-lg-9">
		          {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'required']) }}
			  </div>
			</div>
			<div class="form-group row required">
		      <label class="col-lg-3 col-form-label form-control-label">Email Address</label>
		      <div class="col-lg-9">
		          {{ Form::text('email', null, ['class' => 'form-control', 'id' => 'email', 'required']) }}
			  </div>
			</div>
			<div class="form-group row required">
		      <label class="col-lg-3 col-form-label form-control-label">Permission Level</label>
			<div class="col-lg-9">
				<select class="form-control" name="user_permission_level" id="user_permission_level" required>
					<option value required>Please select one:</option>
					@foreach($userPermissions as $userPermission)
						<option value="{{ $userPermission->id }}">{{ $userPermission->permission }}</option>
					@endforeach
				</select>
			</div>
			</div>
			<div class="form-group row required">
		      <label class="col-lg-3 col-form-label form-control-label">Password</label>
		      <div class="col-lg-9">
		         {{ Form::password('password', ['class' => 'form-control', 'id' => 'password', 'required']) }}
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
	<h2 class="float-md-left">Update Users</h2>
	<div class="float-md-right">
		{{-- Only show visibility toggle if inactive records are on page --}}
		@if ($user->contains('status', 0))
		<button id="show-toggle" class="btn btn-info btn-right" type="button" data-toggle="collapse" data-target=".inactive-row" aria-expanded="false" aria-controls="inactive-row"></button>
		@endif
	</div>
	{!! Form::open(['action' => ['UserController@batchUpdate'], 'class' => 'form']) !!}
	{{ method_field('PATCH') }}
	<table class="table table-hover" id="update-form">
		<thead>
			<tr>
				<th scope="col">First Name</th>
				<th scope="col">Last Name</th>
				<th scope="col">Display Name</th>
				<th scope="col">Email</th>
				<th scope="col">Permission Level</th>
				<th scope="col">Status</th>
			</tr>
		</thead>
		<tbody>
		@foreach($user as $index => $userValues)
			{{-- Hide row if item is inactive --}}
			<tr {!! $userValues->status == 0 ? 'class="collapse multi-collapse inactive-row"' : '' !!}>
				<td>
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					{{ Form::text('user['. $index .'][id]', $userValues->id, ['style' => 'display:none']) }}
					{{ Form::text('user['. $index .'][original_value_first_name]', $userValues->first_name, ['style' => 'display:none']) }}
					{{ Form::text('user['. $index .'][first_name]', $userValues->first_name, ['class' => 'form-control first_name_field', 'data-input-type' => 'first_name', 'data-update-row' => $index, 'required']) }}
				</td>
				</td>
				<td>
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					{{ Form::text('user['. $index .'][original_value_last_name]', $userValues->last_name, ['style' => 'display:none']) }}
					{{ Form::text('user['. $index .'][last_name]', $userValues->last_name, ['class' => 'form-control last_name_field', 'data-input-type' => 'last_name', 'data-update-row' => $index, 'required']) }}
				</td>
				<td>
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					{{ Form::text('user['. $index .'][original_value_name]', $userValues->name, ['style' => 'display:none']) }}
					{{ Form::text('user['. $index .'][name]', $userValues->name, ['class' => 'form-control name_field', 'data-input-type' => 'name', 'data-update-row' => $index, 'required']) }}
				</td>
				<td>
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					{{ Form::text('user['. $index .'][original_value_email]', $userValues->email, ['style' => 'display:none']) }}
					{{ Form::text('user['. $index .'][email]', $userValues->email, ['class' => 'form-control email_field', 'data-input-type' => 'email', 'data-update-row' => $index, 'required']) }}
				</td>
				<td>
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					{{ Form::text('user['. $index .'][original_value_user_permission_level]', $userValues->user_permissions_fk, ['style' => 'display:none']) }}
					<select class="form-control user_permission_level_field" name="user[{{$index}}][user_permission_level]" required>
						@foreach($userPermissions as $userPermission)
							<option value="{{ $userPermission->id }}" {{ $userValues->user_permissions_fk == $userPermission->id ? 'selected' : '' }}>{{ $userPermission->permission }}</option>
						@endforeach
					</select>
				</td>
				<td>
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					{{ Form::text('user['. $index .'][original_value_status]', $userValues->status, ['style' => 'display:none']) }}
					<select class="form-control status_field" name="user[{{$index}}][status]" required>
						<option value="1" {{ $userValues->status == 1 ? 'selected' : '' }}>Active</option>
						<option value="0" {{ $userValues->status == 0 ? 'selected' : '' }}>Inactive</option>
					</select>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<table>
		<tbody>
			<tr>
				<td colspan="5" class="text-right">
					<input type="reset" class="btn btn-secondary" id="form-cancel" value="Cancel">
					{!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
				</td>
			</tr>
		</tbody>
	</table>
	{!! Form::close() !!}
</div>
<div class="col-lg-12 mt-3">
	{{ $user->links() }}
</div>

@endsection