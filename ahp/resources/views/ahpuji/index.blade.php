@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
   
@section('content_header')
<h1>
  RANK WITH AHP
</h1>
<ol class="breadcrumb">
  <li><a href="{{ route('manage_alternatives.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Tipe Preferensi</li>
</ol>
@endsection

@section('content')
<div class="box">
	<div class="box-body">
		@if ($message = Session::get('success'))
			<div class="alert alert-success">
				<p>{{ $message }}</p>
			</div>
		@endif

		<br/>
    	<table id="table_preferences" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Ranking</th>
					<th>Pendaftar</th>
					<th>Nilai</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0 ?>
				@foreach ($sortedGlobalAlternativesPriorityMap as $value)
					<?php
						$namaPeserta = searchNamaPeserta( $globalAlternativesPriorityMap, $value );
						unset( $globalAlternativesPriorityMap[ $namaPeserta ] );
					?>
					<tr>
						<td>{{ ++$i }}</td>
						<td>{{ $namaPeserta }}</td>
						<td>{{ $value }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>	
@endsection

<?php
function searchNamaPeserta( $globalAlternativesPriorityMap, $toSearchValue ){
    foreach($globalAlternativesPriorityMap as $namaPeserta => $value){
    	if( $value == $toSearchValue ){
    		return $namaPeserta;
    	}
	}
	return '-';
}
?>