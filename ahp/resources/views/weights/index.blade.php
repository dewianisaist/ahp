@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
  
@section('content_header')
<h1>
   Bobot
</h1>
<ol class="breadcrumb">
    <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Bobot</li>
</ol>
@endsection

@section('content')
<div class="box">
    <div class="box-body">
        <div class="alert alert-warning alert-dismissible">
            <h4><i class="icon fa fa-warning"></i> Peringatan!</h4>
            <ul>
                <li>Silahkan isi <strong>semua pairwise comparison</strong> terlebih dahulu, klik button AHP.</li>
            </ul>
        </div>

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

		<table id="table_table_weight" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th width = "550px">Kriteria/Sub-Kriteria</th>
                    <th>Pairwise Comparison</th>
                    <th>Bobot Parsial</th>
					<th>Bobot Global</th>
				</tr>
			</thead>
			<tbody>
                <tr>
					<th colspan = "2">Tujuan: SPK Seleksi Peserta Pelatihan </th>
                    <th colspan = "3">
                    <?php
                        $parent = 0
                    ?>
                        @if ($criterias_group != null)
                            <a class="btn btn-success" href="{{ route('weights.pairwise', $parent) }}">AHP</a>
                        @endif
                    </th>
				</tr>
				@foreach ($criterias_group as $value)
					<tr>
						<td align ="center" bgcolor="#F0FBD6">{{ ++$i }}</td>
						<td bgcolor="#F0FBD6">{{ $value["group"]["name"] }}</td>
                        <td bgcolor="#F0FBD6"> 
                        @if (count($value["data"]) > 0)
                            <a class="btn btn-success" href="{{ route('weights.pairwise', $value['group']['id']) }}">AHP</a>
                        @endif
                        </td>
						<td bgcolor="#F0FBD6">{{ $value["group"]["partial_weight"] }}</td>
                        <td bgcolor="#F0FBD6">{{ $value["group"]["global_weight"] }}</td>
					</tr>
                    @if (count($value["data"]) > 0)
                        @foreach ($value["data"] as $crit)
                            <tr>
                                {!! Form::open(array('route' => 'criteriagroup.out','method'=>'POST')) !!}
                                    <td width = "50px" align ="right" bgcolor="#FDFDFD"></td>
                                    <td bgcolor="#FDFDFD"><li>{{ $crit->name }}</li></td>
                                    <td bgcolor="#FDFDFD"></td>
                                    <td bgcolor="#FDFDFD">{{ $crit->partial_weight }}</td>
                                    <td bgcolor="#FDFDFD">{{ $crit->global_weight }}</td>
                                {!! Form::close() !!}
                            </tr>
                        @endforeach
                    @endif
				@endforeach
			</tbody>
		</table>
    </div>
</div>
@endsection
