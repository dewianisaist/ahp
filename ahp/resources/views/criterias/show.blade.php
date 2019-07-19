@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
  
@section('content_header')
<h1>
  Detail Kriteria 
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('criterias.index') }}"><i class="fa fa-list"></i> Manajemen Kriteria dari Kajian Pustaka</a></li>
  <li class="active">Detail Kriteria</li>
</ol>
@endsection

@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $criteria->name }}</h3>
    </div>
    <div class="box-body">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<strong>Kriteria:</strong>
					{{ $criteria->name }}
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<strong>Penjelasan Kriteria:</strong>
					{!! nl2br(e($criteria->description)) !!}
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<strong>Sumber Pustaka:</strong>
					{!! nl2br(e($criteria->citation)) !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection