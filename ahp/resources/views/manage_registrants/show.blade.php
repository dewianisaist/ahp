@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection

@section('content_header')
<h1>
  Data Diri
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('manage_registrants.index') }}"><i class="fa fa-users"></i> Data Pendaftar</a></li>
  <li class="active">Data Diri</li>
</ol>
@endsection

@section('content')
<div class="box box-default">
    <div class="box-body">
		<table class="table table-striped">
			<tr>
				<th>No. Identitas</th>
				<td>{{ $user->identity_number }}</td>
			</tr>
			<tr>
				<th>Nama</th>
				<td>{{ $user->name }}</td>
			</tr>
			<tr>
				<th>email</th>
				<td>{{ $user->email }}</td>
			</tr>
			<tr>
				<th>Alamat</th>
				<td>{{ $user->address }}</td>
			</tr>
			<tr>
				<th>No. Telepon/HP</th>
				<td>{{ $user->phone_number }}</td>
			</tr>
			<tr>
				<th>Jenis Kelamin</th>
				<td>{{ $user->gender }}</td>
			</tr>
			<tr>
				<th>Tempat, Tanggal Lahir</th>
				<td>{{ $user->place_birth }}, {{ $user->date_birth }}</td>
			</tr>
			<tr>
				<th>Anak ke-</th>
				<td>{{ $user->order_child }}</td>
			</tr>
			<tr>
				<th>Jumlah Saudara</th>
				<td>{{ $user->amount_sibling }}</td>
			</tr><tr>
				<th>Agama</th>
				<td>{{ $user->religion }}</td>
			</tr>
			<tr>
				<th>Nama Ibu Kandung</th>
				<td>{{ $user->biological_mother_name }}</td>
			</tr>
			<tr>
				<th>Nama Ayah</th>
				<td>{{ $user->father_name }}</td>
			</tr>
			<tr>
				<th>Alamat Orangtua</th>
				<td>{{ $user->parent_address }}</td>
			</tr>
			<tr>
				<th>Pas Foto</th>
				<td><img width="200" src="{{ isset($user->upload->photo) ? URL::to('/uploads/' . $user->upload->photo) : URL::to('/avatars/avatar.png') }}" alt="{{ $user->name }}" /></td>
			</tr>
			<tr>
				<th>KTP</th>
				<td>
					@if(isset($user->upload->ktp))
						<a class="btn btn-success" href="{{ URL::to('/uploads/' . $user->upload->ktp) }}" target="_blank"> Lihat KTP</a>
					@endif
				</td>
			</tr>
			<tr>
				<th>Ijazah Terakhir</th>
				<td>
					@if(isset($user->upload->last_certificate))
						<a class="btn btn-success" href="{{ URL::to('/uploads/' . $user->upload->last_certificate) }}" target="_blank"> Lihat Ijazah Terakhir</a>
					@endif
				</td>
			</tr>
			<tr>
				<th>Riwayat Pendidikan</th>
				<td>
					<table id="table_education" class="table table-hover">
						<thead>
							<tr>
								<th>Jenjang</th>
								<th>Jurusan</th>
								<th>Nama Institusi</th>
								<th>Tahun Lulus</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($educations as $key => $educational_background)
							<tr>
								<td>{{ $educational_background->education->stage }}</td>
								<td>{{ $educational_background->education->major }}</td>
								<td>{{ $educational_background->name_institution }}</td>
								<td>{{ $educational_background->graduation_year }}</td>
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
							@foreach ($courses as $key => $course_experience)
							<tr>
								<td>{{ $course_experience->course->major }}</td>
								<td>{{ $course_experience->organizer }}</td>
								<td>{{ $course_experience->graduation_year }}</td>
							</tr>		
							@endforeach
						</tbody>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>
@endsection
