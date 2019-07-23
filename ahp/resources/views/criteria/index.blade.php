@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
   
@section('content_header')
<h1>
  Kriteria dan Subkriteria
  <dfn><small>Control panel</small></dfn>
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Kriteria</li>
</ol>
@endsection

@section('content')
<div class="box">
	<div class="box-body">
		<div class="alert alert-warning alert-dismissible">
			<h4><i class="icon fa fa-warning"></i> Peringatan!</h4>
			<ul>
				<li><strong>Kriteria minimal harus terdiri dari tiga subkriteria</strong>, jika kurang dari itu maka tidak perlu dikelompokkan.</li>
			</ul>
		</div>
		
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
					<a class="btn btn-success" href="{{ route('criteria.create') }}"> Tambahkan Kriteria/Subkriteria</a>
				</div>
			</div>
		</div>
		
		<br/>
		<table id="table_criteria" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Kriteria/Sub-Kriteria</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($criterias as $id => $value)
					<tr>
						<td align ="center" bgcolor="#F0FBD6">{{ ++$i }}</td>
						<td bgcolor="#F0FBD6">{{ $value["name"] }}</td>
						<td bgcolor="#F0FBD6">
							<a class="btn btn-primary" href="{{ route('criteria.edit',$id) }}">Edit</a>
							{!! Form::open(['method' => 'DELETE','route' => ['criteria.destroy', $id],'style'=>'display:inline']) !!}
							{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
							{!! Form::close() !!}
						</td>
					</tr>
					@foreach($value["data"] as $sub)
						<tr>
							<td width = "50px" align ="right" bgcolor="#FDFDFD"></td>
							<td bgcolor="#FDFDFD"><li>{{ $sub->name }}</li></td>
							<td bgcolor="#FDFDFD">
								<a class="btn btn-info" href="{{ route('criteria.subedit',$id) }}">Edit</a>
								{!! Form::open(['method' => 'DELETE','route' => ['criteria.subdestroy', $id],'style'=>'display:inline']) !!}
								{!! Form::submit('Delete', ['class' => 'btn btn-warning']) !!}
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
				@endforeach
			</tbody>
		</table>
	</div>
</div>	
@endsection