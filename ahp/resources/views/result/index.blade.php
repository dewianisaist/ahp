@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
 
@section('content_header')
<h1>
Hasil Ranking PROMETHEE
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Hasil Ranking PROMETHEE</li>
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
          <th>Nilai PROMETHEE</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($result as $key => $result_selection)
          <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $result_selection->name }}</td>
            <td>{{ $result_selection->score_promethee }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
	</div>
</div>	
@endsection
