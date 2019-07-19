@extends('layouts.master_registrant')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
@endsection

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
 
@section('content_header')
<h1>
  Edit Data Diri
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('registrants.index') }}"><i class="fa fa-users"></i> Data Diri</a></li>
  <li class="active">Edit Data Diri</li>
</ol>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-body">
        @if ($message = Session::get('failed'))
			<div class="alert alert-error">
				<p>{{ $message }}</p>
			</div>
		@endif
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
        {!! Form::model($user, ['method' => 'PATCH','route' => ['registrants.update', isset($user->registrant->id) ? $user->registrant->id : $user->user_id], 'files' => true]) !!}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama:</strong>
                        {!! Form::text('name', $user->name, array('placeholder' => 'Nama','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>No. Identitas:</strong>
                        {!! Form::text('identity_number', $user->identity_number, array('placeholder' => 'No. Identitas berupa NIK','class' => 'form-control','disabled')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        {!! Form::text('email', $user->email, array('placeholder' => 'Email','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Password:</strong>
                        {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Konfirmasi Password:</strong>
                        {!! Form::password('confirm-password', array('placeholder' => 'Konfirmasi Password','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Alamat:</strong>
						{!! Form::textarea('address', isset($user->registrant->address) ? $user->registrant->address : '', array('placeholder' => 'Alamat','class' => 'form-control','style'=>'height:100px')) !!}
					</div>
				</div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>No. Telepon:</strong>
                        {!! Form::text('phone_number', isset($user->registrant->phone_number) ? $user->registrant->phone_number : '', array('placeholder' => 'No. Telepon','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
                        <strong>Jenis Kelamin:</strong>
						{!! Form::select('gender', array('Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan'), isset($user->registrant->gender) ? $user->registrant->gender : '', array('class' => 'form-control')) !!}
					</div>
				</div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tempat, Tanggal Lahir:</strong>
                        <br/>
                        <div class="row">
                            <div class="col-xs-4">
                                {!! Form::text('place_birth', isset($user->registrant->place_birth) ? $user->registrant->place_birth : '', array('placeholder' => 'Tempat Lahir','class' => 'form-control')) !!}
                            </div>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                {!! Form::text('date_birth', isset($user->registrant->date_birth) ? $user->registrant->date_birth : '', array('placeholder' => 'Tanggal Lahir','class' => 'form-control pull-right', 'id' => 'datepicker')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Anak ke-:</strong>
                        {!! Form::text('order_child', isset($user->registrant->order_child) ? $user->registrant->order_child : '', array('placeholder' => 'Anak ke-','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Jumlah Saudara:</strong>
                        {!! Form::text('amount_sibling', isset($user->registrant->amount_sibling) ? $user->registrant->amount_sibling : '', array('placeholder' => 'Jumlah Saudara','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Agama:</strong>
                        {!! Form::select('religion', 
                            array(
                                'Islam' => 'Islam', 
                                'Katolik' => 'Katolik',
                                'Kristen' => 'Kristen',
                                'Hindu' => 'Hindu',
                                'Budha' => 'Budha',
                                'Konghucu' => 'Konghucu'
                            ), 
                            isset($user->registrant->religion) ? $user->registrant->religion : '', array('class' => 'form-control')) 
                        !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama Ibu Kandung:</strong>
                        {!! Form::text('biological_mother_name', isset($user->registrant->biological_mother_name) ? $user->registrant->biological_mother_name : '', array('placeholder' => 'Nama Ibu Kandung','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama Ayah:</strong>
                        {!! Form::text('father_name', isset($user->registrant->father_name) ? $user->registrant->father_name : '', array('placeholder' => 'Nama Ayah','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Alamat Orangtua:</strong>
						{!! Form::textarea('parent_address', isset($user->registrant->parent_address) ? $user->registrant->parent_address : '', array('placeholder' => 'Alamat Orangtua','class' => 'form-control','style'=>'height:100px')) !!}
					</div>
				</div>
                <div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Pas Foto <small>(Format file: jpeg/png/jpg, Ukuran maksimal 2 MB)</small>:</strong>
						{!! Form::file('photo', null, array('class' => 'custom-file-control')) !!}
					</div>
				</div>
                <div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>KTP <small>(Format file: pdf/doc/docx, Ukuran maksimal 2 MB)</small>:</strong>
						{!! Form::file('ktp', null, array('class' => 'custom-file-control')) !!}
					</div>
				</div>
                <div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<strong>Ijazah Terakhir <small>(Format file: pdf/doc/docx, Ukuran maksimal 2 MB)</small>:</strong>
						{!! Form::file('last_certificate', null, array('class' => 'custom-file-control')) !!}
					</div>
				</div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>
	$('#datepicker').datetimepicker({
		format: 'YYYY-MM-DD'
	});
</script>
@endsection