@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
  
@section('content_header')
<h1>
  Input Tipe Preferensi
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('preferences.index') }}"><i class="fa fa-hourglass-half"></i> Tipe Preferensi</a></li>
  <li class="active">Input Tipe Preferensi</li>
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
		{!! Form::model($preference, ['method' => 'PATCH','route' => ['preferences.update', $preference->id]]) !!}
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Kriteria:</strong>
						{!! Form::text('name', isset($preference->name) ? $preference->name : '', array('placeholder' => 'Nama Kriteria','class' => 'form-control','disabled')) !!}
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Tipe Preferensi:</strong>
            {!! Form::select('preference', 
              array(
                  '1' => 'Tipe 1: Usual Criterion', 
                  '2' => 'Tipe 2: U-shape Criterion',
                  '3' => 'Tipe 3: V-shape Criterion',
                  '4' => 'Tipe 4: Level Criterion',
                  '5' => 'Tipe 5: V-shape with indifference Criterion',
                  '6' => 'Tipe 6: Gaussian Criterion'
              ), 
              isset($preference->preference) ? $preference->preference : '', array('class' => 'form-control', 'id' => 'preference')) 
            !!}
					</div>
				</div>
        <div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Kaidah (Maks/Min):</strong>
            {!! Form::select('max_min', 
              array(
                  'Maksimasi' => 'Maksimasi', 
                  'Minimasi' => 'Minimasi',
              ), 
              isset($preference->max_min) ? $preference->max_min : '', array('class' => 'form-control')) 
            !!}
					</div>
				</div>
        <div id="parameter_p" class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Parameter p:</strong>
						{!! Form::text('parameter_p', isset($preference->parameter_p) ? $preference->parameter_p : '', array('placeholder' => 'Parameter p','class' => 'form-control')) !!}
					</div>
				</div>
        <div id="parameter_q" class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Parameter q:</strong>
						{!! Form::text('parameter_q', isset($preference->parameter_q) ? $preference->parameter_q : '', array('placeholder' => 'Parameter q','class' => 'form-control')) !!}
					</div>
				</div>
        <div id="parameter_s" class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Parameter s:</strong>
						{!! Form::text('parameter_s', isset($preference->parameter_s) ? $preference->parameter_s : '', array('placeholder' => 'Parameter s','class' => 'form-control')) !!}
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
    $("#preference").change(function () {
			$( "#preference option:selected").each(function(){
        if ($(this).val() == "1") {
					$("#parameter_p").hide();
					$("#parameter_q").hide();
					$("#parameter_s").hide();
        } else if ($(this).val() == "2") {
					$("#parameter_p").hide();
					$("#parameter_q").show();
					$("#parameter_s").hide();
        } else if ($(this).val() == "3") {
					$("#parameter_p").show();
					$("#parameter_q").hide();
					$("#parameter_s").hide();
        } else if ($(this).val() == "4" || $(this).val() == "5") {
					$("#parameter_p").show();
					$("#parameter_q").show();
					$("#parameter_s").hide();
				} else {
					$("#parameter_p").hide();
					$("#parameter_q").hide();
					$("#parameter_s").show();
				}
			});
		}).change();
  });
</script>
@endsection