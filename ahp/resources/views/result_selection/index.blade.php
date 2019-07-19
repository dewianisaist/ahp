@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
  
@section('content_header')
<h1>
  Manajemen Data Alternatif
  <dfn><small>Control panel</small></dfn>
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Manajemen Data Alternatif</li>
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
	
		<br/>
    	<table id="table_result_selection" class="table table-bordered table-striped">
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
				@foreach ($data as $key => $result_selection)
					<tr>
						<td>{{ ++$i }}</td>
						<td>{{ $result_selection->name_registrant }}</td>
						<td>{{ $result_selection->name_sub_vocational }}</td>
						<td>{{ $result_selection->date }}</td>
						<td>{{ $result_selection->time }}</td>
						<td>
							<a class="btn btn-primary" href="{{ route('result_selection.assessment',$result_selection->id) }}">Penilaian</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		{!! $data->render() !!}

		<br/>
		{!! Form::open(array('route' => 'result_selection.count','method'=>'POST')) !!}
			<button type="submit" class="btn btn-primary">Mulai Hitung Penilaian</button>
		{!! Form::close() !!}
	</div>
</div>	
@endsection