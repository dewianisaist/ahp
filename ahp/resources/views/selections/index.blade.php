@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
  
@section('content_header')
<h1>
  Manajemen Nilai Seleksi
  <dfn><small>Control panel</small></dfn>
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Manajemen Nilai Seleksi</li>
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
	
		<br/>
    	<table id="table_selections" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Pendaftar</th>
					<th>Sub-Kejuruan</th>
					<th>Tanggal Seleksi</th>
					<th>Waktu Seleksi</th>
					<th width="280px">Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data as $key => $selection)
					<tr>
						<td>{{ ++$i }}</td>
						<td>{{ $selection->name_registrant }}</td>
						<td>{{ $selection->name_sub_vocational }}</td>
						<td>{{ $selection->date }}</td>
						<td>{{ $selection->time }}</td>
						<td>
							<a class="btn btn-info" href="{{ route('selections.show',$selection->id) }}">Detail</a>
							@permission('selection-edit')
							<a class="btn btn-primary" href="{{ route('selections.edit',$selection->id) }}">Input Nilai Seleksi</a>
							@endpermission
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		{!! $data->render() !!}
	</div>
</div>	
@endsection