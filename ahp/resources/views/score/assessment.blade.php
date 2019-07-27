@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
 
@section('content_header')
<h1>
  Penilaian Data Alternatif
</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('manage_alternatives.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('score.index') }}"><i class="fa fa-hourglass-half"></i> Manajemen Data Alternatif</a></li>
  <li class="active">Penilaian Data Alternatif</li>
</ol>
@endsection
 
@section('content')
<div class="box box-primary">
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
		{!! Form::model($data, ['method' => 'PATCH','route' => ['score.store', $data->id]]) !!}
        <table id="table_assessment" class="table table-bordered table-striped">
            <thead>
				<tr>
					<th>No</th>
					<th>Kriteria/Sub-Kriteria</th>
					<th>Nilai</th>
					<th>Informasi Konversi</th>
				</tr>
			</thead>
			<tbody>        
                @foreach ($return_data as $single_data)
                    <tr>
                        <td width="5px">{{ ++$i }}</td>
                        <th width="400px">{{ $single_data['criteria']->name }}</th>
						@if ($single_data['value'] == null)
							<td width="400px">{!! Form::text($single_data['criteria']->id, null, array('placeholder' => 'Nilai (Sudah dikonversi ke data kuantitatif)','class' => 'form-control')) !!}</td>
						@else
                        	<td width="400px">{!! Form::text($single_data['criteria']->id, $single_data['value']->value, array('placeholder' => 'Nilai (Sudah dikonversi ke data kuantitatif)','class' => 'form-control')) !!}</td>
						@endif
                        <td>{!! nl2br(e($single_data['criteria']->information)) !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        {!! Form::close() !!}

        <br/><br/>
        <h3>Referensi Penilaian</h3>
        <table class="table table-striped">
			<tr>
				<th>Nama Pendaftar</th>
				<td>{{ $data->name }}</td>
			</tr>
			<tr>
				<th>Tanggal Lahir</th>
				<td>{{ $data->date_birth }}</td>
			</tr>
			<tr>
				<th>Usia</th>
				<td>{{ $age }}</td>
			</tr>
			<tr>
				<th>Pendidikan Terakhir</th>
				<td>{{ $data->last_education }}</td>
			</tr>
			<tr>
				<th>Intensitas Keikutsertaan</th>
				<td>{{ $data->intensity_participation }}</td>
			</tr>
			<tr>
				<th>Pengalaman Pelatihan</th>
				<td>{{ $data->course_experience }}</td>
			</tr>
            <tr>
				<th>Nilai Seleksi</th>
				<td>
					<table id="table_selection" class="table table-hover">
                        <tr>
                            <th>Nilai Pengetahuan</th>
                            <td>{{ $data->knowledge_value }}</td>
                        </tr>
						<tr>
                            <th>Nilai Keterampilan Teknis</th>
                            <td>{{ $data->technical_value }}</td>
                        </tr>
						<tr>
                            <th>Rencana setelah selesai pelatihan</th>
                            <td>{{ $data->orientation_value }}</td>
                        </tr>
                        <tr>
                            <th width = "350px">Rekomendasi</th>
                            <td>{{ $data->recommendation }}</td>
                        </tr>
						<tr>
							<th>Kejujuran (Kesesuaian antara jawaban dengan data)</th>
							<td>{{ $data->honesty_value }}</td>
						</tr>
						<tr>
							<th>Sikap</th>
							<td>{{ $data->attitude_value }}</td>
						</tr>
						<tr>
							<th>Motivasi</th>
							<td>{{ $data->motivation_value }}</td>
						</tr>
						<tr>
							<th>Mental (Dari hasil observasi dan percakapan)</th>
							<td>{{ $data->mental_value }}</td>
						</tr>
						<tr>
							<th>Pertimbangan Keluarga (Ijin orang tua)</th>
							<td>{{ $data->family_value }}</td>
						</tr>
						<tr>
							<th>Penampilan</th>
							<td>{{ $data->appearance_value }}</td>
						</tr>
						<tr>
							<th>Keterampilan Komunikasi</th>
							<td>{{ $data->communication_value }}</td>
						</tr>
						<tr>
							<th>Percaya Diri</th>
							<td>{{ $data->confidence_value }}</td>
						</tr>
						<tr>
							<th>Komitmen (Kesanggupan mengikuti pelatihan)</th>
							<td>{{ $data->commitment_value }}</td>
						</tr>
						<tr>
							<th>Pertimbangan ekonomi (Dari pekerjaan orang tua dan tanggungan keluarga)</th>
							<td>{{ $data->economic_value }}</td>
						</tr>
						<tr>
							<th>Potensi</th>
							<td>{{ $data->potential_value }}</td>
						</tr>
						<tr>
							<th>Kesungguhan</th>
							<td>{{ $data->seriousness_value }}</td>
						</tr>
						<tr>
							<th>Kesan Baik</th>
							<td>{{ $data->impression_value }}</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>
@endsection