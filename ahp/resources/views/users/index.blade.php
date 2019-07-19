@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection

@section('content_header')
<h1>
  Manajemen Akun Pengguna
  <dfn><small>Control panel</small></dfn>
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Manajemen Pengguna</li>
</ol>
@endsection

@section('content')
<div class="box">
	<div class="box-body">
		@if ($message = Session::get('success'))
			<div class="alert alert-success">
				<p>{{ $message }}</p>
			</div>
		@endif

		@if ($message = Session::get('failed'))
			<div class="alert alert-error">
				<p>{{ $message }}</p>
			</div>
		@endif

		<div class="row">
			<div class="col-lg-12 margin-tb">
				<div class="pull-right mb-1">
					<a class="btn btn-success" href="{{ route('users.create') }}"> Buat Akun Baru</a>
				</div>
			</div>
		</div>

		<br/>
    	<table id="table_users" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>No. Identitas</th>
					<th>Email</th>
					<th><dfn>Roles</dfn></th>
					<th width="280px">Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data as $key => $user)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->identity_number }}</td>
					<td>{{ $user->email }}</td>
					<td>
						@if(!empty($user->roles))
							@foreach($user->roles as $v)
								<label class="label label-success">{{ $v->display_name }}</label>
							@endforeach
						@endif
					</td>
					<td>
						<a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Detail</a>
						<a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
						{!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
						{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
						{!! Form::close() !!}
					</td>
				</tr>		
				@endforeach
			</tbody>
		</table>
		{!! $data->render() !!}
	</div>
</div>
@endsection
