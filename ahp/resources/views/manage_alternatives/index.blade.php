@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection

@section('content_header')
<h1>
  Data Pendaftar
  <dfn><small>Control panel</small></dfn>
</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('manage_alternatives.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Data Pendaftar</li>
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
					<a class="btn btn-success" href="{{ route('manage_alternatives.create') }}"> Tambahkan Pendaftar</a>
				</div>
			</div>
		</div>

		<br/>
    	<table id="table_manage_alternatives" class="table table-bordered table-striped">
			<thead>
				<tr>
          			<th>No</th>
          			<th>Nama</th>
					<th>Tanggal Lahir</th>
					<th>Pendidikan Terakhir</th>
					<th width="280px">Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data as $key => $user)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->date_birth }}</td>
					<td>{{ $user->last_education }}</td>
					<td>
            			<a class="btn btn-info" href="{{ route('manage_alternatives.show', $user->id) }}">Detail</a>
						<a class="btn btn-primary" href="{{ route('manage_alternatives.edit',$user->id) }}">Edit</a>
						{!! Form::open(['method' => 'DELETE','route' => ['manage_alternatives.destroy', $user->id],'style'=>'display:inline']) !!}
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
