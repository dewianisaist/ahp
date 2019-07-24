@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
  
@section('content_header')
<h1>
  Buat Kriteria/Subkriteria
</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('manage_alternatives.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('criteria.index') }}"><i class="fa fa-list"></i> Kriteria</a></li>
  <li class="active">Buat Kriteria/Subkriteria</li>
</ol>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-body">
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<strong>Maaf!</strong> Ada kesalahan dengan data yang Anda masukkan.<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		{!! Form::open(array('route' => 'criteria.store','method'=>'POST')) !!}
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Nama Kriteria/Subkriteria:</strong>
						{!! Form::text('name', null, array('placeholder' => 'Nama Kriteria/Subkriteria','class' => 'form-control')) !!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Tentukan sebagai Subkriteria:</strong>
						{!! Form::select('subcriteria', 
							array(
								'Ya' => 'Ya', 
								'Tidak' => 'Tidak',
							), 
							null, array('class' => 'form-control', 'id' => 'subcriteria')) 
						!!}
					</div>
				</div>
				<div id="criteria" class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Kriteria:</strong>
						{!! Form::select('group_criteria', $criterias,[], array('class' => 'form-control', 'id' => 'criteria_value')) !!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 text-center">
						<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
  $(function () {
    $("#subcriteria").change(function () {
		$( "#subcriteria option:selected").each(function(){
        	if ($(this).val() == "Ya") {
				$("#criteria").show();
			} else {
				$("#criteria").hide();
				document.getElementById("criteria_value").innerHTML = null; 
			}
		});
	}).change();
});
</script>
@endsection