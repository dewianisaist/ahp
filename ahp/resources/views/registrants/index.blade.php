@extends('layouts.master_registrant')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection

@section('content_header')
<h1>
  Data Diri
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Data Diri</li>
</ol>
@endsection

@section('content')
<div class="box box-default">
    <div class="box-body">
		@if ($message = Session::get('success'))
			<div class="alert alert-success">
				<p>{{ $message }}</p>
			</div>
		@endif

 		<div class="row">
			<div class="col-lg-12 margin-tb">
				<div class="pull-right mb-1">
					<a class="btn btn-success" href="{{ route('registrants.edit') }}"> Edit Data Diri</a>
				</div>
			</div>
   		</div>
		<br/>
    
		<table class="table table-striped">
			<tr>
				<th>Nama</th>
				<td>{{ $user->name }}</td>
			</tr>
			<tr>
				<th>NIK</th>
				<td>{{ $user->identity_number }}</td>
			</tr>
			<tr>
				<th>email</th>
				<td>{{ $user->email }}</td>
			</tr>
			<tr>
				<th>Alamat</th>
				<td>{{ $user->registrant->address }}</td>
			</tr>
			<tr>
				<th>No. Telepon/HP</th>
				<td>{{ $user->registrant->phone_number }}</td>
			</tr>
			<tr>
				<th>Jenis Kelamin</th>
				<td>{{ $user->registrant->gender }}</td>
			</tr>
			<tr>
				<th>Tempat, Tanggal Lahir</th>
				<td>{{ $user->registrant->place_birth }}, {{ $user->registrant->date_birth }}</td>
			</tr>
			<tr>
				<th>Anak ke-</th>
				<td>{{ $user->registrant->order_child }}</td>
			</tr>
			<tr>
				<th>Jumlah Saudara</th>
				<td>{{ $user->registrant->amount_sibling }}</td>
			</tr><tr>
				<th>Agama</th>
				<td>{{ $user->registrant->religion }}</td>
			</tr>
			<tr>
				<th>Nama Ibu Kandung</th>
				<td>{{ $user->registrant->biological_mother_name }}</td>
			</tr>
			<tr>
				<th>Nama Ayah</th>
				<td>{{ $user->registrant->father_name }}</td>
			</tr>
			<tr>
				<th>Alamat Orangtua</th>
				<td>{{ $user->registrant->parent_address }}</td>
			</tr>
			<tr>
				<th>Pas Foto</th>
				<td><img width="200" src="{{ isset($user->registrant->upload->photo) ? URL::to('/uploads/' . $user->registrant->upload->photo) : URL::to('/avatars/avatar.png') }}" alt="{{ $user->registrant->upload->name }}" /></td>
			</tr>
			<tr>
				<th>KTP</th>
				<td>
					@if(isset($user->registrant->upload->ktp))
						<a class="btn btn-success" href="{{ URL::to('/uploads/' . $user->registrant->upload->ktp) }}" target="_blank"> Lihat KTP</a>
					@endif
				</td>
			</tr>
			<tr>
				<th>Ijazah Terakhir</th>
				<td>
					@if(isset($user->registrant->upload->last_certificate))
						<a class="btn btn-success" href="{{ URL::to('/uploads/' . $user->registrant->upload->last_certificate) }}" target="_blank"> Lihat Ijazah Terakhir</a>
					@endif
				</td>
			</tr>
		</table>
	</div>
</div>
@endsection
