@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection

@section('content_header')
<h1>
  Data Diri
</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('manage_alternatives.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('manage_alternatives.index') }}"><i class="fa fa-users"></i> Data Pendaftar</a></li>
  <li class="active">Data Diri</li>
</ol>
@endsection

@section('content')
<div class="box box-default">
    <div class="box-body">
		<table class="table table-striped">
			<tr>
				<th class="col-xs-3">Nama</th>
				<td>{{ $alternative->name }}</td>
			</tr>
			<tr>
				<th>Tanggal Lahir</th>
				<td>{{ $alternative->date_birth }}</td>
			</tr>
			<tr>
				<th>Pendidikan Terakhir</th>
				<td>{{ $alternative->last_education }}</td>
			</tr>
			<tr>
				<th>Intensitas Keikutsertaan</th>
				<td>{{ $alternative->intensity_participation }}</td>
			</tr>
			<tr>
				<th>Pengalaman Pelatihan</th>
				<td>{{ $alternative->course_experience }}</td>
			</tr>
			<tr>
				<th>Nilai Pengetahuan</th>
				<td>{{ $alternative->knowledge_value }}</td>
			</tr>
			<tr>
				<th>Nilai Keterampilan Teknis</th>
				<td>{{ $alternative->technical_value }}</td>
			</tr>
			<tr>
				<th>Rencana setelah selesai pelatihan</th>
				<td>{{ $alternative->orientation_value }}</td>
			</tr>
			<tr>
				<th>Rekomendasi</th>
				<td>{{ $alternative->recommendation }}</td>
			</tr>
			<tr>
				<th>Kejujuran</th>
				<td>{{ $alternative->honesty_value }}</td>
			</tr>
			<tr>
				<th>Sikap</th>
				<td>{{ $alternative->attitude_value }}</td>
			</tr>
			<tr>
				<th>Motivasi</th>
				<td>{{ $alternative->motivation_value }}</td>
			</tr>
			<tr>
				<th>Mental</th>
				<td>{{ $alternative->mental_value }}</td>
			</tr>
			<tr>
				<th>Pertimbangan Keluarga</th>
				<td>{{ $alternative->family_value }}</td>
			</tr>
			<tr>
				<th>Penampilan</th>
				<td>{{ $alternative->appearance_value }}</td>
			</tr>
			<tr>
				<th>Keterampilan Komunikasi</th>
				<td>{{ $alternative->communication_value }}</td>
			</tr>
			<tr>
				<th>Percaya Diri</th>
				<td>{{ $alternative->confidence_value }}</td>
			</tr>
			<tr>
				<th>Komitmen</th>
				<td>{{ $alternative->commitment_value }}</td>
			</tr>
			<tr>
				<th>Pertimbangan ekonomi</th>
				<td>{{ $alternative->economic_value }}</td>
			</tr>
			<tr>
				<th>Potensi</th>
				<td>{{ $alternative->potential_value }}</td>
			</tr>
			<tr>
				<th>Kesungguhan</th>
				<td>{{ $alternative->seriousness_value }}</td>
			</tr>
			<tr>
				<th>Kesan Baik</th>
				<td>{{ $alternative->impression_value }}</td>
			</tr>
		</table>
	</div>
</div>
@endsection
