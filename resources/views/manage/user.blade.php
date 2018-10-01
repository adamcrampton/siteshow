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
					@foreach($userPemissions as $userPermission)
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
				<th scope="col">Permission Level</th>
				<th scope="col">Password</th>
				<th scope="col">Status</th>
			</tr>
		</thead>
		<tbody>
		@foreach($user as $index => $userValues)
			{{-- Hide row if item is inactive --}}
			<tr {!! $userValues->status == 0 ? 'class="collapse multi-collapse inactive-row"' : '' !!}>
				<td>
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					TODO
				</td>
				<td>
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					TODO
				</td>
				<td>
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					TODO
				</td>
				<td>
					TODO
				</td>
				<td>								
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					TODO
				</td>
				<td>
					{{-- Store id and original value for each row - to be processed as an array in the backend. --}}
					TODO
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<table>
		<tbody>
			<tr>
				<td colspan="6" class="text-right">
					<input type="reset" class="btn btn-secondary" id="form-cancel" value="Cancel">
					{!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
				</td>
			</tr>
		</tbody>
	</table>
	{!! Form::close() !!}
</div>

@endsection