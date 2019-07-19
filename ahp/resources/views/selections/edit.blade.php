@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
 
@section('content_header')
<h1>
  Input Nilai Seleksi
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('selections.index') }}"><i class="fa fa-balance-scale"></i> Manajemen Nilai Seleksi</a></li>
  <li class="active">Input Nilai Seleksi</li>
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

		{!! Form::model($selection, ['method' => 'PATCH','route' => ['selections.update', $selection->id]]) !!}
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
            			<strong>Nama Pendaftar:</strong>
						{!! Form::text('name_registrant', isset($selection->name_registrant) ? $selection->name_registrant : '', array('class' => 'form-control','disabled')) !!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
            			<strong>Sub-Kejuruan:</strong>
						{!! Form::text('name_sub_vocational', isset($selection->name_sub_vocational) ? $selection->name_sub_vocational: '', array('class' => 'form-control','disabled')) !!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
            			<strong>Tanggal:</strong>
						{!! Form::text('date', isset($selection->date) ? $selection->date : '', array('class' => 'form-control pull-right','disabled')) !!}
          			</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
            			<strong>Waktu:</strong>
						{!! Form::text('time', isset($selection->time) ? $selection->time : '', array('class' => 'form-control pull-right','disabled')) !!}
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
						{!! Form::text('knowledge_value', isset($selection->knowledge_value) ? $selection->knowledge_value : '', array('placeholder' => 'Nilai Pengetahuan','class' => 'form-control')) !!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Nilai Keterampilan Teknis <small>(Range nilai 0-100)</small>:</strong>
						{!! Form::text('technical_value', isset($selection->technical_value) ? $selection->technical_value : '', array('placeholder' => 'Nilai Keterampilan Teknis','class' => 'form-control')) !!}
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
						{!! Form::text('orientation_value', isset($selection->orientation_value) ? $selection->orientation_value : '', array('placeholder' => 'Rencana setelah selesai pelatihan','class' => 'form-control')) !!}
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
							isset($selection->recommendation) ? $selection->recommendation : '', array('class' => 'form-control')) 
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
							isset($selection->honesty_value) ? $selection->honesty_value : '', array('class' => 'form-control')) 
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
							isset($selection->attitude_value) ? $selection->attitude_value : '', array('class' => 'form-control')) 
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
							isset($selection->motivation_value) ? $selection->motivation_value : '', array('class' => 'form-control')) 
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
							isset($selection->mental_value) ? $selection->mental_value : '', array('class' => 'form-control')) 
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
							isset($selection->family_value) ? $selection->family_value : '', array('class' => 'form-control')) 
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
							isset($selection->appearance_value) ? $selection->appearance_value : '', array('class' => 'form-control')) 
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
							isset($selection->communication_value) ? $selection->communication_value : '', array('class' => 'form-control')) 
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
							isset($selection->confidence_value) ? $selection->confidence_value : '', array('class' => 'form-control')) 
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
							isset($selection->commitment_value) ? $selection->commitment_value : '', array('class' => 'form-control')) 
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
							isset($selection->economic_value) ? $selection->economic_value : '', array('class' => 'form-control')) 
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
							isset($selection->potential_value) ? $selection->potential_value : '', array('class' => 'form-control')) 
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
							isset($selection->seriousness_value) ? $selection->seriousness_value : '', array('class' => 'form-control')) 
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
							isset($selection->impression_value) ? $selection->impression_value : '', array('class' => 'form-control')) 
						!!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Catatan:</strong>
						{!! Form::textarea('note', isset($selection->note) ? $selection->note : '', array('placeholder' => 'Catatan','class' => 'form-control','style'=>'height:100px')) !!}
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

<script>
	$('#timepicker').datetimepicker({
		format: 'HH:mm'
	});
</script>
@endsection