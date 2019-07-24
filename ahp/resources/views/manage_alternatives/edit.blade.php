@extends('layouts.master_admin')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
@endsection

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
  
@section('content_header')
<h1>
  Edit Pendaftar 
</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('manage_alternatives.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('manage_alternatives.index') }}"><i class="fa fa-list"></i> Data Pendaftar</a></li>
  <li class="active">Edit Pendaftar</li>
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
		{!! Form::model($alternative, ['method' => 'PATCH','route' => ['manage_alternatives.update', $alternative->id]]) !!}
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Nama:</strong>
						{!! Form::text('name', isset($alternative->name) ? $alternative->name : '', array('placeholder' => 'Nama Pendaftar','class' => 'form-control')) !!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tanggal Lahir:</strong>
						<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							{!! Form::text('date_birth', isset($alternative->date_birth) ? $alternative->date_birth : '', array('placeholder' => 'Tanggal Lahir','class' => 'form-control pull-right', 'id' => 'datepicker')) !!}
						</div>
                    </div>
                </div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Pendidikan Terakhir:</strong>
						{!! Form::text('last_education', isset($alternative->last_education) ? $alternative->last_education : '', array('placeholder' => 'Pendidikan Terakhir','class' => 'form-control')) !!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Intensitas Keikutsertaan:</strong>
						{!! Form::text('intensity_participation', isset($alternative->intensity_participation) ? $alternative->intensity_participation : '', array('placeholder' => 'Intensitas Keikutsertaan','class' => 'form-control')) !!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Pengalaman Pelatihan:</strong>
						{!! Form::textarea('course_experience', isset($alternative->course_experience) ? $alternative->course_experience : '', array('placeholder' => 'Pengalaman Pelatihan','class' => 'form-control','style'=>'height:100px')) !!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<h3>Hasil Seleksi Tertulis</h3>
					</div>
				</div>	
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Nilai Pengetahuan <small>(Range nilai 0-100)</small>:</strong>
						{!! Form::text('knowledge_value', isset($alternative->knowledge_value) ? $alternative->knowledge_value : '', array('placeholder' => 'Nilai Pengetahuan','class' => 'form-control')) !!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Nilai Keterampilan Teknis <small>(Range nilai 0-100)</small>:</strong>
						{!! Form::text('technical_value', isset($alternative->technical_value) ? $alternative->technical_value : '', array('placeholder' => 'Nilai Keterampilan Teknis','class' => 'form-control')) !!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<h3>Hasil Seleksi Wawancara<h3>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Rencana setelah selesai pelatihan:</strong>
						{!! Form::text('orientation_value', isset($alternative->orientation_value) ? $alternative->orientation_value : '', array('placeholder' => 'Rencana setelah selesai pelatihan','class' => 'form-control')) !!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Rekomendasi:</strong>
						{!! Form::select('recommendation', 
							array(
								'Ada' => 'Ada', 
								'Tidak' => 'Tidak',
							), 
							isset($alternative->recommendation) ? $alternative->recommendation : '', array('class' => 'form-control')) 
						!!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Kejujuran (Kesesuaian antara jawaban dengan data):</strong>
						{!! Form::select('honesty_value', 
							array(
								'Sesuai' => 'Sesuai', 
								'Tidak Sesuai' => 'Tidak Sesuai',
							), 
							isset($alternative->honesty_value) ? $alternative->honesty_value : '', array('class' => 'form-control')) 
						!!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Sikap:</strong>
						{!! Form::select('attitude_value', 
							array(
								'Baik' => 'Baik', 
								'Cukup' => 'Cukup',
								'Kurang' => 'Kurang',
							), 
							isset($alternative->attitude_value) ? $alternative->attitude_value : '', array('class' => 'form-control')) 
						!!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Motivasi:</strong>
						{!! Form::select('motivation_value', 
							array(
								'Kemauan sendiri' => 'Kemauan sendiri', 
								'Dorongan orang lain' => 'Dorongan orang lain',
								'Tidak Ada' => 'Tidak Ada',
							), 
							isset($alternative->motivation_value) ? $alternative->motivation_value : '', array('class' => 'form-control')) 
						!!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Mental (Dari hasil observasi dan percakapan):</strong>
						{!! Form::select('mental_value', 
							array(
								'Baik' => 'Baik', 
								'Cukup' => 'Cukup',
								'Kurang' => 'Kurang',
							), 
							isset($alternative->mental_value) ? $alternative->mental_value : '', array('class' => 'form-control')) 
						!!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Pertimbangan Keluarga (Ijin orang tua):</strong>
						{!! Form::select('family_value', 
							array(
								'Diijinkan' => 'Diijinkan', 
								'Tidak Diijinkan' => 'Tidak Diijinkan',
							), 
							isset($alternative->family_value) ? $alternative->family_value : '', array('class' => 'form-control')) 
						!!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Penampilan:</strong>
						{!! Form::select('appearance_value', 
							array(
								'Baik' => 'Baik', 
								'Cukup' => 'Cukup',
								'Kurang' => 'Kurang',
							), 
							isset($alternative->appearance_value) ? $alternative->appearance_value : '', array('class' => 'form-control')) 
						!!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Keterampilan Komunikasi:</strong>
						{!! Form::select('communication_value', 
							array(
								'Baik' => 'Baik', 
								'Cukup' => 'Cukup',
								'Kurang' => 'Kurang',
							), 
							isset($alternative->communication_value) ? $alternative->communication_value : '', array('class' => 'form-control')) 
						!!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Percaya Diri:</strong>
						{!! Form::select('confidence_value', 
							array(
								'Baik' => 'Baik', 
								'Cukup' => 'Cukup',
								'Kurang' => 'Kurang',
							), 
							isset($alternative->confidence_value) ? $alternative->confidence_value : '', array('class' => 'form-control')) 
						!!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Komitmen (Kesanggupan mengikuti pelatihan):</strong>
						{!! Form::select('commitment_value', 
							array(
								'Sanggup' => 'Sanggup', 
								'Ragu-ragu' => 'Ragu-ragu',
								'Tidak Sanggup' => 'Tidak Sanggup',
							), 
							isset($alternative->commitment_value) ? $alternative->commitment_value : '', array('class' => 'form-control')) 
						!!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Pertimbangan ekonomi (Dari pekerjaan orang tua dan tanggungan keluarga):</strong>
						{!! Form::select('economic_value', 
							array(
								'Mapan' => 'Mapan',
								'Cukup' => 'Cukup',
								'Kurang' => 'Kurang', 
							), 
							isset($alternative->economic_value) ? $alternative->economic_value : '', array('class' => 'form-control')) 
						!!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Potensi:</strong>
						{!! Form::select('potential_value', 
							array(
								'Berpotensi' => 'Berpotensi', 
								'Kurang Berpotensi' => 'Kurang Berpotensi',
							), 
							isset($alternative->potential_value) ? $alternative->potential_value : '', array('class' => 'form-control')) 
						!!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Kesungguhan:</strong>
						{!! Form::select('seriousness_value', 
							array(
								'Baik' => 'Baik', 
								'Cukup' => 'Cukup',
								'Kurang' => 'Kurang',
							), 
							isset($alternative->seriousness_value) ? $alternative->seriousness_value : '', array('class' => 'form-control')) 
						!!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Kesan Baik:</strong>
						{!! Form::select('impression_value', 
							array(
								'Baik' => 'Baik', 
								'Cukup' => 'Cukup',
								'Kurang' => 'Kurang',
							), 
							isset($alternative->impression_value) ? $alternative->impression_value : '', array('class' => 'form-control')) 
						!!}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>
	$('#datepicker').datetimepicker({
		format: 'YYYY-MM-DD'
	});
</script>
@endsection