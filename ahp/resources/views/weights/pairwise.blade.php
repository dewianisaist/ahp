@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
  
@section('content_header')
<h1>
  Perbandingan Berpasangan
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('weights.index') }}"><i class="fa fa-balance-scale"></i> Bobot</a></li>
  <li class="active">Perbandingan Berpasangan</li>
</ol>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-body">
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<strong>Maaf!</strong> Ada kesalahan dengan data yang Anda masukkan.<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		@if ($message = Session::get('failed'))
			<div class="alert alert-error">
				<p>{{ $message }}</p>
			</div>
		@endif

    {!! Form::open(array('route' => ['weights.store', $id],'method'=>'PATCH')) !!}
			<table id="table_pairwise" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th colspan="3">Lebih penting A atau B?</th>
            <th>Sama</th>
            <th>Berapa banyak?</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($compares as $key=>$value)
            <tr>
              <td>{{ ++$i }}</td>
              <td>
                <div class="radio">
                  <label>
                  <?php 
                  $checked = "";
                  if ($value["criteria"][0]->id == $value["selected_criteria"]){
                    $checked = "checked";
                  }
                  ?>
                    <input type="radio" name="criteria_id[{{ $key }}]" value="{{ $value["criteria"][0]->id }}" {{ $checked }}> {{ $value["criteria"][0]->name }} 
                  </label>
                </div>
              </td>
              <td>atau</td>
              <td>
                <div class="radio">
                  <label>
                  <?php
                  $checked = "";
                  if ($value["criteria"][1]->id == $value["selected_criteria"]){
                    $checked = "checked";
                  }
                  ?>
                    <input type="radio" name="criteria_id[{{ $key }}]" value="{{ $value["criteria"][1]->id }}" {{ $checked }}> {{ $value["criteria"][1]->name }} 
                  </label>
                </div>
              </td>
              <td>
                <?php 
                  $checked = "";
                  if ($value["value"] == 1){
                    $checked = 'checked';
                  }
                ?>
                <div class="radio">
                  <label>
                    <input type="radio" name="value[{{ $key }}]" value=1 {{ $checked }}> 1 
                  </label>
                </div>
              </td>
              <td>
                <div class="radio">
                @for ($j = 2; $j <= 9; $j++)
                  <label>
                  @if ($j == $value["value"])
                    <input type="radio" name="value[{{ $key }}]" value={{ $j }} checked>{{ $j }}
                  @else
                  <input type="radio" name="value[{{ $key }}]" value={{ $j }}>{{ $j }}
                  @endif
                  </label>
                @endfor
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="col-xs-12 col-sm-12 col-md-12 text-center">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
      {!! Form::close() !!}
	</div>
</div>
@endsection