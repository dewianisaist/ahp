@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
 
@section('content_header')
<h1>
  Manajemen <dfn>Role</dfn>
  <dfn><small>Control panel</small></dfn>
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Manajemen <dfn>Role</dfn></li>
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

		<div class="row">
			<div class="col-lg-12 margin-tb">
				<div class="pull-right mb-1">
					<a class="btn btn-success" href="{{ route('roles.create') }}"> Buat <dfn>Role</dfn> Baru</a>
				</div>
			</div>
		</div>
	
		<br/>
		<table id="table_users" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Deskripsi</th>
					<th width="280px">Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($roles as $key => $role)
					<tr>
						<td>{{ ++$i }}</td>
						<td>{{ $role->display_name }}</td>
						<td>{{ $role->description }}</td>
						<td>
							<a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Detail</a>
							<a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
							{!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
							{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
							{!! Form::close() !!}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		{!! $roles->render() !!}
	</div>
</div>
@endsection