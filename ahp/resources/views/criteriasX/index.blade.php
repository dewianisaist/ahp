@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
   
@section('content_header')
<h1>
  Manajemen Kriteria dari Kajian Pustaka
  <dfn><small>Control panel</small></dfn>
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Manajemen Kriteria dari Kajian Pustaka</li>
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
					<a class="btn btn-success" href="{{ route('criterias.create') }}"> Tambahkan Kriteria</a>
				</div>
			</div>
		</div>
	
		<br/>
    	<table id="table_criterias" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Kriteria</th>
					<th>Penjelasan Kriteria</th>
					<th width="280px">Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($criterias as $key => $criteria)
					<tr>
						<td width="5px">{{ ++$i }}</td>
						<td width="450px">{{ $criteria->name }}</td>
						<td width="800px">{!! nl2br(e($criteria->description)) !!}</td>
						<td>
							<a class="btn btn-info" href="{{ route('criterias.show',$criteria->id) }}">Detail</a>
							<a class="btn btn-primary" href="{{ route('criterias.edit',$criteria->id) }}">Edit</a>
							{!! Form::open(['method' => 'DELETE','route' => ['criterias.destroy', $criteria->id],'style'=>'display:inline']) !!}
							{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
							{!! Form::close() !!}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		{!! $criterias->render() !!}
	</div>
</div>	
@endsection