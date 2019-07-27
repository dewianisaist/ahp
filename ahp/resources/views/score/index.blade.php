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
  <li><a href="{{ route('manage_alternatives.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
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
    	<table id="table_score" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th width="50px">No</th>
					<th>Nama Pendaftar</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data as $key => $score)
					<tr>
						<td>{{ ++$i }}</td>
						<td>{{ $score->name }}</td>
						<td>
							<a class="btn btn-primary" href="{{ route('score.assessment',$score->id) }}">Penilaian</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		{!! $data->render() !!}

		<br/>
		{!! Form::open(array('route' => 'score.count','method'=>'POST')) !!}
			<button type="submit" class="btn btn-primary">Mulai Hitung Penilaian</button>
		{!! Form::close() !!}
	</div>
</div>	
@endsection