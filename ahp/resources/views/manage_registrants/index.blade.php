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
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
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

		<br/>
    	<table id="table_manage_registrants" class="table table-bordered table-striped">
			<thead>
				<tr>
          <th>No</th>
          <th>No. Identitas</th>
					<th>Nama</th>
					<th>Sub-Kejuruan</th>
          <th>Tanggal Daftar</th>
          <th width="280px">Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data as $key => $user)
				<tr>
          <td>{{ ++$i }}</td>
          <td>{{ $user->identity_number }}</td>
					<td>{{ $user->name_registrant }}</td>
          <td>{{ $user->name_sub_vocational }}</td>
          <td>{{ $user->register_date }}</td>
					<td>
            <a class="btn btn-info" href="{{ route('manage_registrants.show', $user->id_registrant) }}">Detail</a>
					</td>
				</tr>		
				@endforeach
			</tbody>
		</table>
		{!! $data->render() !!}
	</div>
</div>
@endsection
