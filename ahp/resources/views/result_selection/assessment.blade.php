@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
 
@section('content_header')
<h1>
  Penilaian Data Alternatif
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('result_selection.index') }}"><i class="fa fa-hourglass-half"></i> Manajemen Data Alternatif</a></li>
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
		{!! Form::model($data, ['method' => 'PATCH','route' => ['result_selection.store', $data->ID_SELECTION]]) !!}
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
				<th>No. Identitas</th>
				<td>{{ $data->identity_number }}</td>
			</tr>
			<tr>
				<th>Nama Pendaftar</th>
				<td>{{ $data->name }}</td>
			</tr>
			<tr>
				<th>email</th>
				<td>{{ $data->email }}</td>
			</tr>
			<tr>
				<th>Alamat</th>
				<td>{{ $data->address }}</td>
			</tr>
			<tr>
				<th>No. Telepon/HP</th>
				<td>{{ $data->phone_number }}</td>
			</tr>
			<tr>
				<th>Jenis Kelamin</th>
				<td>{{ $data->gender }}</td>
			</tr>
			<tr>
				<th>Tempat, Tanggal Lahir</th>
				<td>{{ $data->place_birth }}, {{ $data->date_birth }}</td>
			</tr>
			<tr>
				<th>Usia</th>
				<td>{{ $age }}</td>
			</tr>
			<tr>
				<th>Anak ke-</th>
				<td>{{ $data->order_child }}</td>
			</tr>
			<tr>
				<th>Jumlah Saudara</th>
				<td>{{ $data->amount_sibling }}</td>
			</tr><tr>
				<th>Agama</th>
				<td>{{ $data->religion }}</td>
			</tr>
			<tr>
				<th>Nama Ibu Kandung</th>
				<td>{{ $data->biological_mother_name }}</td>
			</tr>
			<tr>
				<th>Nama Ayah</th>
				<td>{{ $data->father_name }}</td>
			</tr>
			<tr>
				<th>Alamat Orangtua</th>
				<td>{{ $data->parent_address }}</td>
			</tr>
			<tr>
				<th>Pas Foto</th>
				<td><img width="200" src="{{ isset($upload->photo) ? URL::to('/uploads/' . $upload->photo) : URL::to('/avatars/avatar.png') }}" alt="{{ $data->name }}" /></td>
			</tr>
			<tr>
				<th>KTP</th>
				<td>
					@if(isset($upload->ktp))
						<a class="btn btn-success" href="{{ URL::to('/uploads/' . $upload->ktp) }}" target="_blank"> Lihat KTP</a>
					@endif
				</td>
			</tr>
			<tr>
				<th>Ijazah Terakhir</th>
				<td>
					@if(isset($upload->last_certificate))
						<a class="btn btn-success" href="{{ URL::to('/uploads/' . $upload->last_certificate) }}" target="_blank"> Lihat Ijazah Terakhir</a>
					@endif
				</td>
			</tr>
			<tr>
				<th>Riwayat Pendidikan</th>
				<td>
					<table id="table_education_background" class="table table-hover">
						<thead>
							<tr>
								<th>Jenjang</th>
								<th>Jurusan</th>
								<th>Nama Institusi</th>
								<th>Tahun Lulus</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($educational_background as $key => $riwayat_pendidikan)
                                <tr>
                                    <td>{{ $riwayat_pendidikan->education->stage }}</td>
                                    <td>{{ $riwayat_pendidikan->education->major }}</td>
                                    <td>{{ $riwayat_pendidikan->name_institution }}</td>
                                    <td>{{ $riwayat_pendidikan->graduation_year }}</td>
                                </tr>		
							@endforeach
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<th>Pengalaman Kursus</th>
				<td>
					<table id="table_course_experience" class="table table-hover">
						<thead>
							<tr>
								<th>Jurusan</th>
								<th>Penyelenggara</th>
								<th>Tahun Lulus</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($course_experience as $key => $pengalaman_kursus)
                                <tr>
                                    <td>{{ $pengalaman_kursus->course->major }}</td>
                                    <td>{{ $pengalaman_kursus->organizer }}</td>
                                    <td>{{ $pengalaman_kursus->graduation_year }}</td>
                                </tr>		
							@endforeach
						</tbody>
					</table>
				</td>
			</tr>
            <tr>
				<th>Riwayat Pendaftaran Kursus di BLK</th>
				<td>
					<table id="table_registration" class="table table-hover">
						<thead>
							<tr>
                                <th>No</th>
                                <th>Sub-Kejuruan</th>
                                <th>Tanggal Daftar</th>
                                <th>Tanggal dan Waktu Seleksi</th>
                                <th>Status</th>
							</tr>
						</thead>
						<tbody>
                        @foreach ($registration as $key => $riwayat_pendaftaran)
                            <tr>
                                <td>{{ ++$j }}</td>
                                <td>{{ $riwayat_pendaftaran->name }}</td>
                                <td>{{ $riwayat_pendaftaran->register_date }}</td>
                                <td>{{ $riwayat_pendaftaran->date }} dan {{ $riwayat_pendaftaran->time }}</td>
                                <td>
                                    @if ($riwayat_pendaftaran->status == '') 
                                        Sedang Proses Penilaian
                                    @else
                                        {{ $riwayat_pendaftaran->status }}
                                    @endif
                                </td>
                            </tr>		
                        @endforeach
						</tbody>
					</table>
				</td>
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
						<tr>
							<th>Catatan</th>
							<td>{!! nl2br(e($data->note)) !!}</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>
@endsection