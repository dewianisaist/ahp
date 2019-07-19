@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
 
@section('content_header')
<h1>
Hasil Seleksi Peserta Pelatihan
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Hasil Seleksi Peserta Pelatihan</li>
</ol>
@endsection

@section('content')
<div class="box">
  <div class="box-body">
    <table id="table_result" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Peringkat</th>
          <th>Nama Pendaftar</th>
          <th>Sub-Kejuruan</th>
          <th>Tanggal dan Waktu Seleksi</th>
          <th>Nilai Seleksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($result as $key => $result_selection)
          <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $result_selection->name_registrant }}</td>
            <td>{{ $result_selection->name_sub_vocational }}</td>
            <td>{{ $result_selection->date }} dan {{ $result_selection->time }}</td>
            <td>{{ $result_selection->final_score }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
	</div>
</div>	
@endsection
