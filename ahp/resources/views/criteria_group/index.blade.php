@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
   
@section('content_header')
<h1>
  Hierarki (Kelompok Kriteria)
  <dfn><small>Control panel</small></dfn>
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Hierarki (Kelompok Kriteria)</li>
</ol>
@endsection

@section('content')
<div class="box">
	<div class="box-body">
		<div class="alert alert-warning alert-dismissible">
			<h4><i class="icon fa fa-warning"></i> Peringatan!</h4>
			<ul>
				<li><strong>Kelompok kriteria minimal harus terdiri dari tiga kriteria</strong>, jika kurang dari itu maka tidak perlu dikelompokkan.</li>
			</ul>
		</div>
		
		@permission('criteriagroup-create')
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
					<a class="btn btn-success" href="{{ route('criteriagroup.create') }}"> Tambahkan Kelompok</a>
				</div>
			</div>
		</div>
		@endpermission
		
		<h3>Kelompok Kriteria</h3>
		<table id="table_criteriagroup" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Kriteria/Sub-Kriteria</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($criterias_group as $id => $value)
					<tr>
						<td align ="center" bgcolor="#F0FBD6">{{ ++$i }}</td>
						<td bgcolor="#F0FBD6">{{ $value["name"] }}</td>
						<td bgcolor="#F0FBD6">
							@permission('criteriagroup-edit')
							<a class="btn btn-primary" href="{{ route('criteriagroup.edit',$id) }}">Edit</a>
							@endpermission
							@permission('criteriagroup-delete')
							{!! Form::open(['method' => 'DELETE','route' => ['criteriagroup.destroy', $id],'style'=>'display:inline']) !!}
							{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
							{!! Form::close() !!}
							@endpermission
						</td>
					</tr>
					@foreach($value["data"] as $crit)
						<tr>
							{!! Form::open(array('route' => 'criteriagroup.out','method'=>'POST')) !!}
								<td width = "50px" align ="right" bgcolor="#FDFDFD"></td>
								<td bgcolor="#FDFDFD"><li>{{ $crit->name }}</li></td>
								<td bgcolor="#FDFDFD">
									@permission('criteriagroup-out')
									<input type = "hidden" name = "id" value = "{{ $crit->id }}" />
									<button type="submit" class="btn btn-primary">Remove from Group</button>
									@endpermission
								</td>
							{!! Form::close() !!}
						</tr>
					@endforeach
				@endforeach
			</tbody>
		</table>

		<br/>
		<h3>Kriteria</h3>
        <table id="table_criteriastep2_fix" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kriteria</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($criterias_fix as $key => $kriteria_fiks)
                    <tr>
						{!! Form::open(array('route' => 'criteriagroup.add','method'=>'POST')) !!}
							<td width = "50px" align ="center">{{ ++$j }}</td>
							<td width = "500px">{{ $kriteria_fiks->name }}</td>
							<td>
								@permission('criteriagroup-add')
								<input type = "hidden" name = "id" value = "{{ $kriteria_fiks->id }}" />
								<div class="col-xs-9">
									{!! Form::select('group_criteria', $list_group, null, array('class' => 'form-control')) !!}
								</div>
								<div class="col-xs-1">
									<button type="submit" class="btn btn-primary">Add to Group</button>
								</div>
								@endpermission
							</td>
						{!! Form::close() !!}
                    </tr>
                @endforeach
            </tbody>
        </table>
	</div>
</div>	
@endsection